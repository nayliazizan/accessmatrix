@extends('layouts.layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0">Create a New Project</h1>
                </div>
                <div class="card-body">
                    <form action="/projects" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="project_name">Name:</label>
                            <input type="text" class="form-control" id="project_name" name="project_name">
                        </div>
                        <div class="form-group">
                            <label for="project_desc">Description:</label>
                            <textarea class="form-control" name="project_desc" rows="5" cols="40"></textarea>
                        </div>
                        <input type="hidden" name="state" value="active">
                        <button type="submit" class="btn btn-primary">Create Project</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
