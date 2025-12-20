<?php
// Start session
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in as a player
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'player') {
    header("Location: login.php");
    exit();
}

// Sample player details (Replace with actual database values later)
$player_name = "Surya";
$player_sport = "Football";
$player_team = "KCT Warriors";
$player_position = "Forward";
$player_matches = 10;
$player_goals = 5;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #007BFF;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 24px;
        }
        .container {
            width: 50%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }
        h2 {
            color: #333;
        }
        .profile-info {
            text-align: left;
            font-size: 18px;
        }
        .profile-info p {
            margin: 10px 0;
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

    <div class="header">
        Player Profile
    </div>

    <div class="container">
        <h2>Player Details</h2>
        <div class="profile-info">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($player_name); ?></p>
            <p><strong>Sport:</strong> <?php echo htmlspecialchars($player_sport); ?></p>
            <p><strong>Team:</strong> <?php echo htmlspecialchars($player_team); ?></p>
            <p><strong>Position:</strong> <?php echo htmlspecialchars($player_position); ?></p>
            <p><strong>Matches Played:</strong> <?php echo $player_matches; ?></p>
            <p><strong>Goals Scored:</strong> <?php echo $player_goals; ?></p>
        </div>
        <a href="player_dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>

</body>
</html>
