<?php
include('db_create_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nurse_id = $_POST['nurse_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];

    $stmt = $conn->prepare("INSERT INTO alternate_tasks (nurse_id, title, description, due_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nurse_id, $title, $description, $due_date);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?success=alternate_task_created");
    } else {
        header("Location: alternate_task.php?error=alternate_task_failed");
    }

    $stmt->close();
    $conn->close();
}
?>
