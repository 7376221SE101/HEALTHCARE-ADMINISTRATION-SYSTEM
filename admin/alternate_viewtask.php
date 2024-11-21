<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "care_track";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination variables
$limit = 5; // Number of tasks per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$start = ($page - 1) * $limit;

// Fetch total number of alternate tasks
$total_tasks_query = $conn->prepare("SELECT COUNT(*) AS total FROM alternate_tasks");
$total_tasks_query->execute();
$total_tasks_result = $total_tasks_query->get_result();
$total_tasks = $total_tasks_result->fetch_assoc()['total'];
$total_tasks_query->close();

// Fetch alternate tasks for the current page
$stmt = $conn->prepare("SELECT title, description, assigned_to, due_date, status FROM alternate_tasks LIMIT ?, ?");
$stmt->bind_param("ii", $start, $limit);
$stmt->execute();
$result = $stmt->get_result();

$alternate_tasks = [];
while ($row = $result->fetch_assoc()) {
    $alternate_tasks[] = $row;
}

$stmt->close();
$conn->close();

// Calculate total pages
$total_pages = ceil($total_tasks / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Alternate Tasks</title>
    <link rel="stylesheet" href="./alternate_viewtask.css">
</head>
<body>
    <div class="dashboard-container">
        <aside>
            <h2>Admin Portal</h2>
            <ul>
                <li><a href="admin_dashboard.php">Home</a></li>
                <li><a href="./create_task.php">Create Task</a></li>
                <li><a href="./patient_history.php">Patient History</a></li>
                <li><a href="alternate_task.php">Alternate Task</a></li>
                <li><a href="./leave_approve.php">Leave Approval</a></li>
                <li><a href="./view_task.php">View Task</a></li>
                <li><a href="./alternate_viewtask.php" class="active">View Alternate Task</a></li>
                <li><a href="./logout.php">Log out</a></li>
            </ul>
        </aside>
        <main>
            <div class="main-content-wrapper">

                <div class="task-list-container">
                    <h1>All Alternate Tasks</h1>
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Assigned To</th>
                                <th>Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($alternate_tasks)): ?>
                                <?php foreach ($alternate_tasks as $task): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($task['title']); ?></td>
                                        <td><?php echo htmlspecialchars($task['description']); ?></td>
                                        <td><?php echo htmlspecialchars($task['assigned_to']); ?></td>
                                        <td><?php echo htmlspecialchars($task['due_date']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4">No alternate tasks assigned.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="pagination">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?php echo $page - 1; ?>" class="prev">Previous</a>
                        <?php else: ?>
                            <span class="disabled">Previous</span>
                        <?php endif; ?>
                        
                        <?php if ($page < $total_pages): ?>
                            <a href="?page=<?php echo $page + 1; ?>" class="next">Next</a>
                        <?php else: ?>
                            <span class="disabled">Next</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
