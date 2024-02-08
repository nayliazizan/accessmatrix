@php
    function formatJsonValues($jsonString) {
        $jsonArray = json_decode($jsonString, true);
        $formattedValues = [];
        foreach ($jsonArray as $key => $value) {
            $formattedValues[] = "• {$key}: {$value}";
        }
        return implode('<br>', $formattedValues);
    }
@endphp 

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

    h1 {
        text-align: center;
    }
    
</style>

<body>
    <h1>ALL GROUPS LOG</h1>

    <!-- General Logs Table -->
    <h2>General Logs</h2>
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
            @foreach($generalLogs as $log)
                <tr>
                    <td>{{ $log->log_id }}</td>
                    <td>{{ $log->user_id }}</td>
                    <td>{{ $log->user_name }}</td>
                    <td>{{ $log->type_action }}</td>
                    <td>{{ $log->table_name }}</td>
                    <td>{{ $log->record_id }}</td>
                    <td>{{ $log->record_name }}</td>
                    <td>{{ $log->column_name }}</td>
                    <td>{!! $log->old_value ? formatJsonValues($log->old_value) : '' !!}</td>
                    <td>{!! $log->new_value ? formatJsonValues($log->new_value) : '' !!}</td>
                    <td>{{ $log->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Page Break -->
    <div class="page-break"></div>

    <!-- Group License Logs Table -->
    <h2>Group License Logs</h2>
    <table>
        <!-- Add similar table structure for Group License Logs -->
        <!-- Use $licenseLogs to populate data -->
        <thead>
            <tr>
                <th>ID</th>
                <th>USER ID</th>
                <th>USER NAME</th>
                <th>TYPE OF ACTION</th>
                <th>GROUP ID</th>
                <th>GROUP NAME</th>
                <th>LICENSE ID</th>
                <th>LICENSE NAME</th>
                <th>TIME</th>
            </tr>
        </thead>
        <tbody>
            @foreach($licenseLogs as $license)
                <tr>
                    <td>{{ $license->id }}</td>
                    <td>{{ $license->user_id }}</td>
                    <td>{{ $license->user_name }}</td>
                    <td>{{ $license->type_action }}</td>
                    <td>{{ $license->group_id }}</td>
                    <td>{{ $license->group_name }}</td>
                    <td>{{ $license->license_id }}</td>
                    <td>{{ $license->license_name }}</td>
                    <td>{{ $license->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Page Break -->
    <div class="page-break"></div>

    <!-- Group Project Logs Table -->
    <h2>Group Project Logs</h2>
    <table>
        <!-- Add similar table structure for Group Project Logs -->
        <!-- Use $projectLogs to populate data -->
        <thead>
            <tr>
                <th>ID</th>
                <th>USER ID</th>
                <th>USER NAME</th>
                <th>TYPE OF ACTION</th>
                <th>GROUP ID</th>
                <th>GROUP NAME</th>
                <th>PROJECT ID</th>
                <th>PROJECT NAME</th>
                <th>TIME</th>
            </tr>
        </thead>
        <tbody>
            @foreach($projectLogs as $project)
                <tr>
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->user_id }}</td>
                    <td>{{ $project->user_name }}</td>
                    <td>{{ $project->type_action }}</td>
                    <td>{{ $project->group_id }}</td>
                    <td>{{ $project->group_name }}</td>
                    <td>{{ $project->project_id }}</td>
                    <td>{{ $project->project_name }}</td>
                    <td>{{ $project->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>