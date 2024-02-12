<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\License;
use App\Models\Project;
use App\Models\GroupLicense;
use App\Models\GroupProject;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Staff;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Barryvdh\DomPDF\Facade as PDF;

use App\Models\GroupLicenseLog;
use App\Models\GroupProjectLog;
use App\Models\Log;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Dompdf\Dompdf;
use Maatwebsite\Excel\Concerns\WithMapping;



class GroupController extends Controller
{
    public function index(Request $request)
    {
        $sortOrder = $request->input('sort_order', 'latest');
    
        $groups = Group::withTrashed(['groupLicenses' => function ($query) {
                $query->whereNull('deleted_at');
            }, 'groupProjects' => function ($query) {
                $query->whereNull('deleted_at')->with('project');
            }])
            ->orderByRaw('deleted_at ASC, deleted_at IS NULL');
    
        if ($sortOrder == 'latest') {
            $groups->orderBy('deleted_at', 'asc')->orderBy('updated_at', 'desc');
        } elseif ($sortOrder == 'alphabet') {
            $groups->orderBy('deleted_at', 'asc')->orderBy('group_name', 'asc');
        }
    
        $groups = $groups->get();
    
        return view('groups.index', compact('groups', 'sortOrder'));
    }

    public function searchGroup(Request $request) {
        $searchText = $request->search;

        $groups=Group::where('group_name', 'LIKE', "%$searchText%")->get();

        return view('groups.index', compact('groups'));
    }

    public function create()
    {
        $licenses = License::whereNull('deleted_at')->get();
        $projects = Project::whereNull('deleted_at')->get();

        return view('groups.create', compact('licenses', 'projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'group_name' => 'required|string|max:100|unique:groups',
            'group_desc' => 'nullable|string',
            'licenses' => 'array',
            'projects' => 'array',
        ]);

        // create a new group
        $group = Group::create([
            'group_name' => $request->input('group_name'),
            'group_desc' => $request->input('group_desc'),
        ]);

        // attach licenses by IDs
        $licenses = $request->input('licenses', []);
        $group->licenses()->attach($licenses, ['license_name' => '']);

        // attach projects by IDs
        $projects = $request->input('projects', []);
        $group->projects()->attach($projects, ['project_name' => '']);

        // log creations for group licenses
        foreach ($licenses as $licenseId) {
            GroupLicenseLog::create([
                'user_id' => auth()->id(),
                'group_id' => $group->group_id,
                'license_id' => $licenseId,
                'action_type' => 'create',
            ]);
        }

        // log creations for group projects
        foreach ($projects as $projectId) {
            GroupProjectLog::create([
                'user_id' => auth()->id(),
                'group_id' => $group->group_id,
                'project_id' => $projectId,
                'action_type' => 'create',
            ]);
        }

                // ltore the ID of the created group in the session
                session(['recently_created_or_updated_group' => $group->group_id]);

        return redirect()->route('groups.index');
    }

    public function destroy($group_id)
    {
        $group = Group::findOrFail($group_id);

        // check if there are related staff
        $relatedStaffCount = Staff::where('group_id', $group_id)->count();

        if ($relatedStaffCount > 0) {
            // cisplay a message that the group has staff
            return redirect()->route('groups.index')->with('error', 'Cannot delete the group. The group has staff.');
        }

        // no related staff, proceed with deletion
        $group->delete();

        return redirect()->route('groups.index')->with('success', 'The selected group deactivated!');
    }


    public function restore($group_id)
    {
        $group = Group::withTrashed()->findOrFail($group_id);

        // restore the soft-deleted license
        $group->restore();

        return redirect()->route('groups.index')->with('success', 'Group reactivated!');
    }

    public function edit(Group $group)
    {
        $licenses = License::whereNull('deleted_at')->get();
        $projects = Project::whereNull('deleted_at')->get();

        // fetch licenses and projects for the group
        $groupLicenses = GroupLicense::where('group_id', $group->group_id)->get();
        $groupProjects = GroupProject::where('group_id', $group->group_id)->get();

        // extract license and project IDs from pivot tables
        $selectedLicenses = $groupLicenses->pluck('license_id')->toArray();
        $selectedProjects = $groupProjects->pluck('project_id')->toArray();

        return view('groups.edit', compact('group', 'licenses', 'projects'));
    }

    public function update(Request $request, Group $group)
    {
        $request->validate([
            'group_name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('groups', 'group_name')->ignore($group->group_id, 'group_id'),
            ],
            'group_desc' => 'nullable|string',
            'licenses' => 'array',
            'projects' => 'array',
        ]);

        // update group details
        $group->update([
            'group_name' => $request->input('group_name'),
            'group_desc' => $request->input('group_desc'),
        ]);

