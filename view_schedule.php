<?php
// Start session
session_start();

// Include the database connection file
include('db_connect.php');

// Fetch updated schedules from the database
$query = "SELECT id, sport, teams, date, time, venue, assigned_officials FROM schedules ORDER BY date, time";
$result = mysqli_query($conn, $query);

// Check for database query errors
if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Schedule</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            text-align: center;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1, h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        table th {
            background-color: #007BFF;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .back-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <header>
        <h1>View Match Schedule</h1>
    </header>
    <main class="container">
        <h2>Match Schedules</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sport</th>
                    <th>Teams</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Venue</th>
                    <th>Assigned Officials</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id'] ?? 'N/A') . "</td>";
                        echo "<td>" . htmlspecialchars($row['sport'] ?? 'N/A') . "</td>";
                        echo "<td>" . htmlspecialchars($row['teams'] ?? 'N/A') . "</td>";
                        echo "<td>" . htmlspecialchars($row['date'] ?? 'N/A') . "</td>";
                        echo "<td>" . (!empty($row['time']) ? date("g:i A", strtotime($row['time'])) : 'N/A') . "</td>";
                        echo "<td>" . htmlspecialchars($row['venue'] ?? 'N/A') . "</td>";
                        echo "<td>" . (!empty($row['assigned_officials']) ? htmlspecialchars($row['assigned_officials']) : 'N/A') . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No matches scheduled yet.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>
