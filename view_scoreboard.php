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

$match = null;

// Fetch match score if Match ID is provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['match_id'])) {
    $match_id = intval($_POST['match_id']);

    if ($match_id > 0) {
        $stmt = $conn->prepare("SELECT id, sport, teams, date, time, venue, score FROM schedules WHERE id = ?");
        $stmt->bind_param("i", $match_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $match = $result->fetch_assoc();
        } else {
            $error = "❌ No match found with the given Match ID.";
        }
        $stmt->close();
    } else {
        $error = "⚠️ Please enter a valid Match ID.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match Score Viewer</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; text-align: center; }
        .container { max-width: 500px; margin: auto; padding: 20px; background: white; border-radius: 10px; box-shadow: 0px 0px 10px gray; }
        h2 { color: #333; }
        .input-group { margin: 15px 0; }
        input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px; }
        button { width: 100%; padding: 10px; background: green; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        button:hover { background: darkgreen; }
        .match-details { margin-top: 20px; padding: 10px; background: #fffbe6; border-left: 5px solid #ffcc00; }
        .error { color: red; font-weight: bold; }
        .back-btn { display: block; margin-top: 20px; padding: 10px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; text-align: center; }
        .back-btn:hover { background: #0056b3; }
    </style>
</head>
<body>

<div class="container">
    <h2>🔍 View Match Score</h2>

    <!-- Form to Enter Match ID -->
    <form method="POST">
        <div class="input-group">
            <label for="match_id"><strong>Enter Match ID:</strong></label>
            <input type="number" name="match_id" required>
        </div>
        <button type="submit">Check Score</button>
    </form>

    <!-- Display Match Details -->
    <?php if (isset($match)): ?>
        <div class="match-details">
            <h3>🏆 Match Details</h3>
            <p><strong>Sport:</strong> <?php echo htmlspecialchars($match['sport']); ?></p>
            <p><strong>Teams:</strong> <?php echo htmlspecialchars($match['teams']); ?></p>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($match['date']); ?></p>
            <p><strong>Time:</strong> <?php echo htmlspecialchars($match['time']); ?></p>
            <p><strong>Venue:</strong> <?php echo htmlspecialchars($match['venue']); ?></p>
            <p><strong>Score:</strong> <span style="color:green;"><?php echo htmlspecialchars($match['score'] ?: 'N/A'); ?></span></p>
        </div>
    <?php elseif (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <!-- Back Button -->
    <a href="dashboard_viewer.html" class="back-btn">⬅ Back to Dashboard</a>
</div>

</body>
</html>
