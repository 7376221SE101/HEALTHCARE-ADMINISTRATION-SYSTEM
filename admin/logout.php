<?php
// Start the session
session_start();

// Check if the username is set in the session
if (isset($_SESSION['username'])) {
    // Retrieve username from session
    $username = $_SESSION['username'];

    // Check if the username is admin
    if ($username === 'admin') {
        // Destroy the session
        session_unset();
        session_destroy();

        // Redirect to admin login page
        header("Location: admin_login.php");
        exit();
    } 
}

// If no valid session exists, redirect to a general login page
header("Location: admin_login.php");
exit();
?>
