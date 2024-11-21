<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('db_view_connection.php');

// Check if nurse_id is set in the session; if not, redirect to the login page
if (!isset($_SESSION['nurse_id'])) {
    header("Location: admin_login.php?error=not_logged_in");
    exit;
}

// Get nurse_id from the session
$nurse_id = $_SESSION['nurse_id'];

// Prepare and execute the query to fetch tasks assigned to the logged-in nurse
$stmt = $conn->prepare("SELECT title, description, due_date, status FROM tasks WHERE assigned_to = ?");
$stmt->bind_param("s", $nurse_id);
$stmt->execute();
$result = $stmt->get_result();

// Store the fetched tasks in the session to display them on view_task.php
$_SESSION['tasks'] = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>
