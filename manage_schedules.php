<?php
session_start();
include('db_connect.php');

// ✅ Ensure only organizers can access this page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'organizer') {
    echo "<script>alert('Access denied! Only organizers can manage schedules.'); window.location.href='dashboard.php';</script>";
    exit();
}

// ✅ Fetch schedules from database
$query = "SELECT * FROM schedules ORDER BY date, time";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Schedules</title>
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
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
        .action-links a {
            margin: 0 5px;
            text-decoration: none;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .edit {
            background-color:rgb(0, 255, 174);
        }
        .add {
            background-color:rgb(102, 211, 29);
        }
        .delete {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <header>
        <h1>Manage Schedules</h1>
        <a href="dashboard_organizer.html">Back to Dashboard</a>
        <a href="index.html" class="logout">Logout</a>
    </header>
    <main class="container">
        <h2>Schedules</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sport</th>
                    <th>Teams</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Venue</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['sport']) ?></td>
                        <td><?= htmlspecialchars($row['teams']) ?></td>
                        <td><?= htmlspecialchars($row['date']) ?></td>
                        <td><?= date("g:i A", strtotime($row['time'])) ?></td>
                        <td><?= htmlspecialchars($row['venue']) ?></td>
                        <td class="action-links">
                        <a href="add_schedule.php?id=<?= $row['id'] ?>" class="add">Add</a>
                            <a href="edit_schedule.php?id=<?= $row['id'] ?>" class="edit">Edit</a>
                            <a href="delete_schedule.php?id=<?= $row['id'] ?>" class="delete" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
