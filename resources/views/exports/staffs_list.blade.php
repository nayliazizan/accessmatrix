<style>
    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed; /* Fixed layout to evenly distribute column widths */
    }

    th, td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
        white-space: normal; /* Prevent text from wrapping */
        overflow: hidden;
        text-overflow: ellipsis; /* Display ellipsis for overflowed text */
        font-size: 12px; /* Adjust font size as needed */
        word-wrap: break-word;
    }

    th {
        background-color: #f2f2f2;
        text-align: center;
    }

    h2 {
        text-align: center;
    }
    
</style>

<h2>ALL STAFF LIST</h2>

<table>
    <thead>
        <tr>
            <th>STAFF ID</th>
            <th>GROUP ID</th>
            <th>GROUP NAME</th>
            <th>STAFF ID (RW)</th>
            <th>STAFF NAME</th>
            <th>DEPARTMENT ID</th>
            <th>DEPARTMENT NAME</th>
            <th>STATUS</th>
            <th>TIME CREATED</th>
            <th>TIME UPDATED</th>
        </tr>
    </thead>
    <tbody>
        @foreach($staffs as $staff)
            <tr>
                <td>{{ $staff->staff_id }}</td>
                <td>{{ $staff->group_id }}</td>
                <td>{{ $staff->group->group_name }}</td>
                <td>{{ $staff->staff_id_rw }}</td>
                <td>{{ $staff->staff_name }}</td>
                <td>{{ $staff->dept_id }}</td>
                <td>{{ $staff->dept_name }}</td>
                <td>{{ $staff->status }}</td>
                <td>{{ $staff->created_at }}</td>
                <td>{{ $staff->updated_at }}</td>
            </tr>
        @endforeach
    </tbody>    
</table>
