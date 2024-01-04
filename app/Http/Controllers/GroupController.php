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
use PDF;

use App\Models\GroupLicenseLog;
use App\Models\GroupProjectLog;
use App\Models\Log;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\Exportable;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::withTrashed(['groupLicenses' => function ($query) {
            $query->whereNull('deleted_at');
        }, 'groupProjects' => function ($query) {
            $query->whereNull('deleted_at')->with('project');
        }])->get();

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

        // Create a new group
        $group = Group::create([
            'group_name' => $request->input('group_name'),
            'group_desc' => $request->input('group_desc'),
        ]);

        // Attach licenses by IDs
        $licenses = $request->input('licenses', []);
        $group->licenses()->attach($licenses, ['license_name' => '']);

        // Attach projects by IDs
        $projects = $request->input('projects', []);
        $group->projects()->attach($projects, ['project_name' => '']);

            // Log creations for group licenses
    foreach ($licenses as $licenseId) {
        GroupLicenseLog::create([
            'user_id' => auth()->id(),
            'group_id' => $group->group_id,
            'license_id' => $licenseId,
            'action_type' => 'create',
        ]);
    }

    // Log creations for group projects
    foreach ($projects as $projectId) {
        GroupProjectLog::create([
            'user_id' => auth()->id(),
            'group_id' => $group->group_id,
            'project_id' => $projectId,
            'action_type' => 'create',
        ]);
    }

        return redirect()->route('groups.index');
    }

    public function destroy($group_id)
    {
        $group = Group::findOrFail($group_id);

        // Check if there are related staff
        $relatedStaffCount = Staff::where('group_id', $group_id)->count();

        if ($relatedStaffCount > 0) {
            // Display a message that the group has staff
            return redirect()->route('groups.index')->with('error', 'Cannot delete the group. The group has staff.');
        }

        // No related staff, proceed with deletion
        $group->delete();

        return redirect()->route('groups.index')->with('success', 'The selected group soft deleted!');
    }


    public function restore($group_id)
    {
        $group = Group::withTrashed()->findOrFail($group_id);

        // Restore the soft-deleted license
        $group->restore();

        return redirect()->route('groups.index')->with('success', 'Group restored!');
    }

    public function edit(Group $group)
    {
        $licenses = License::whereNull('deleted_at')->get();
        $projects = Project::whereNull('deleted_at')->get();

        // Fetch licenses and projects for the group
        $groupLicenses = GroupLicense::where('group_id', $group->group_id)->get();
        $groupProjects = GroupProject::where('group_id', $group->group_id)->get();

        // Extract license and project IDs from pivot tables
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

        // Update group details
        $group->update([
            'group_name' => $request->input('group_name'),
            'group_desc' => $request->input('group_desc'),
        ]);

        // Log changes for group licenses
        $licenses = $request->input('licenses', []);
        $existingLicenses = $group->licenses->pluck('license_id')->toArray();

        // Log creations
        foreach (array_diff($licenses, $existingLicenses) as $licenseId) {
            GroupLicenseLog::create([
                'user_id' => auth()->id(),
                'group_id' => $group->group_id,
                'license_id' => $licenseId,
                'action_type' => 'create',
            ]);

            // Sync licenses by IDs (including license_name)
            $group->licenses()->sync([$licenseId => ['license_name' => License::find($licenseId)->license_name]]);
        }

        // Log deletions
        foreach (array_diff($existingLicenses, $licenses) as $licenseId) {
            GroupLicenseLog::create([
                'user_id' => auth()->id(),
                'group_id' => $group->group_id,
                'license_id' => $licenseId,
                'action_type' => 'delete',
            ]);

            // Detach licenses by IDs
            $group->licenses()->detach($licenseId);
        }

        // Log changes for group projects
        $projects = $request->input('projects', []);
        $existingProjects = $group->projects->pluck('project_id')->toArray();

        // Log creations
        foreach (array_diff($projects, $existingProjects) as $projectId) {
            GroupProjectLog::create([
                'user_id' => auth()->id(),
                'group_id' => $group->group_id,
                'project_id' => $projectId,
                'action_type' => 'create',
            ]);

            // Sync projects by IDs (including project_name)
            $group->projects()->sync([$projectId => ['project_name' => Project::find($projectId)->project_name]]);
        }

        // Log deletions
        foreach (array_diff($existingProjects, $projects) as $projectId) {
            GroupProjectLog::create([
                'user_id' => auth()->id(),
                'group_id' => $group->group_id,
                'project_id' => $projectId,
                'action_type' => 'delete',
            ]);

            // Detach projects by IDs
            $group->projects()->detach($projectId);
        }

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
            // Example using barryvdh/laravel-dompdf:
            $pdf = PDF::loadView('exports.groups_list', ['groups' => Group::withTrashed()->get()]);
            return $pdf->download('groups_list.pdf');
        } else {
            return redirect()->route('groups.index')->with('error', 'Invalid export format.');
        }
    }

    public function exportLogGroup($format)
    {
        switch ($format) {
            case 'xls':
                return Excel::download(new GroupLogExport, 'groups_log.xls');
                break;
            case 'pdf':
                $logs = Log::leftJoin('users', 'logs.user_id', '=', 'users.user_id')
                ->where('logs.table_name', 'groups')
                ->select('logs.log_id', 'users.name as user_name', 'logs.type_action', 'logs.record_name', 'logs.column_name', 'logs.old_value', 'logs.new_value', 'logs.created_at')
                ->get();
                $pdf = PDF::loadView('exports.groups_log', ['logs' => $logs]);
                return $pdf->download('groups_log.pdf');
                break;
            default:
                return redirect('/groups')->with('error', 'Invalid export format');
        }
    }

}

class GroupListExport implements FromCollection, WithHeadings, WithStyles
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
        // Fetch necessary data for CSV export
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
        // Bold the headers
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => ['bold' => true,],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        // Adjust column widths
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

        $columnsToWrap = ['C', 'D', 'E'];

        foreach ($columnsToWrap as $column) {
            $sheet->getStyle($column)->getAlignment()->setWrapText(true);
        }
    }
}

class GroupLogExport implements FromCollection, WithHeadings, WithStyles
{
    use Exportable;

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

    public function collection()
    {
        return Log::select('logs.log_id', 'logs.user_id', 'users.name as user_name', 'logs.type_action', 'logs.table_name', 'logs.record_id', 'logs.record_name', 'logs.column_name', 'logs.old_value', 'logs.new_value', 'logs.created_at')
            ->leftJoin('users', 'logs.user_id', '=', 'users.user_id')
            ->where('logs.table_name', 'groups') // Add the condition for table_name
            ->get();
    }
    
    public function styles(Worksheet $sheet)
    {
        // Bold the headers
        $sheet->getStyle('A1:K1')->applyFromArray([
            'font' => ['bold' => true,],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        // Adjust column widths
        $columnWidths = [
            'A' => 14,
            'B' => 8,
            'C' => 20,
            'D' => 8,
            'E' => 12,
            'F' => 9,
            'G' => 30,
            'H' => 13,
            'I' => 30,
            'J' => 30,
            'K' => 27,
        ];

        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        $columnsToWrap = ['D', 'F', 'H', 'I', 'J'];

        foreach ($columnsToWrap as $column) {
            $sheet->getStyle($column)->getAlignment()->setWrapText(true);
        }
    }

}