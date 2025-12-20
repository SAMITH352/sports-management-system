<?php
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

// Handle score update securely
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['match_id'], $_POST['score'])) {
    $match_id = intval($_POST['match_id']);
    $score = trim($_POST['score']);

    if (!empty($score) && $match_id > 0) {
        // Start transaction
        $conn->begin_transaction();
        try {
            $update_query = "UPDATE schedules SET score = ? WHERE id = ?";
            $stmt = $conn->prepare($update_query);
            
            if ($stmt) {
                $stmt->bind_param("si", $score, $match_id);
                if ($stmt->execute()) {
                    echo "<p style='color: green;'>Score updated successfully!</p>";
                } else {
                    throw new Exception("Error updating score: " . $stmt->error);
                }
                $stmt->close();
            } else {
                throw new Exception("Database error: " . $conn->error);
            }

            // Commit transaction
            $conn->commit();
        } catch (Exception $e) {
            // Rollback on error
            $conn->rollback();
            echo "<p style='color: red;'>" . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p style='color: red;'>Invalid input. Please enter a valid match ID and score.</p>";
    }
}

// Fetch match data
$result = $conn->query("SELECT id, sport, teams, date, time, venue, score FROM schedules");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scoreboard Management</title>
    <link rel="stylesheet" href="assets/css/styles.css">

    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        input { padding: 5px; }
        button { padding: 5px 10px; background-color: green; color: white; border: none; cursor: pointer; }
        button:hover { background-color: darkgreen; }
        .back-btn { background-color: #007bff; padding: 10px 15px; margin-top: 10px; display: inline-block; text-decoration: none; color: white; border-radius: 5px; }
        .back-btn:hover { background-color: #0056b3; }
    </style>
</head>
<body>

<h2>Manage Scoreboard</h2>

<!-- Back to Manage Schedule Button -->
<a href="dashboard_organizer.html" class="back-btn">Back</a>

<!-- Score Update Form -->
<form method="POST">
    <label for="match_id">Match ID:</label>
    <input type="number" name="match_id" required>
    <label for="score">Score:</label>
    <input type="text" name="score" required placeholder="e.g., 2-1 or 150/7">
    <button type="submit">Update Score</button>
</form>

<!-- Display Scoreboard -->
<h3>Live Scoreboard</h3>
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

</body>
</html>

<?php 
// Close database connection
$conn->close(); 
?>
