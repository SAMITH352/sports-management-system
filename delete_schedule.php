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

// ✅ Delete schedule
$query = "DELETE FROM schedules WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('Schedule deleted successfully!'); window.location.href='manage_schedules.php';</script>";
} else {
    echo "Error deleting record: " . $conn->error;
}
// Notify WebSocket clients
$notification = json_encode(["message" => "Match deleted"]);
file_get_contents("http://localhost:8080?message=" . urlencode($notification));

?>
