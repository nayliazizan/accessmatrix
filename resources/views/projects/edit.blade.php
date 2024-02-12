@extends('layouts.layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0">Edit Project</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('projects.update', $project->project_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="project_name">Name:</label>
                            <input type="text" class="form-control" id="project_name" name="project_name" value="{{$project->project_name}}">
                        </div>
                        <div class="form-group">
                            <label for="project_desc">Description:</label>
                            <textarea class="form-control" name="project_desc" rows="5" cols="40">{{$project->project_desc}}</textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Update Project</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

