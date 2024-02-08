<!-- resources/views/staffs/edit.blade.php -->

@extends('layouts.layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0">Edit Staff</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('staffs.update', $staff->staff_id) }}" method="POST">
                        @csrf

                        @if(session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        @error('dept_name')
                            <div  class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror

                        @method('PUT')
                        <div class="form-group">
                            <label for="group_id">Group:</label>
                            <select class="form-control" id="group_id" name="group_id" required>
                                <option value="">No Group</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->group_id }}" {{ $staff->group_id == $group->group_id ? 'selected' : '' }}>
                                        {{ $group->group_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="staff_id_rw">Staff ID (RW):</label>
                            <i>read-only</i>
                            <input class="form-control" type="text" id="staff_id_rw" name="staff_id_rw" value="{{ $staff->staff_id_rw }}" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="staff_name">Staff Name:</label>
                            <input class="form-control" type="text" id="staff_name" name="staff_name" value="{{ $staff->staff_name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="dept_id">Department ID:</label>
                            <input class="form-control" type="text" id="dept_id" name="dept_id" value="{{ $staff->dept_id }}" required>
                        </div>
                        <div class="form-group">
                            <label for="dept_name">Department Name:</label>
                            <input class="form-control" type="text" id="dept_name" name="dept_name" value="{{ $staff->dept_name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <input class="form-control" type="text" id="status" name="status" value="{{ $staff->status }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Staff</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