        // sync licenses by IDs (including license_name)
        $licenses = $request->input('licenses', []);
        $syncData = [];

        foreach ($licenses as $licenseId) {
            $license = License::find($licenseId);
            $syncData[$licenseId] = ['license_name' => $license->license_name];
        }

        $group->licenses()->sync($syncData);

        // sync projects by IDs (including project_name)
        $projects = $request->input('projects', []);
        $projectSyncData = [];

        foreach ($projects as $projectId) {
            $project = Project::find($projectId);
            $projectSyncData[$projectId] = ['project_name' => $project->project_name];
        }

        $group->projects()->sync($projectSyncData);

        // log changes for group licenses
        $licenses = $request->input('licenses', []);
        $existingLicenses = $group->licenses->pluck('license_id')->toArray();

        // log creations
        foreach (array_diff($licenses, $existingLicenses) as $licenseId) {
            GroupLicenseLog::create([
                'user_id' => auth()->id(),
                'group_id' => $group->group_id,
                'license_id' => $licenseId,
                'action_type' => 'create',
            ]);

            // sync licenses by IDs (including license_name)
            $group->licenses()->sync([$licenseId => ['license_name' => License::find($licenseId)->license_name]]);
        }

        // log deletions
        foreach (array_diff($existingLicenses, $licenses) as $licenseId) {
            GroupLicenseLog::create([
                'user_id' => auth()->id(),
                'group_id' => $group->group_id,
                'license_id' => $licenseId,
                'action_type' => 'delete',
            ]);

            // detach licenses by IDs
            $group->licenses()->detach($licenseId);
        }

        // log changes for group projects
        $projects = $request->input('projects', []);
        $existingProjects = $group->projects->pluck('project_id')->toArray();

        // log creations
        foreach (array_diff($projects, $existingProjects) as $projectId) {
            GroupProjectLog::create([
                'user_id' => auth()->id(),
                'group_id' => $group->group_id,
                'project_id' => $projectId,
                'action_type' => 'create',
            ]);

            // sync projects by IDs (including project_name)
            $group->projects()->sync([$projectId => ['project_name' => Project::find($projectId)->project_name]]);
        }

        // log deletions
        foreach (array_diff($existingProjects, $projects) as $projectId) {
            GroupProjectLog::create([
                'user_id' => auth()->id(),
                'group_id' => $group->group_id,
                'project_id' => $projectId,
                'action_type' => 'delete',
            ]);

            // detach projects by IDs
            $group->projects()->detach($projectId);
        }

            // store the ID of the created group in the session
            session(['recently_created_or_updated_group' => $group->group_id]);

        return redirect()->route('groups.index');
    }

    public function show_staff(Group $group)
    {
        $groupName = $group->group_name;
        $staffs = Staff::where('group_id', $group->group_id)->get();

        return view('groups.show_staff', compact('staffs', 'groupName'));
    }

    public function __construct()
    {
        $this->middleware('auth');
    }



    public function exportListGroup($format)
    {
        if ($format === 'xls') {
            return Excel::download(new GroupListExport, 'groups_list.xls');
        } elseif ($format === 'pdf') {
            $pdf = app('dompdf.wrapper'); 
            $pdf->loadView('exports.groups_list', ['groups' => Group::withTrashed()->get()]);
            return $pdf->download('groups_list.pdf');
        } else {
            return redirect()->route('groups.index')->with('error', 'Invalid export format.');
        }
    }

    public function exportLogGroup($format)
    {
        switch ($format) {
            case 'xls':
                $combinedLogsExport = new GroupLogXlsExport();
                return Excel::download($combinedLogsExport, 'groups_log.xls');
                break;
            case 'pdf':
                // fetch data for all three tables
                $generalLogs = Log::leftJoin('users', 'logs.user_id', '=', 'users.user_id')
                    ->where('logs.table_name', 'groups')
                    ->select(
                        'logs.log_id',
                        'logs.user_id',
                        'users.name as user_name',
                        'logs.type_action',
                        'logs.table_name',
                        'logs.record_id',
                        'logs.record_name',
                        'logs.column_name',
                        'logs.old_value',
                        'logs.new_value',
                        'logs.created_at'
                    )
                    ->get();

                $licenseLogs = GroupLicenseLog::leftJoin('users', 'group_license_logs.user_id', '=', 'users.user_id')
                    ->leftJoin('groups', 'group_license_logs.group_id', '=', 'groups.group_id')
                    ->leftJoin('licenses', 'group_license_logs.license_id', '=', 'licenses.license_id')
                    ->select(
                        'group_license_logs.id',
                        'group_license_logs.user_id',
                        'users.name as user_name',
                        'group_license_logs.action_type',
                        'group_license_logs.group_id',
                        'groups.group_name',
                        'group_license_logs.license_id',
                        'licenses.license_name',
                        'group_license_logs.created_at'
                    )
                    ->get();

                $projectLogs = GroupProjectLog::leftJoin('users', 'group_project_logs.user_id', '=', 'users.user_id')
                    ->leftJoin('groups', 'group_project_logs.group_id', '=', 'groups.group_id')
                    ->leftJoin('projects', 'group_project_logs.project_id', '=', 'projects.project_id')
                    ->select(
                        'group_project_logs.id',
                        'group_project_logs.user_id',
                        'users.name as user_name',
                        'group_project_logs.action_type',
                        'group_project_logs.group_id',
                        'groups.group_name',
                        'group_project_logs.project_id',
                        'projects.project_name',
                        'group_project_logs.created_at'
                    )
                    ->get();

                // prepare HTML content for the PDF
                $html = view('exports.groups_log', compact('generalLogs', 'licenseLogs', 'projectLogs'))->render();

                // generate PDF
                $dompdf = new Dompdf();
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'landscape'); 
                $dompdf->render();

                return $dompdf->stream('groups_log.pdf');
                break;

            default:
                return redirect('/groups')->with('error', 'Invalid export format');
        }
    }

}

class GroupListExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    use Exportable;

    public function headings(): array
    {
        return [
            'GROUP ID',
            'GROUP NAME',
            'GROUP DESCRIPTION',
            'LICENSE NAME',
            'PROJECT NAME',
            'TIME CREATED',
            'TIME UPDATED',
            'TIME DELETED',
        ];
    }

    public function collection()
    {
        // fetch necessary data for CSV export
        $groups = Group::withTrashed()->get();
        $data = [];

        foreach ($groups as $group) {
            $rowData = [
                'Group ID' => $group->group_id,
                'Group Name' => $group->group_name,
                'Group Description' => $group->group_desc,
                'License Name' => $group->licenses->implode('license_name', ', '),
                'Project Name' => $group->projects->implode('project_name', ', '),
                'Time Created' => $group->created_at,
                'Time Updated' => $group->updated_at,
                'Time Deleted' => $group->deleted_at,
            ];

            $data[] = $rowData;
        }

        return collect($data);
    }

    public function styles(Worksheet $sheet)
    {
        // bold the headers
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => ['bold' => true,],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        // adjust column widths
        $columnWidths = [
            'A' => 10,
            'B' => 30,
            'C' => 30,
            'D' => 30,
            'E' => 30,
            'F' => 19,
            'G' => 19,
            'H' => 19,
        ];

        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        $columnsToWrap = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];

        foreach ($columnsToWrap as $column) {
            $sheet->getStyle($column)->getAlignment()->setWrapText(true);
        }
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // freeze the first row
                $event->sheet->freezePane('A2');
            },
        ];
    }
}

class GroupLogXlsExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new GeneralLogsSheet(),
            new LicenseLogsSheet(),
            new ProjectLogsSheet(),
        ];
    }
}

class GeneralLogsSheet implements FromCollection, WithHeadings, WithStyles, WithEvents, WithMapping
{
    public function collection()
    {
        return Log::leftJoin('users', 'logs.user_id', '=', 'users.user_id')
            ->where('logs.table_name', 'groups')
            ->select(
                'logs.log_id',
                'logs.user_id',
                'users.name as user_name',
                'logs.type_action',
                'logs.table_name',
                'logs.record_id',
                'logs.record_name',
                'logs.column_name',
                'logs.old_value',
                'logs.new_value',
                'logs.created_at'
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            'LOG ID',
            'USER ID',
            'USER NAME',
            'TYPE OF ACTION',
            'TABLE NAME',
            'RECORD ID',
            'RECORD NAME',
            'COLUMN NAME',
            'OLD VALUE',
            'NEW VALUE',
            'TIME',
        ];
    }

