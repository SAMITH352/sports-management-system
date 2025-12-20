<?php
session_start();

// Set a test session variable
if (!isset($_SESSION['test'])) {
    $_SESSION['test'] = "Session is working!";
}

echo "Session Test: " . $_SESSION['test'] . "<br>";

if (isset($_SESSION['user_id'])) {
    echo "✅ User ID: " . $_SESSION['user_id'] . " | Role: " . $_SESSION['role'];
} else {
    echo "❌ User not found in session!";
}
?>
