<!-- resources/views/staffs/index.blade.php -->

@extends('layouts.layout')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<h2>ALL STAFF</h2>
<a href="{{ route('staffs.create') }}" class="btn btn-warning">ADD</a>


<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exportModal">
    LIST
</button>

<!-- Export Report Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportModalLabel">EXPORT STAFF'S LIST</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('exportListStaff') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="group">Choose a Group:</label>
                        <select class="form-control" id="group" name="group">
                            <option value="all">All Groups</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->group_id }}">{{ $group->group_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <p>Which format do you want the record to be exported?</p>
                    <button type="submit" name="format" value="xls" class="btn btn-success">XLS</button>
                    <button type="submit" name="format" value="pdf" class="btn btn-danger">PDF</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                </form>
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
                <h5 class="modal-title" id="exportLogChangesModalLabel">EXPORT STAFF'S LOG</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Which format do you want the log to be exported?</p>
            </div>
            <div class="modal-footer">
                <!-- Button to export as XLS -->
                <form action="{{ route('exportLogStaff', ['format' => 'xls']) }}" method="GET">
                    <button type="submit" class="btn btn-success">XLS</button>
                </form>
                <!-- Button to export as PDF -->
                <form action="{{ route('exportLogStaff', ['format' => 'pdf']) }}" method="GET">
                    <button type="submit" class="btn btn-danger">PDF</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('noGroupStaff') }}" class="btn btn-danger">NO GROUP'S STAFF</a>

<a href="#" class="btn btn-warning" data-toggle="modal" data-target="#importStaffModal">IMPORT STAFF</a>

<div class="modal fade" id="importStaffModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('staff.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">IMPORT FILE</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p for="staff_file">Select XLSX file:</p>
                    <input type="file" class="form-control" id="staff_file" name="staff_file" required>
                    <br><p style="color: red;"><b>This process could take 3-5 minutes for big datasets. Please don't refresh the page.</b></p>
                </div>
                <div class="modal-footer">
                    <a href="{{asset('public/files/template.pdf')}}" target="_blank" class="btn btn-info">CLICK HERE TO SEE FILE TEMPLATE</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn btn-primary">IMPORT</button>
                </div>
            </div>
        </form>
    </div>
</div>


<br><br>
<form class="form-inline my-2 my-lg-0" action="{{url('searchStaff')}}" method="get">
    @csrf
    <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search For Staff" aria-label="Search">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
</form>


<div class="dropdown mt-2">
    <button class="btn btn-primary dropdown-toggle" type="button" id="sortDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Sort Order
    </button>
    <div class="dropdown-menu" aria-labelledby="sortDropdown">
        <a class="dropdown-item" href="{{ route('staffs.index', ['sort_order' => 'latest']) }}">Latest to Oldest</a>
        <a class="dropdown-item" href="{{ route('staffs.index', ['sort_order' => 'alphabet']) }}">Alphabetical (A-Z)</a>
    </div>
</div>

<table class="table">
    <thead class="thead-light">
        <tr>
            <th scope="col">#</th>
            <th scope="col">GROUP</th>
            <th scope="col">STAFF ID (RW)</th>
            <th scope="col">STAFF NAME</th>
            <th scope="col">DEPARTMENT ID</th>
            <th scope="col">DEPARTMENT NAME</th>
            <th scope="col">STATUS</th>
            <th scope="col">UPDATE</th>
            <th scope="col">DELETE</th>
        </tr>
    </thead>
    <tbody>
        @foreach($staffs as $staff)
        @php $i = $loop->iteration; @endphp
        <tr>
            <th scope="row">{{ $i }}</th>
            <td>
                @if ($staff->group)
                    {{ $staff->group->group_name }}
                @else
                    <!-- Display "No Group" when group is null or soft-deleted -->
                    No Group
                @endif
            </td>
            <td>{{ $staff->staff_id_rw }}</td>
            <td>{{ $staff->staff_name }}</td>
            <td>{{ $staff->dept_id }}</td>
            <td>{{ $staff->dept_name }}</td>
            <td>{{ $staff->status }}</td>
            <td>
                <a href="{{ route('staffs.edit', $staff->staff_id) }}" class="btn btn-primary">UPDATE</a>            
            </td>
            <td>
                <form action="{{ route('staffs.destroy', $staff->staff_id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this staff?')">DELETE</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
