<?php
session_start();

// If user is already logged in, prevent accessing login page again
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard_viewer.html");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kct_sports";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Ensure form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password_input = $_POST['password'];
    $role = trim($_POST['role']);

    // Fetch user details from database
    $sql = "SELECT id, username, password, role FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password_input, $row['password'])) {
            if (strcasecmp(trim($row['role']), $role) === 0 || empty($role)) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = strtolower($row['role']);
                $_SESSION['logged_in'] = true;

                // ✅ Set sessionStorage to track login status
                echo "<script>sessionStorage.setItem('loggedIn', 'true');</script>";

                // Redirect based on role
                switch ($_SESSION['role']) {
                    case 'organizer':
                        header("Location: dashboard_organizer.html");
                        exit();
                    case 'player':
                        header("Location: dashboard_player.html");
                        exit();
                    case 'match official':
                        header("Location: dashboard_official.html");
                        exit();
                    case 'viewer':
                        header("Location: dashboard_viewer.html");
                        exit();
                    default:
                        header("Location: index.html");
                        exit();
                }
            } else {
                echo "<script>alert('❌ Role mismatch! Please select the correct role.'); window.location.href='login.html';</script>";
            }
        } else {
            echo "<script>alert('❌ Invalid password! Please try again.'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('❌ User not found! Please register first.'); window.location.href='login.html';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