    public function map($log): array
    {
        $log->old_value = $this->formatJsonValue($log->old_value);
        $log->new_value = $this->formatJsonValue($log->new_value);

        return [
            $log->log_id,
            $log->user_id,
            $log->user_name,
            $log->type_action,
            $log->table_name,
            $log->record_id,
            $log->record_name,
            $log->column_name,
            $log->old_value,
            $log->new_value,
            $log->created_at->format('Y-m-d H:i:s'), 
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // bold the headers
        $sheet->getStyle('A1:K1')->applyFromArray([
            'font' => ['bold' => true,],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        $sheet->freezePane('A1');

        // adjust column widths
        $columnWidths = [
            'A' => 9,
            'B' => 6,
            'C' => 11,
            'D' => 9,
            'E' => 8,
            'F' => 9,
            'G' => 16,
            'H' => 12,
            'I' => 15,
            'J' => 15,
            'K' => 20,
        ];

        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        $columnsToWrap = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'];

        foreach ($columnsToWrap as $column) {
            $sheet->getStyle($column)->getAlignment()->setWrapText(true);
        }
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // freeze the first row
                $event->sheet->freezePane('A2');
                $event->sheet->setTitle('General Logs');
            },
        ];
    }

        private function formatJsonValue($jsonValue)
    {
        // decode the JSON value
        $decodedValue = json_decode($jsonValue, true);

        // check if decoding was successful
        if (json_last_error() === JSON_ERROR_NONE) {
            // format the array to a readable string with bulletpoints
            $formattedValue = implode(', ', array_map(function ($key, $value) {
                return "• $key: $value";
            }, array_keys($decodedValue), $decodedValue));

            return "$formattedValue";
        }

        // return the original value if decoding fails
        return $jsonValue;
    }
}

class LicenseLogsSheet implements FromCollection, WithHeadings, WithStyles, WithEvents, WithMapping
{
    public function collection()
    {
        return GroupLicenseLog::leftJoin('users', 'group_license_logs.user_id', '=', 'users.user_id')
            ->leftJoin('groups', 'group_license_logs.group_id', '=', 'groups.group_id')
            ->leftJoin('licenses', 'group_license_logs.license_id', '=', 'licenses.license_id')
            ->select(
                'group_license_logs.id',
                'group_license_logs.user_id',
                'users.name as user_name',
                'group_license_logs.action_type',
                'group_license_logs.group_id',
                'groups.group_name',
                'group_license_logs.license_id',
                'licenses.license_name',
                'group_license_logs.created_at'
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'USER ID',
            'USER NAME',
            'TYPE OF ACTION',
            'GROUP ID',
            'GROUP NAME',
            'LICENSE ID',
            'LICENSE NAME',
            'TIME',
        ];
    }

    public function map($log): array
    {
        return [
            $log->id,
            $log->user_id,
            $log->user_name,
            $log->action_type,
            $log->group_id,
            $log->group_name,
            $log->license_id,
            $log->license_name,
            $log->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // bold the headers
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => ['bold' => true,],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        // adjust column widths
        $columnWidths = [
            'A' => 9,
            'B' => 6,
            'C' => 11,
            'D' => 9,
            'E' => 9,
            'F' => 16,
            'G' => 9,
            'H' => 16,
            'I' => 20,
        ];

        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        $columnsToWrap = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];

        foreach ($columnsToWrap as $column) {
            $sheet->getStyle($column)->getAlignment()->setWrapText(true);
        }
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // freeze the first row
                $event->sheet->freezePane('A2');
                $event->sheet->setTitle('Licenses of Group');
            },
        ];
    }
}

class ProjectLogsSheet implements FromCollection, WithHeadings, WithStyles, WithEvents, WithMapping
{
    public function collection()
    {
        return GroupProjectLog::leftJoin('users', 'group_project_logs.user_id', '=', 'users.user_id')
            ->leftJoin('groups', 'group_project_logs.group_id', '=', 'groups.group_id')
            ->leftJoin('projects', 'group_project_logs.project_id', '=', 'projects.project_id')
            ->select(
                'group_project_logs.id',
                'group_project_logs.user_id',
                'users.name as user_name',
                'group_project_logs.action_type',
                'group_project_logs.group_id',
                'groups.group_name',
                'group_project_logs.project_id',
                'projects.project_name',
                'group_project_logs.created_at'
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'USER ID',
            'USER NAME',
            'TYPE OF ACTION',
            'GROUP ID',
            'GROUP NAME',
            'PROJECT ID',
            'PROJECT NAME',
            'TIME',
        ];
    }

    public function map($log): array
    {
        return [
            $log->id,
            $log->user_id,
            $log->user_name,
            $log->action_type,
            $log->group_id,
            $log->group_name,
            $log->project_id,
            $log->project_name,
            $log->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // bold the headers
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => ['bold' => true,],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        // adjust column widths
        $columnWidths = [
            'A' => 9,
            'B' => 6,
            'C' => 11,
            'D' => 9,
            'E' => 9,
            'F' => 16,
            'G' => 9,
            'H' => 16,
            'I' => 20,
        ];

        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        $columnsToWrap = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];

        foreach ($columnsToWrap as $column) {
            $sheet->getStyle($column)->getAlignment()->setWrapText(true);
        }
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // freeze the first row
                $event->sheet->freezePane('A2');
                $event->sheet->setTitle('Projects of Group');
            },
        ];
    }
}
