
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

<h2>All Groups Record</h2>

<table>
    <thead>
        <tr>
            <th>Group ID</th>
            <th>Group Name</th>
            <th>Group Description</th>
            <th>License Name</th>
            <th>Project Name</th>
            <th>Time Created</th>
            <th>Time Updated</th>
            <th>Time Deleted</th>
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
