@extends('layouts.layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div>
            @if(count($differences) > 0)
                <h3>FROM uploaded file</h3>
                @if($toTrack == 'status')
                    <p>These are the staff that its <b>status</b> changed: </p>
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
                    <p>These are the staff that its <b>department name</b> changed: </p>
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
                @endif
            @else
                <p>No changes detected.</p>
            @endif
        </div>
    </div>
</div>
@endsection
