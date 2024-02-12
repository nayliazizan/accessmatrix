@extends('layouts.layout')

@section('content')

@if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

<h2>ALL PROJECTS</h2>
<button type="button" class="btn btn-warning"><a href="{{ route('projects.create') }}">ADD</a></button>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exportListModal">
    LIST
</button>

<!-- Export Format Modal -->
<div class="modal fade" id="exportListModal" tabindex="-1" role="dialog" aria-labelledby="exportListModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportListModalLabel">EXPORT PROJECT'S LIST</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Which format do you want the list to be exported?</p>
            </div>
            <div class="modal-footer">
                <!-- Button to export as CSV -->
                <form action="{{ route('exportListProject', ['format' => 'xls']) }}" method="GET">
                    <button type="submit" class="btn btn-success">XLS</button>
                </form>
                <!-- Button to export as PDF -->
                <form action="{{ route('exportListProject', ['format' => 'pdf']) }}" method="GET">
                    <button type="submit" class="btn btn-danger">PDF</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
            </div>
        </div>
    </div>
</div>

<button type="button" class="btn btn-info" data-toggle="modal" data-target="#exportLogChangesModal">
    LOG CHANGES
</button>

<!-- Export Format Modal -->
<div class="modal fade" id="exportLogChangesModal" tabindex="-1" role="dialog" aria-labelledby="exportLogChangesModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportLogChangesModalLabel">EXPORT PROJECT'S LOG</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Which format do you want the log to be exported?</p>
            </div>
            <div class="modal-footer">
                <!-- Button to export as CSV -->
                <form action="{{ route('exportLogProject', ['format' => 'xls']) }}" method="GET">
                    <button type="submit" class="btn btn-success">XLS</button>
                </form>
                <!-- Button to export as PDF -->
                <form action="{{ route('exportLogProject', ['format' => 'pdf']) }}" method="GET">
                    <button type="submit" class="btn btn-danger">PDF</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
            </div>
        </div>
    </div>
</div>

<br><br>
<form class="form-inline my-2 my-lg-0" action="{{url('searchProject')}}" method="get">
    @csrf
    <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search For Project" aria-label="Search">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
</form>

<div class="dropdown mt-2">
    <button class="btn btn-primary dropdown-toggle" type="button" id="sortDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Sort Order
    </button>
    <div class="dropdown-menu" aria-labelledby="sortDropdown">
        <a class="dropdown-item" href="{{ route('projects.index', ['sort_order' => 'latest']) }}">Latest to Oldest</a>
        <a class="dropdown-item" href="{{ route('projects.index', ['sort_order' => 'alphabet']) }}">Alphabetical (A-Z)</a>
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
        @php $i = $loop->iteration; @endphp
                <tr id="projectRow{{ $project->project_id }}">
                    <th scope="row">{{ $i }}</th>
                    <td>{{ $project->project_name }}</td>
                    <td>{{ $project->project_desc }}</td>
                    <td>
                        <!-- <a href="/licenses/{{ $project->project_id }}/edit" class="btn btn-primary">UPDATE</a> -->
        
                        @if($project->trashed())
                            <button class="btn btn-secondary" disabled>UPDATE</button>
                        @else
                            <a href="{{ route('projects.edit', $project->project_id) }}" class="btn btn-primary">UPDATE</a>
                        @endif
                    </td>
                    <td>
                        @if ($project->trashed())
                            <!-- Display the RESTORE button for soft-deleted projects -->
                            <form action="{{ route('projects.restore', $project->project_id) }}" method="GET">
                                @csrf
                                @method('GET')
                                <button type="submit" class="btn btn-success">REACTIVATE</button>
                            </form>
                        @else
                            <!-- Display the DELETE button for non-soft-deleted projects -->
                            <form action="{{ route('projects.destroy', $project->project_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"  onclick="return confirm('Are you sure you want to deactivate this project?')">
                                    DEACTIVATE
                                </button>
                            </form>
                        @endif

                    </td>
                </tr>

        @endforeach
    </tbody>
</table>

<script>
    // Check if there's a recently created or updated project
    var recentlyUpdatedProjectId = "{{ session('recently_created_or_updated_project') }}";
    
    if (recentlyUpdatedProjectId) {
        // Highlight the row
        var row = document.getElementById('projectRow' + recentlyUpdatedProjectId);
        if (row) {
            row.classList.add('highlight');

            // Remove the highlighting after 3 seconds
            setTimeout(function() {
                row.classList.remove('highlight');
            }, 3000);
        }
    }
</script>
@endsection
