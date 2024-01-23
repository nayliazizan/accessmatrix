<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Log;

//for EXPORT module
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ProjectController extends Controller
{
    public function index(){
        $projects = Project::withTrashed()
        ->orderByRaw('deleted_at ASC, deleted_at IS NULL') 
        ->get(); // Include soft-deleted licenses

        return view('projects.index', compact('projects'));
    }

    public function create(){
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $project = new Project();

        $project->project_name = request('project_name');
        $project->project_desc = request('project_desc');

        $project->save();

        return redirect('/projects');
    }

    public function destroy($project_id)
    {
        $project = Project::findOrFail($project_id);

        if ($project->trashed()) {
            // Permanently delete the soft-deleted project
            $project->forceDelete();
            return redirect()->route('projects.index')->with('success', 'License permanently deleted!');
        } else {
            // Soft-delete the project
            $project->delete();
            return redirect()->route('projects.index')->with('success', 'License soft-deleted!');
        }
    }

    public function restore($project_id)
    {
        $project = Project::withTrashed()->findOrFail($project_id);

        // Restore the soft-deleted project
        $project->restore();

        return redirect()->route('projects.index')->with('success', 'Project restored!');
    }

    public function edit($project_id){
        $project = Project::findOrFail($project_id);
        return view('projects.edit', ['project' => $project]);
    }
    
    public function update(Request $request, $project_id){
        $project = Project::findOrFail($project_id);
        $project->project_name = $request->input('project_name');
        $project->project_desc = $request->input('project_desc');
        $project->save();
        return redirect('/projects');
    }

    public function exportListProject($format)
    {
        switch ($format) {
            case 'xls':
                return Excel::download(new ProjectListExport, 'projects_list.xls');
                break;
            case 'pdf':
                $pdf = app('dompdf.wrapper');
                $pdf->loadView('exports.projects_list', ['projects' => Project::withTrashed()->get()]);
                return $pdf->download('projects_list.pdf');
                break;
            default:
                return redirect('/projects')->with('error', 'Invalid export format');
        }
    }

    public function exportLogProject($format)
    {
        switch ($format) {
            case 'xls':
                return Excel::download(new ProjectLogChangesExport, 'project_log.xls');
                break;
            case 'pdf':
                $pdf = app('dompdf.wrapper');
                $logs = Log::leftJoin('users', 'logs.user_id', '=', 'users.user_id')
                ->where('logs.table_name', 'projects') // Add the condition for table_name
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
                    'logs.created_at')
                ->get();
                $pdf->setPaper('A4', 'landscape');
                $pdf->loadView('exports.projects_log', ['logs' => $logs]);
                return $pdf->download('projects_log.pdf');
                break;
            default:
                return redirect('/projects')->with('error', 'Invalid export format');
        }
    }    
}

class ProjectListExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    use Exportable;

    public function headings(): array
    {
        return [
            'PROJECT ID',
            'PROJECT NAME',
            'PROJECT DESCRIPTION',
            'TIME CREATED',
            'TIME UPDATED',
            'TIME DELETED',
        ];
    }

    public function collection()
    {
        return Project::select('project_id', 'project_name', 'project_desc', 'created_at', 'updated_at', 'deleted_at')
            ->withTrashed() // Include soft-deleted project
                ->get();
    }

    public function styles(Worksheet $sheet)
    {
        // Bold the headers
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => ['bold' => true,],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        // Adjust column widths
        $columnWidths = [
            'A' => 11,
            'B' => 30,
            'C' => 30,
            'D' => 27,
            'E' => 27,
            'F' => 27,
        ];

        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        $columnsToWrap = ['A', 'B', 'C', 'D', 'E', 'F',];

        foreach ($columnsToWrap as $column) {
            $sheet->getStyle($column)->getAlignment()->setWrapText(true);
        }
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Freeze the first row
                $event->sheet->freezePane('A2');
            },
        ];
    }
}

class ProjectLogChangesExport implements FromCollection, WithHeadings, WithStyles, WithEvents
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
            ->where('logs.table_name', 'projects') // Add the condition for table_name
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
                // Freeze the first row
                $event->sheet->freezePane('A2');
            },
        ];
    }

}

