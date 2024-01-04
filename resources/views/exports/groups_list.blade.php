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

<h2>ALL GROUPS LIST</h2>

<table>
    <thead>
        <tr>
            <th>GROUP ID</th>
            <th>GROUP NAME</th>
            <th>GROUP DESCRIPTION</th>
            <th>LICENSE NAME</th>
            <th>PROJECT NAME</th>
            <th>TIME CREATED</th>
            <th>TIME UPDATED</th>
            <th>TIME DELETED</th>
        </tr>
    </thead>
    <tbody>
        @foreach($groups as $group)
            <tr>
                <td>{{ $group->group_id }}</td>
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
                <td>{{ $group->created_at }}</td>
                <td>{{ $group->updated_at }}</td>
                <td>{{ $group->deleted_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
