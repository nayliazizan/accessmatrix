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

<h2>ALL PROJECTS LIST</h2>

<table>
    <thead>
        <tr>
            <th>PROJECT ID</th>
            <th>PROJECT NAME</th>
            <th>PROJECT DESCRIPTION</th>
            <th>TIME CREATED</th>
            <th>TIME UPDATED</th>
            <th>TIME DELETED</th>
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
