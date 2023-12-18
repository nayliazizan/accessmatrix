<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Project;

//for EXPORT module
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProjectController extends Controller
{
    public function index(){
        $projects = Project::withTrashed()->get(); // Include soft-deleted licenses

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

    //public function destroy($project_id){
    //    $project = Project::findOrFail($project_id);
    //    $project->update(['state' => 'inactive']); // Soft delete by updating the state
    //    return redirect('/projects');
    //}

    public function destroy($project_id)
    {
        $project = Project::findOrFail($project_id);

        if ($project->trashed()) {
            // Permanently delete the soft-deleted license
            $project->forceDelete();
            return redirect()->route('projects.index')->with('success', 'License permanently deleted!');
        } else {
            // Soft-delete the license
            $project->delete();
            return redirect()->route('projects.index')->with('success', 'License soft-deleted!');
        }
    }

    public function restore($project_id)
    {
        $project = Project::withTrashed()->findOrFail($project_id);

        // Restore the soft-deleted license
        $project->restore();

        return redirect()->route('projects.index')->with('success', 'License restored!');
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

    public function exportList($format)
    {
        switch ($format) {
            case 'csv':
                return Excel::download(new ProjectExport, 'projects.csv');
                break;
            case 'pdf':
                $projects = Project::withTrashed()->get();
                $pdf = PDF::loadView('exports.projects_list', ['projects' => $projects]);
                return $pdf->download('projects.pdf');
                break;
            default:
                return redirect('/projects')->with('error', 'Invalid export format');
        }
    }
}

class ProjectExport implements FromCollection, WithHeadings
{
    use Exportable;

    public function headings(): array
    {
        return [
            'Project ID',
            'Project Name',
            'Project Description',
            'Time Created',
            'Time Updated',
            'Time Deleted',
        ];
    }

    public function collection()
    {
        return Project::select('project_id', 'project_name', 'project_desc', 'created_at', 'updated_at', 'deleted_at')
            ->withTrashed() // Include soft-deleted projects
            ->get();
    }
}

