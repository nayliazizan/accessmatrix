@extends('layouts.layout')

<!-- resources\views\groups\index.blade.php -->

@section('content')
@if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
@endif

<h2>ALL GROUPS</h2>
<button type="button" class="btn btn-warning"><a href="{{ route('groups.create') }}">ADD</a></button>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exportModal">
    LIST
</button>

<!-- Export Report Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportModalLabel">EXPORT GROUP'S LIST</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Which format do you want the list to be exported?</p>
            </div>
            <div class="modal-footer">
                <!-- Button to export as CSV -->
                <form action="{{ route('exportListGroup', ['format' => 'xls']) }}" method="GET">
                    <button type="submit" class="btn btn-success">XLS</button>
                </form>
                <!-- Button to export as PDF -->
                <form action="{{ route('exportListGroup', ['format' => 'pdf']) }}" method="GET">
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

<!-- Export Report Modal -->
<div class="modal fade" id="exportLogChangesModal" tabindex="-1" role="dialog" aria-labelledby="exportLogChangesModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportLogChangesModalLabel">EXPORT GROUP'S LOG</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Which format do you want the log to be exported?</p>
            </div>
            <div class="modal-footer">
                <!-- Button to export as CSV -->
                <form action="{{ route('exportLogGroup', ['format' => 'xls']) }}" method="GET">
                    <button type="submit" class="btn btn-success">XLS</button>
                </form>
                <!-- Button to export as PDF -->
                <form action="{{ route('exportLogGroup', ['format' => 'pdf']) }}" method="GET">
                    <button type="submit" class="btn btn-danger">PDF</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
            </div>
        </div>
    </div>
</div>

<br><br>
<form class="form-inline my-2 my-lg-0" action="{{url('searchGroup')}}" method="get">
    @csrf
    <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search For Group" aria-label="Search">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
</form>

<div class="dropdown mt-2">
    <button class="btn btn-primary dropdown-toggle" type="button" id="sortDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Sort Order
    </button>
    <div class="dropdown-menu" aria-labelledby="sortDropdown">
        <a class="dropdown-item" href="{{ route('groups.index', ['sort_order' => 'latest']) }}">Latest to Oldest</a>
        <a class="dropdown-item" href="{{ route('groups.index', ['sort_order' => 'alphabet']) }}">Alphabetical (A-Z)</a>
    </div>
</div>

<table class="table">
  <thead class="thead-light">
    <tr>
      <th scope="col">KEY ID</th>
      <th scope="col">GROUP NAME</th>
      <th scope="col">DESCRIPTION</th>
      <th scope="col">LICENSES</th>
      <th scope="col">PROJECTS</th>
      <th scope="col">VIEW STAFF</th>
      <th scope="col">UPDATE</th>
      <th scope="col">DELETE</th>
    </tr>
  </thead>
  <tbody>
    @foreach($groups as $group)
    
        <tr id="groupRow{{ $group->group_id }}">
            <th scope="row">{{ $group->group_id }}</th>
            <td>{{ $group->group_name }}</td>
            <td>{{ $group->group_desc }}</td>
            <td>
                @foreach($group->licenses as $license)
                    <li>{{ $license->license_name }}</li><br>
                @endforeach
            </td>
            <td>
                @foreach($group->projects as $project)
                    <li>{{ $project->project_name }}</li><br>
                @endforeach
            </td>
            <td>
                @if($group->trashed())
                    <button class="btn btn-secondary" disabled>VIEW</button>
                @else
                    <a href="{{ route('groups.show_staff', $group->group_id) }}" class="btn btn-info">VIEW</a>
                @endif
            </td>
            <td>
                @if($group->trashed())
                    <button class="btn btn-secondary" disabled>UPDATE</button>
                @else
                    <a href="{{ route('groups.edit', $group->group_id) }}" class="btn btn-primary">UPDATE</a>
                @endif
            </td>
            <td>
                @if($group->trashed())
                    <!-- Display the RESTORE button for soft-deleted groups -->
                    <form action="{{ route('groups.restore', $group->group_id) }}" method="GET">
                        @csrf
                        
                        <button type="submit" class="btn btn-success">REACTIVATE</button>
                    </form>
                @else
                    <!-- Button trigger modal -->
                    <form action="{{ route('groups.destroy', $group->group_id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to deactivate this group?')">
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
    // Check if there's a recently created or updated license
    var recentlyUpdatedGroupId = "{{ session('recently_created_or_updated_group') }}";
    
    if (recentlyUpdatedGroupId) {
        // Highlight the row
        var row = document.getElementById('groupRow' + recentlyUpdatedGroupId);
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
