<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    table, th, td {
        border: 1px solid black;
    }
</style>

<table>
    <thead>
        <tr>
            <th>Group ID</th>
            <th>Group Name</th>
            <th>Group Description</th>
            <th>License Name</th>
            <th>License Deleted At</th>
            <th>Project Name</th>
            <th>Project Deleted At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($groups as $group)
            <tr>
                <td>{{ $group->group_id }}</td>
                <td>{{ $group->group_name }}</td>
                <td>{{ $group->group_desc }}</td>
                <td>
                    @foreach($group->groupLicenses as $license)
                        {{ $license->license->license_name }},
                    @endforeach
                </td>
                <td>
                    @foreach($group->groupLicenses as $license)
                        {{ $license->deleted_at }},
                    @endforeach
                </td>
                <td>
                    @foreach($group->groupProjects as $project)
                        {{ $project->project->project_name }},
                    @endforeach
                </td>
                <td>
                    @foreach($group->groupProjects as $project)
                        {{ $project->deleted_at }},
                    @endforeach
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
