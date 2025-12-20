<?php
$host = "localhost"; // Server hostname
$username = "root";  // Database username
$password = "";      // Database password
$dbname = "kct_sports"; // Database name

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
