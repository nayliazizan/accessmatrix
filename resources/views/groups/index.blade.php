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
                <h5 class="modal-title" id="exportModalLabel">Export Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Which format do you want the record to be exported?</p>
            </div>
            <div class="modal-footer">
                <!-- Button to export as CSV -->
                <form action="{{ route('groups.export', ['format' => 'csv']) }}" method="GET">
                    <button type="submit" class="btn btn-success">CSV</button>
                </form>
                <!-- Button to export as PDF -->
                <form action="{{ route('groups.export', ['format' => 'pdf']) }}" method="GET">
                    <button type="submit" class="btn btn-danger">PDF</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
            </div>
        </div>
    </div>
</div>

<table class="table">
  <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
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
        <tr>
            <th scope="row">{{ $group->group_id }}</th>
            <td>{{ $group->group_name }}</td>
            <td>{{ $group->group_desc }}</td>
            <td>
                @foreach($group->licenses as $license)
                    {{ $license->license_name }}<br>
                @endforeach
            </td>
            <td>
                @foreach($group->projects as $project)
                    {{ $project->project_name }}<br>
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
                        
                        <button type="submit" class="btn btn-success">RESTORE</button>
                    </form>
                @else
                    <!-- Button trigger modal -->
                    <form action="{{ route('groups.destroy', $group->group_id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $group->group_id }}">
                            DELETE
                        </button>
                    </form>
                    


                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal{{ $group->group_id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure to delete '{{ $group->group_name }}' group?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                                    <!-- Form to handle the DELETE request -->
                                    <form action="{{ route('groups.destroy', $group->group_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">YES</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </td>
        </tr>
    @endforeach
  </tbody>
</table>
@endsection