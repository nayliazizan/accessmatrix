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

        // Sync licenses by IDs
        $licenses = $request->input('licenses', []);
        $licenseData = [];
        foreach ($licenses as $licenseId) {
            $licenseData[$licenseId] = ['license_name' => '']; // Provide the default value for license_name
        }
        $group->licenses()->sync($licenses);

        // Sync projects by IDs with additional data
        $projects = $request->input('projects', []);
        $projectData = [];
        foreach ($projects as $projectId) {
            $projectData[$projectId] = ['project_name' => '']; // Provide the default value for project_name
        }
        $group->projects()->sync($projectData);

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



    public function exportGroups($format)
    {
        if ($format === 'csv') {
            return Excel::download(new GroupsExport, 'groups_report.csv');
        } elseif ($format === 'pdf') {
            // Example using barryvdh/laravel-dompdf:
            $pdf = PDF::loadView('exports.groups_list', ['groups' => Group::withTrashed()->get()]);
            return $pdf->download('groups_report.pdf');
        } else {
            return redirect()->route('groups.index')->with('error', 'Invalid export format.');
        }
    }

}

class GroupsExport implements FromCollection, WithHeadings
{
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

    public function headings(): array
    {
        return [
            'Group ID',
            'Group Name',
            'Group Description',
            'License Name',
            'Project Name',
            'Time Created',
            'Time Updated',
            'Time Deleted',
        ];
    }
}
