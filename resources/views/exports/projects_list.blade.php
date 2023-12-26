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

<h2>All Projects Record</h2>

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
