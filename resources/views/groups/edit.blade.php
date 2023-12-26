@extends('layouts.layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0">Edit Group</h1>
                </div>

                <div class="card-body">
                    <form action="{{ route('groups.update', $group->group_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="group_name">Group Name</label>
                            <input type="text" class="form-control" id="group_name" name="group_name" value="{{ $group->group_name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="group_desc">Group Description</label>
                            <textarea class="form-control" id="group_desc" name="group_desc">{{ $group->group_desc }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Licenses</label>
                            @foreach($licenses as $license)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="licenses[]" value="{{ $license->license_id }}"
                                        {{ in_array($license->license_id, $group->licenses->pluck('license_id')->toArray()) ? 'checked' : '' }}>
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
                                    <input type="checkbox" class="form-check-input" name="projects[]" value="{{ $project->project_id }}"
                                        {{ in_array($project->project_id, $group->projects->pluck('project_id')->toArray()) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        {{ $project->project_name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary">Update Group</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
