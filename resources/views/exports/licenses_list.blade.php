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
            <th>License ID</th>
            <th>License Name</th>
            <th>License Description</th>
            <th>Time Created</th>
            <th>Time Updated</th>
            <th>Time Deleted</th>
        </tr>
    </thead>
    <tbody>
        @foreach($licenses as $license)
            <tr>
                <td>{{ $license->license_id }}</td>
                <td>{{ $license->license_name }}</td>
                <td>{{ $license->license_desc }}</td>
                <td>{{ $license->created_at }}</td>
                <td>{{ $license->updated_at }}</td>
                <td>{{ $license->deleted_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
