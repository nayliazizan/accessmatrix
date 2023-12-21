<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Group;
use Illuminate\Validation\Rule;



class StaffController extends Controller
{
    // Display a listing of the staffs
    public function index()
    {
        $staffs = Staff::with('group')->get();
        return view('staffs.index', compact('staffs'));
    }

    // Show the form for creating a new staff
    public function create()
    {
        $groups = Group::all();
        return view('staffs.create', compact('groups'));
    }

    // Store a newly created staff in the database
    public function store(Request $request)
    {
        $data = $request->validate([
            'group_id' => 'required|exists:groups,group_id',
            'staff_id_rw' => 'required|string|max:255|unique:staffs,staff_id_rw',
            'staff_name' => 'required|string|max:255',
            'dept_id' => 'required|string|max:255',
            'dept_name' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        Staff::create($data);

        return redirect()->route('staffs.index')->with('success', 'Staff created successfully!');
    }

    // Show the form for editing the specified staff
    public function edit(Staff $staff)
    {
        $groups = Group::all();
        return view('staffs.edit', compact('staff', 'groups'));
    }

    // Update the specified staff in the database
    public function update(Request $request, $staff_id)
    {
        $staff = Staff::where('staff_id', $staff_id)->firstOrFail();

        $data = $request->validate([
            'group_id' => 'required',
            'staff_id_rw' => [
                'required',
                Rule::unique('staffs')->ignore($staff->staff_id, 'staff_id'),
            ],
            'staff_name' => 'required',
            'dept_id' => 'required',
            'dept_name' => 'required',
            'status' => 'required',
        ]);

        $staff->update($data);

        return redirect()->route('staffs.index')->with('success', 'Staff updated successfully!');
    }

    // Delete the specified staff from the database
    public function destroy(Staff $staff)
    {
        $staff->delete();

        return redirect()->route('staffs.index')->with('success', 'Staff deleted successfully!');
    }
}