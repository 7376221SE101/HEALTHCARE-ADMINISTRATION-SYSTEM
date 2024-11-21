<?php
session_start();
if (!isset($_SESSION['nurse_id'])) {
    header("Location: index.php");
    exit;
}

$nurse_id = $_SESSION['nurse_id']; // Retrieve nurse_id from session

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "care_track";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination variables
$limit = 8; // Number of tasks per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$start = ($page - 1) * $limit;

// Fetch total number of tasks for the nurse
$total_tasks_query = $conn->prepare("SELECT COUNT(*) AS total FROM tasks WHERE assigned_to = ?");
$total_tasks_query->bind_param("s", $nurse_id);
$total_tasks_query->execute();
$total_tasks_result = $total_tasks_query->get_result();
$total_tasks = $total_tasks_result->fetch_assoc()['total'];
$total_tasks_query->close();

// Fetch tasks for the current page
$stmt = $conn->prepare("SELECT title, description, assigned_to, due_date, status FROM tasks WHERE assigned_to = ? LIMIT ?, ?");
$stmt->bind_param("sii", $nurse_id, $start, $limit);
$stmt->execute();
$result = $stmt->get_result();

$tasks = [];
while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
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
    <title>View Tasks</title>
    <link rel="stylesheet" href="view_task.css">
</head>
<body>
    <div class="dashboard-container">
        <aside>
            <h2>Nurse Portal</h2>
            <ul>
                <li><a href="nurse_dashboard.php">Home</a></li>
                <li><a href="./view_task.php">View Tasks</a></li>
                <li><a href="./leave_apply.php">Leave Apply</a></li>
                <li><a href="./patient_notes.php">Patient Notes</a></li>
                <li><a href="./patient_history.php">Patient History</a></li>
                <li><a href="leave_summary.php">Leave Summary</a></li>
                <li><a href="./alternate_viewtask.php">Alternate View Task</a></li>
                <li><a href="logout.php">Log out</a></li>
            </ul>
        </aside>
        <main>
            <div class="main-content-wrapper">
                <div class="greeting">
                    <h2>Hello! Nurse <span>👋</span></h2>
                </div>
                <div class="nurse-profile">
                    <h3>NURSE</h3>
                    <p>ID: <?php echo htmlspecialchars($nurse_id); ?></p>
                </div>
                <div class="task-list-container">
                    <h1>Your Assigned Tasks</h1>
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
                            <?php if (!empty($tasks)): ?>
                                <?php foreach ($tasks as $task): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($task['title']); ?></td>
                                        <td><?php echo htmlspecialchars($task['description']); ?></td>
                                        <td><?php echo htmlspecialchars($task['assigned_to']); ?></td>
                                        <td><?php echo htmlspecialchars($task['due_date']); ?></td>
                                        
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4">No tasks assigned to you.</td></tr>
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
