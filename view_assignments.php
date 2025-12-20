<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$host = "localhost";
$user = "root";  // Change if needed
$pass = "";      // Change if needed
$dbname = "kct_sports";

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the logged-in username
$username = $_SESSION['username'];

// Fetch matches assigned to the logged-in user
$stmt = $conn->prepare("
    SELECT s.id, s.sport, s.teams, s.date, s.time, s.venue, s.score
    FROM schedules s
    INNER JOIN assignments a ON s.id = a.match_id
    WHERE a.username = ?
");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Assigned Matches</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; text-align: center; }
        .container { max-width: 800px; margin: auto; padding: 20px; background: white; border-radius: 10px; box-shadow: 0px 0px 10px gray; }
        h2 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: center; }
        th { background-color: #ffcc00; }
        td { background-color: #fff; }
        .back-btn { display: block; margin-top: 20px; padding: 10px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; text-align: center; }
        .back-btn:hover { background: #0056b3; }
    </style>
</head>
<body>

<div class="container">
    <h2>🏆 Matches Assigned to <span style="color: green;"><?php echo htmlspecialchars($username); ?></span></h2>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Match ID</th>
                <th>Sport</th>
                <th>Teams</th>
                <th>Date</th>
                <th>Time</th>
                <th>Venue</th>
                <th>Score</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['sport']); ?></td>
                <td><?php echo htmlspecialchars($row['teams']); ?></td>
                <td><?php echo htmlspecialchars($row['date']); ?></td>
                <td><?php echo htmlspecialchars($row['time']); ?></td>
                <td><?php echo htmlspecialchars($row['venue']); ?></td>
                <td><?php echo htmlspecialchars($row['score'] ?: 'N/A'); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No matches assigned to you.</p>
    <?php endif; ?>

    <a href="dashboard_official.html" class="back-btn">⬅ Back to Dashboard</a>
</div>

</body>
</html>

<?php 
$stmt->close();
$conn->close(); 
?>
