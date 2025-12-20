<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kct_sports";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if POST data is set
if (isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['role'])) {
    // Get form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Check if email already exists
    $sql_check = "SELECT * FROM users WHERE email=?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Signup Status</title>
        <link rel='stylesheet' href='./assets/css/styles.css'>
        <link rel='stylesheet' href='./assets/css/forms.css'>
    </head>
    <body>
    <section class='form-section'>
        <div class='form-container'>";

    if ($result->num_rows > 0) {
        echo "<h2 class='form-title'>Signup Failed</h2>
              <p class='error-message'>Email already registered. Please use a different email.</p>
              <a href='signup.html' class='form-button'>Go Back</a>";
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into database
        $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);

        if ($stmt->execute()) {
            echo "<h2 class='form-title'>Signup Successful!</h2>
                  <p class='success-message'>You can now <a href='login.html'>Login</a></p>";
        } else {
            echo "<h2 class='form-title'>Error</h2>
                  <p class='error-message'>Something went wrong. Please try again.</p>";
        }

        $stmt->close();
    }

    echo "</div>
    </section>
    <footer>
        <p>&copy; KCT Sports Hub. All rights reserved.</p>
    </footer>
    </body>
    </html>";

} else {
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Error</title>
        <link rel='stylesheet' href='./assets/css/styles.css'>
        <link rel='stylesheet' href='./assets/css/forms.css'>
    </head>
    <body>
    <section class='form-section'>
        <div class='form-container'>
            <h2 class='form-title'>Signup Failed</h2>
            <p class='error-message'>Please fill in all the required fields.</p>
            <a href='signup.html' class='form-button'>Go Back</a>
        </div>
    </section>
    <footer>
        <p>&copy; KCT Sports Hub. All rights reserved.</p>
    </footer>
    </body>
    </html>";
}

// Close connection
$conn->close();
?>
