<?php
// app/Http/Controllers/GroupController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\License;
use App\Models\Project;
use App\Models\GroupLicense;
use App\Models\GroupProject;
use Illuminate\Validation\Rule;


class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::with(['groupLicenses' => function ($query) {
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

    public function destroy(Group $group)
    {
        if ($group->exists()) {
            // Detach all associated licenses before deleting the group
            $group->licenses()->detach();

            // Detach all associated projects before deleting the group
            $group->projects()->detach();

            // Delete the group itself
            $group->delete();

            return redirect()->route('groups.index')->with('success', 'Group successfully deleted!');
        }

        return redirect()->route('groups.index')->with('error', 'Group not found!');
    }

    public function edit(Group $group)
    {
        $licenses = License::whereNull('deleted_at')->get();
        $projects = Project::whereNull('deleted_at')->get(); // Use the new method to get active projects

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

}
