@extends('layouts.layout')

@section('content')
<style>
    .row-height-3 {
        height: 160px;
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3>Staffs from System's Database</h3>
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Staff ID</th>
                        <th scope="col">Staff Name</th>
                        <th scope="col">Department ID</th>
                        <th scope="col">Department Name</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($staffsFromSystem as $i => $staff)
                    @php $i = $loop->iteration; @endphp
                        <tr class="row-height-3">
                            <th scope="row">{{ $i }}</th>
                            <td>{{ $staff['staff_id_rw'] }}</td>
                            <td>{{ $staff['staff_name'] }}</td>
                            <td>{{ $staff['dept_id'] }}</td>
                            <td>{{ $staff['dept_name'] }}</td>
                            <td>{{ $staff['status'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-md-6">
            <h3>Staffs from Uploaded File</h3>
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Staff Name</th>
                        <th scope="col">Department ID</th>
                        <th scope="col">Department Name</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($staffsFromUpload as $i => $staff)
                        @php
                            $staffId = $staff['staff_id_rw'];
                            $isNewStaff = !in_array($staffId, $staffsFromSystem->pluck('staff_id_rw')->toArray());
                        @endphp
                        @if (!$isNewStaff)
                            <tr class="row-height-3">
                                <td>{{ $staff['staff_name'] }}</td>
                                <td>{{ $staff['dept_id'] }}</td>
                                <td>{{ $staff['dept_name'] }}</td>
                                <td>{{ $staff['status'] }}</td>
                            </tr>
                        @endif
                    @endforeach
                
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
