<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Change if different
$password = ""; // Change if your MySQL has a password
$dbname = "kct_sports"; // Ensure this is the correct database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo "<script>alert('You are not logged in. Please log in first.'); window.location.href='login.html';</script>";
    exit();
}

$username = $_SESSION['username']; // Retrieve username from session
$matches = [];

// Use prepared statement to prevent SQL injection
$sql = "SELECT * FROM schedules WHERE FIND_IN_SET(?, assigned_officials)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Fetch data into an array
while ($row = $result->fetch_assoc()) {
    $matches[] = $row;
}

$stmt->close();

// Handle score update when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['schedule_id'], $_POST['score'])) {
    $schedule_id = $_POST['schedule_id'];
    $new_score = trim($_POST['score']);

    // Validate input
    if (!empty($new_score)) {
        $update_sql = "UPDATE schedules SET score = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $new_score, $schedule_id);

        if ($update_stmt->execute()) {
            echo "<script>alert('Score updated successfully!'); window.location.href='assigned_matches.php';</script>";
        } else {
            echo "<script>alert('Error updating score. Please try again.'); window.history.back();</script>";
        }

        $update_stmt->close();
    } else {
        echo "<script>alert('Invalid input. Please enter a score.'); window.history.back();</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match Schedule</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background-color: #f4f4f4; padding: 20px; }
        table { width: 80%; margin: 20px auto; border-collapse: collapse; background: white; }
        th, td { padding: 10px; border: 1px solid #ccc; }
        th { background: #007bff; color: white; }
        input { padding: 5px; }
        button { padding: 5px 10px; background: green; color: white; border: none; cursor: pointer; }
        button:hover { background: darkgreen; }
        .back-btn { display: block; margin: 20px auto; padding: 10px 15px; background: #dc3545; color: white; text-decoration: none; border-radius: 5px; }
        .back-btn:hover { background: #a71d2a; }
    </style>
</head>
<body>

<h2>🏆 Match Schedule for <span style="color: green;"><?php echo htmlspecialchars($username); ?></span></h2>

<?php if (!empty($matches)): ?>
    <table>
        <tr>
            <th>Sport</th>
            <th>Teams</th>
            <th>Date</th>
            <th>Time</th>
            <th>Venue</th>
            <th>Score</th>
            <th>Update Score</th>
        </tr>
        <?php foreach ($matches as $match): ?>
        <tr>
            <td><?php echo htmlspecialchars($match['sport']); ?></td>
            <td><?php echo htmlspecialchars($match['teams']); ?></td>
            <td><?php echo htmlspecialchars($match['date']); ?></td>
            <td><?php echo htmlspecialchars($match['time']); ?></td>
            <td><?php echo htmlspecialchars($match['venue']); ?></td>
            <td><?php echo htmlspecialchars($match['score'] ?: 'Not updated'); ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="schedule_id" value="<?php echo $match['id']; ?>">
                    <input type="text" name="score" placeholder="Enter new score" required>
                    <button type="submit">Update</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p style="color: red; font-weight: bold;">❌ No matches assigned to you.</p>
<?php endif; ?>

<!-- Back Button -->
<a href="dashboard_official.html" class="back-btn">⬅️ Back to Dashboard</a>

</body>
</html>
