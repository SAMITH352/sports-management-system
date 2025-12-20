<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'kct_sports');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['match_id'])) {
    $match_id = intval($_GET['match_id']);

    // Fetch the schedule details
    $query = "SELECT * FROM schedules WHERE match_id = $match_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Match not found.";
        exit();
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sport = $_POST['sport'];
    $teams = $_POST['teams'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $venue = $_POST['venue'];

    // Update query
    $update_query = "UPDATE schedules SET sport='$sport', teams='$teams', date='$date', time='$time', venue='$venue' WHERE match_id = $match_id";

    if ($conn->query($update_query) === TRUE) {
        // Insert notification into the database
        $message = "Schedule updated: $sport - $teams on $date at $time, Venue: $venue";
        $conn->query("INSERT INTO notifications (message, status) VALUES ('$message', 'unread')");

        header("Location: manage_schedules.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Schedule</title>
</head>
<body>
    <h1>Edit Match Schedule</h1>
    <form method="POST">
        <label>Sport:</label>
        <input type="text" name="sport" value="<?php echo $row['sport']; ?>" required><br>
        <label>Teams:</label>
        <input type="text" name="teams" value="<?php echo $row['teams']; ?>" required><br>
        <label>Date:</label>
        <input type="date" name="date" value="<?php echo $row['date']; ?>" required><br>
        <label>Time:</label>
        <input type="time" name="time" value="<?php echo $row['time']; ?>" required><br>
        <label>Venue:</label>
        <input type="text" name="venue" value="<?php echo $row['venue']; ?>" required><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
