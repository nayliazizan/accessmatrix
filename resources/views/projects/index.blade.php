@extends('layouts.layout')

@section('content')

<button type="button" class="btn btn-warning"><a href="/projects/create">ADD</a></button>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exportListModal">
    LIST
</button>

<!-- Export List Modal -->
<div class="modal fade" id="exportListModal" tabindex="-1" role="dialog" aria-labelledby="exportListModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportListModalLabel">Export List Options</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Choose which list you want to export:</p>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exportFormatModal">
                    PROJECTS
                </button>
                <button type="button" class="btn btn-primary" disabled>
                    LICENSES & PROJECTS
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Export Format Modal -->
<div class="modal fade" id="exportFormatModal" tabindex="-1" role="dialog" aria-labelledby="exportFormatModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportFormatModalLabel">Export Format Options</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Choose in what format you want the record to be exported:</p>
                <a href="{{ route('exportList', ['format' => 'csv']) }}" class="btn btn-primary">CSV</a>
                <a href="{{ route('exportList', ['format' => 'pdf']) }}" class="btn btn-primary">PDF</a>
            </div>
        </div>
    </div>
</div>

<table class="table">
    <thead class="thead-light">
        <tr>
            <th scope="col">#</th>
            <th scope="col">PROJECT NAME</th>
            <th scope="col">DESCRIPTION</th>
            <th scope="col">UPDATE</th>
            <th scope="col">DELETE</th>
        </tr>
    </thead>
    <tbody>
        <!-- Update the loop to only show "active" projects -->
        @foreach($projects as $project)
           
                <tr>
                    <th scope="row">{{ $project->project_id }}</th>
                    <td>{{ $project->project_name }}</td>
                    <td>{{ $project->project_desc }}</td>
                    <td>
                        <!-- <a href="/licenses/{{ $project->project_id }}/edit" class="btn btn-primary">UPDATE</a> -->
        
                        @if($project->trashed())
                            <button class="btn btn-secondary" disabled>UPDATE</button>
                        @else
                            <a href="/projects/{{ $project->project_id }}/edit" class="btn btn-primary">UPDATE</a>
                        @endif
                    </td>
                    <td>
                        @if ($project->trashed())
                            <!-- Display the RESTORE button for soft-deleted projects -->
                            <form action="{{ route('projects.restore', $project->project_id) }}" method="GET">
                                @csrf
                                @method('GET')
                                <button type="submit" class="btn btn-success">RESTORE</button>
                            </form>
                        @else
                            <!-- Display the DELETE button for non-soft-deleted projects -->
                            <form action="{{ route('projects.destroy', $project->project_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">DELETE</button>
                            </form>
                        @endif

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal{{ $project->project_id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure to delete '{{ $project->project_name }}' license?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                                        <!-- Form to handle the DELETE request -->
                                        <form action="/projects/{{ $project->project_id }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">YES</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

        @endforeach
    </tbody>
</table>
@endsection
