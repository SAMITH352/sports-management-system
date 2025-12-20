<?php
session_start();
session_destroy(); // Destroy session

// Prevent back button issue
echo "<script>
    sessionStorage.clear();
    localStorage.clear();
    window.location.href = 'login.html';
</script>";
exit();
?>
