@extends('layouts.layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div>
            @if(count($differences) > 0)
                @if($toTrack == 'status')
                    <h3>FROM uploaded file</h3>
                    <p>These are the staff that its <b>status</b> changed: </p>

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exportStatusModal">
                        EXPORT CHANGES
                    </button>
                    <!-- Export Format Modal -->
                    <div class="modal fade" id="exportStatusModal" tabindex="-1" role="dialog" aria-labelledby="exportStatusModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exportStatusModalLabel">EXPORT STATUS CHANGES</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Which format do you want the list to be exported?</p>
                                </div>
                                <div class="modal-footer">
                                    <!-- Button to export as CSV -->
                                    <form action="{{ route('exportStatus', ['format' => 'xls']) }}" method="GET">
                                        <button type="submit" class="btn btn-success">XLS</button>
                                    </form>
                                    <!-- Button to export as PDF -->
                                    <form action="{{ route('exportStatus', ['format' => 'pdf']) }}" method="GET">
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
                                <th scope="col">Staff ID</th>
                                <th scope="col">Staff Name</th>
                                <th scope="col">Department ID</th>
                                <th scope="col">Department Name</th>
                                <th scope="col">Old Status</th>
                                <th scope="col">New Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($differences as $difference)
                                <tr>
                                    <td>{{ $difference['staff_id_rw'] }}</td>
                                    <td>{{ $difference['staff_name'] }}</td>
                                    <td>{{ $difference['dept_id'] }}</td>
                                    <td>{{ $difference['dept_name'] }}</td>
                                    <td class="highlight">{{ $difference['old_status'] }}</td>
                                    <td class="highlight">{{ $difference['new_status'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif($toTrack == 'department')
                    <h3>FROM uploaded file</h3>
                    <p>These are the staff that its <b>department name</b> changed: </p>

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exportDeptModal">
                        EXPORT CHANGES
                    </button>
                    <!-- Export Format Modal -->
                    <div class="modal fade" id="exportDeptModal" tabindex="-1" role="dialog" aria-labelledby="exportDeptModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exportDeptModalLabel">EXPORT DEPARTMENT CHANGES</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Which format do you want the list to be exported?</p>
                                </div>
                                <div class="modal-footer">
                                    <!-- Button to export as CSV -->
                                    <form action="{{ route('exportDept', ['format' => 'xls']) }}" method="GET">
                                        <button type="submit" class="btn btn-success">XLS</button>
                                    </form>
                                    <!-- Button to export as PDF -->
                                    <form action="{{ route('exportDept', ['format' => 'pdf']) }}" method="GET">
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
                                <th scope="col">Staff ID</th>
                                <th scope="col">Staff Name</th>
                                <th scope="col">Department ID</th>
                                <th scope="col">Old Department</th>
                                <th scope="col">New Department</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($differences as $difference)
                                <tr>
                                    <td>{{ $difference['staff_id_rw'] }}</td>
                                    <td>{{ $difference['staff_name'] }}</td>
                                    <td>{{ $difference['dept_id'] }}</td>
                                    <td class="highlight">{{ $difference['old_dept'] }}</td>
                                    <td class="highlight">{{ $difference['new_dept'] }}</td>
                                    <td>{{ $difference['status'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                @elseif($toTrack == 'all')
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Staff ID</th>
                                <th scope="col">Staff Name</th>
                                <th scope="col">Department ID</th>
                                <th scope="col">Department Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Staff ID</th>
                                <th scope="col">Staff Name</th>
                                <th scope="col">Department ID</th>
                                <th scope="col">Department Name</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($staffsFromSystem as $staff)
                                <tr>
                                    <td>{{ $staff['staff_id_rw'] }}</td>
                                    <td>{{ $staff['staff_name'] }}</td>
                                    <td>{{ $staff['dept_id'] }}</td>
                                    <td>{{ $staff['dept_name'] }}</td>
                                    <td>{{ $staff['status'] }}</td>
                                </tr>
                            @endforeach
                            @foreach($staffsFromUpload as $staff)
                                <tr>
                                    <td>{{ $staff['staff_id_rw'] }}</td>
                                    <td>{{ $staff['staff_name'] }}</td>
                                    <td>{{ $staff['dept_id'] }}</td>
                                    <td>{{ $staff['dept_name'] }}</td>
                                    <td>{{ $staff['status'] }}</td>
                                </tr>
                        @endforeach
                        </tbody>
                    </table>

                @endif
            @else
                <p>No changes detected.</p>
            @endif
        </div>
    </div>
</div>
@endsection
