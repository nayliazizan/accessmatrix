@extends('layouts.layout')

@section('content')

<h2>{{ $groupName }}'s STAFF</h2>
<a href="{{ route('staffs.create') }}" class="btn btn-success">ADD</a>
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
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
            @if ($staffs->isEmpty())
                <p>No staff found for this group.</p>
            @else
                @foreach($staffs as $staff)
                <tr>
                    <th scope="row">{{ $staff->staff_id }}</th>
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
                            <button type="submit" class="btn btn-danger">DELETE</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
