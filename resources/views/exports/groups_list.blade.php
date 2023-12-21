<!DOCTYPE html>
<html>
<head>
    <title>Groups Report</title>
</head>
<body>

<h2>Groups Report</h2>

<table border="1">
    <thead>
        <tr>
            <th>Group ID</th>
            <th>Group Name</th>
            <th>Group Description</th>
            <th>License Name</th>
            <th>Project Name</th>
            <th>Deleted At</th>
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
                <td>{{ $group->deleted_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
