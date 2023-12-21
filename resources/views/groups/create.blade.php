@extends('layouts.layout')

@section('content')

<form action="{{ route('groups.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="group_name">Group Name</label>
        <input type="text" class="form-control" id="group_name" name="group_name" required>
    </div>
    <div class="form-group">
        <label for="group_desc">Group Description</label>
        <textarea class="form-control" id="group_desc" name="group_desc"></textarea>
    </div>

    <div class="form-group">
        <label>Licenses</label>
        @foreach($licenses as $license)
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="licenses[]" value="{{ $license->license_id }}" {{ old('licenses') && in_array($license->license_id, old('licenses')) ? 'checked' : '' }}>
                <label class="form-check-label">
                    {{ $license->license_name }}
                </label>
            </div>
        @endforeach
    </div>

    <div class="form-group">
        <label>Projects</label>
        @foreach($projects as $project)
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="projects[]" value="{{ $project->project_id }}" {{ old('projects') && in_array($project->project_id, old('projects')) ? 'checked' : '' }}>
                <label class="form-check-label">
                    {{ $project->project_name }}
                </label>
            </div>
        @endforeach
    </div>

    <button type="submit" class="btn btn-primary">Create Group</button>
</form>

@endsection