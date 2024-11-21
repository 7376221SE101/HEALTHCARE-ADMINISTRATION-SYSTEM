<?php
// Start the session
session_start();

// Check if the nurse_id is set in the session
if (isset($_SESSION['nurse_id'])) {
    // Retrieve nurse_id from session
    $nurse_id = $_SESSION['nurse_id'];

    // Check if the nurse_id corresponds to nurse1 or nurse2
    if ($nurse_id === 'NUR001' || $nurse_id === 'NUR002') {
        // Destroy the session
        session_unset();
        session_destroy();

        // Redirect to nurse login page
        header("Location: nurse_login.php");
        exit();
    }
}

// If the nurse_id is not set or does not match, redirect to a general login page
header("Location: nurse_login.php");
exit();
?>
