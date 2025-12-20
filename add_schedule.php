<?php
session_start();
include('db_connect.php');    

// ✅ Ensure only organizers can access this page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'organizer') {
    echo "<script>alert('Access denied! Only organizers can add schedules.'); window.location.href='manage_schedules.php';</script>";
    exit();
}

// ✅ Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sport = mysqli_real_escape_string($conn, $_POST['sport']);
    $teams = mysqli_real_escape_string($conn, $_POST['teams']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $venue = mysqli_real_escape_string($conn, $_POST['venue']);
    
    $query = "INSERT INTO schedules (sport, teams, date, time, venue) VALUES ('$sport', '$teams', '$date', '$time', '$venue')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Match added successfully!'); window.location.href='./manage_schedules.php';</script>";
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    // Notify WebSocket clients
$notification = json_encode(["message" => "New match added: $teams on $date"]);
file_get_contents("http://localhost:8080?message=" . urlencode($notification));

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Match</title>
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
            margin: 20px auto;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-weight: bold;
            margin-top: 10px;
        }
        input, select {
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .submit-btn {
            margin-top: 20px;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }
        .submit-btn:hover {
            background-color: #218838;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: blue;
            text-decoration: none;
            font-size: 16px;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>Add New Match</h1>
        <a class="back-link" href="manage_schedules.php">Back to Manage Schedules</a>
    </header>
    <main class="container">
        <form method="POST" action="">
            <label for="sport">Sport:</label>
            <input type="text" name="sport" id="sport" required>
            
            <label for="teams">Teams:</label>
            <input type="text" name="teams" id="teams" required>
            
            <label for="date">Date:</label>
            <input type="date" name="date" id="date" required>
            
            <label for="time">Time:</label>
            <input type="time" name="time" id="time" required>
            
            <label for="venue">Venue:</label>
            <input type="text" name="venue" id="venue" required>
            
            <button type="submit" class="submit-btn">Add Match</button>
        </form>
    </main>
</body>
</html>