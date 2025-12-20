<?php
session_start();
include('db_connect.php');

// ✅ Check if user is an organizer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'organizer') {
    echo "<script>alert('Access denied!'); window.location.href='dashboard.php';</script>";
    exit();
}

// ✅ Check if ID is provided
if (!isset($_GET['id'])) {
    echo "<script>alert('Invalid request!'); window.location.href='manage_schedules.php';</script>";
    exit();
}

$id = $_GET['id'];

// ✅ Fetch schedule details
$query = "SELECT * FROM schedules WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$schedule = $result->fetch_assoc();

if (!$schedule) {
    echo "<script>alert('Schedule not found!'); window.location.href='manage_schedules.php';</script>";
    exit();
}

// ✅ Update schedule
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sport = $_POST['sport'];
    $teams = $_POST['teams'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $venue = $_POST['venue'];

    $update_query = "UPDATE schedules SET sport=?, teams=?, date=?, time=?, venue=? WHERE id=?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssssi", $sport, $teams, $date, $time, $venue, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Schedule updated successfully!'); window.location.href='manage_schedules.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    // Notify WebSocket clients
$notification = json_encode(["message" => "Match updated: $teams on $date"]);
file_get_contents("http://localhost:8080?message=" . urlencode($notification));

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Schedule</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input[type="text"], input[type="date"], input[type="time"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            width: 100%;
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px;
            margin-top: 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
            color: #007BFF;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Edit Schedule</h1>
    <form method="POST">
        <label>Sport:</label>
        <input type="text" name="sport" value="<?= htmlspecialchars($schedule['sport']) ?>" required>

        <label>Teams:</label>
        <input type="text" name="teams" value="<?= htmlspecialchars($schedule['teams']) ?>" required>

        <label>Date:</label>
        <input type="date" name="date" value="<?= htmlspecialchars($schedule['date']) ?>" required>

        <label>Time:</label>
        <input type="time" name="time" value="<?= htmlspecialchars($schedule['time']) ?>" required>

        <label>Venue:</label>
        <input type="text" name="venue" value="<?= htmlspecialchars($schedule['venue']) ?>" required>

        <button type="submit">Update</button>
    </form>
    <a href="manage_schedules.php" class="back-link">Back to Manage Schedules</a>
</div>

</body>
</html>
