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

<h2>ALL LICENSES LIST</h2>

<table>
    <thead>
        <tr>
            <th>LICENSE ID</th>
            <th>LICENSE NAME</th>
            <th>LICENSE DESCRIPTION</th>
            <th>TIME CREATED</th>
            <th>TIME UPDATED</th>
            <th>TIME DELETED</th>
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
