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
            <th>Project ID</th>
            <th>Project Name</th>
            <th>Project Description</th>
            <th>Time Created</th>
            <th>Time Updated</th>
            <th>Time Deleted</th>
        </tr>
    </thead>
    <tbody>
        @foreach($projects as $project)
            <tr>
                <td>{{ $project->project_id }}</td>
                <td>{{ $project->project_name }}</td>
                <td>{{ $project->project_desc }}</td>
                <td>{{ $project->created_at }}</td>
                <td>{{ $project->updated_at }}</td>
                <td>{{ $project->deleted_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
