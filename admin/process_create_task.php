<?php
include('db_create_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_title = $_POST['title'];
    $task_description = $_POST['description'];
    $assigned_to = $_POST['assigned_to']; // Ensure this matches the nurse's unique ID (e.g., NUR001)
    $due_date = $_POST['due_date'];

    // Prepare and execute the insert statement
    $stmt = $conn->prepare("INSERT INTO tasks (title, description, assigned_to, due_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $task_title, $task_description, $assigned_to, $due_date);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?success=task_created");
    } else {
        header("Location: create_task.php?error=task_creation_failed");
    }
}
?>
