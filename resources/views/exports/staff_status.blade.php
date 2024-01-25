<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Status Changes</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
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

        .highlight {
            background-color: rgba(255, 255, 0, 0.5); /* Yellowish background with 50% opacity */
        }
    </style>
</head>
<body>

<h2>ALL STAFF'S STATUS CHANGED</h2>

<table>
    <thead>
        <tr>
            <th>STAFF ID</th>
            <th>STAFF NAME</th>
            <th>DEPARTMENT ID</th>
            <th>DEPARTMENT NAME</th>
            <th>OLD STATUS</th>
            <th>NEW STATUS</th>
        </tr>
    </thead>
    <tbody>
        @foreach($differences as $difference)
            <tr>
                <td>{{ $difference['staff_id_rw'] }}</td>
                <td>{{ $difference['staff_name'] }}</td>
                <td>{{ $difference['dept_id'] }}</td>
                <td>{{ $difference['dept_name'] }}</td>
                <td class="highlight">{{ $difference['old_status'] }}</td>
                <td class="highlight">{{ $difference['new_status'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
