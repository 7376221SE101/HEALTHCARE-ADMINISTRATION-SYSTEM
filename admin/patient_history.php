<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "care_track";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination variables
$limit = 8; // Number of tasks per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$start = ($page - 1) * $limit;

// Fetch total number of tasks
$total_tasks_query = $conn->prepare("SELECT COUNT(*) AS total FROM patient_notes");
$total_tasks_query->execute();
$total_tasks_result = $total_tasks_query->get_result();
$total_tasks = $total_tasks_result->fetch_assoc()['total'];
$total_tasks_query->close();

// Calculate total pages
$total_pages = ceil($total_tasks / $limit);

// Fetch patient notes for the current page
$sql = "SELECT nurse_id, patient_name, note, created_at FROM patient_notes ORDER BY created_at DESC LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $start, $limit);
$stmt->execute();
$result = $stmt->get_result();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient History</title>
    <link rel="stylesheet" href="patient_history.css">
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
                <li><a href="./alternate_viewtask.php">View Alternate Task</a></li>
                <li><a href="./logout.php">Log out</a></li>
            </ul>
        </aside>
        
        <main>
            <div class="main-content-wrapper">
                <h1>Patient History</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Note</th>
                            <th>Nurse ID</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['note']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nurse_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No patient notes available.</td>
                            </tr>
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
        </main>
    </div>
    <script src="patient_history.js"></script>
</body>
</html>
2