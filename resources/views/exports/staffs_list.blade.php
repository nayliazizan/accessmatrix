<!-- resources/views/exports/staffs_list.blade.php -->
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
    }

    h2 {
        text-align: center;
    }
</style>

<h2>All Staff Record</h2>

<table>
    <thead>
        <tr>
            <th>Staff ID</th>
            <th>Group</th>
            <th>Staff ID (RW)</th>
            <th>Staff Name</th>
            <th>Department ID</th>
            <th>Department Name</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($staffs as $staff)
            <tr>
                <td>{{ $staff->staff_id }}</td>
                <td>{{ $groups->where('group_id', $staff->group_id)->first()->group_name }}</td>
                <td>{{ $staff->staff_id_rw }}</td>
                <td>{{ $staff->staff_name }}</td>
                <td>{{ $staff->dept_id }}</td>
                <td>{{ $staff->dept_name }}</td>
                <td>{{ $staff->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
