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

<h2>ALL LICENSES LOG</h2>

<table>
    <thead>
        <tr>
            <th>LOG ID</th>
            <th>USER ID</th>
            <th>USER NAME</th>
            <th>TYPE OF ACTION</th>
            <th>TABLE NAME</th>
            <th>RECORD ID</th>
            <th>RECORD NAME</th>
            <th>COLUMN NAME</th>
            <th>OLD VALUE</th>
            <th>NEW VALUE</th>
            <th>TIME</th>
        </tr>
    </thead>
    <tbody>
        @foreach($logs as $log)
            <tr>
                <td>{{ $log->log_id }}</td>
                <td>{{ $log->user_id }}</td>
                <td>{{ $log->user_name }}</td>
                <td>{{ $log->type_action }}</td>
                <td>{{ $log->table_name }}</td>
                <td>{{ $log->record_id }}</td>
                <td>{{ $log->record_name }}</td>
                <td>{{ $log->column_name }}</td>
                <td>{{ $log->old_value }}</td>
                <td>{{ $log->new_value }}</td>
                <td>{{ $log->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
