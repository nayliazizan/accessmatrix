@extends('layouts.layout')

@section('content')

<h2>NO GROUP'S STAFF</h2>

<table class="table">
    <thead class="thead-light">
        <tr>
            <th scope="col">#</th>
            <th scope="col">STAFF ID (RW)</th>
            <th scope="col">STAFF NAME</th>
            <th scope="col">DEPARTMENT ID</th>
            <th scope="col">DEPARTMENT NAME</th>
            <th scope="col">STATUS</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ngStaff as $staff)
            <tr>
                <th scope="row">{{ $staff->staff_id }}</th>
                <td>{{ $staff->staff_id_rw }}</td>
                <td>{{ $staff->staff_name }}</td>
                <td>{{ $staff->dept_id }}</td>
                <td>{{ $staff->dept_name }}</td>
                <td>{{ $staff->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
