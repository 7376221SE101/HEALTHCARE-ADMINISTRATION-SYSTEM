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

// Pagination setup
$records_per_page = 15; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
$offset = ($page - 1) * $records_per_page; // Offset for SQL query

// Fetch total records for pagination
$total_records_sql = "SELECT COUNT(*) AS total FROM leave_requests";
$total_result = $conn->query($total_records_sql);
$total_records = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_records / $records_per_page);

// Fetch leave requests with pagination
$sql = "SELECT id, nurse_id, from_date, from_time, to_date, to_time, reason, status 
        FROM leave_requests 
        LIMIT $offset, $records_per_page";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Approval</title>
    <link rel="stylesheet" href="leave_approve.css">
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
            <h1>Leave Requests</h1>
            <table>
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Nurse ID</th>
                        <th>From Date</th>
                        <th>From Time</th>
                        <th>To Date</th>
                        <th>To Time</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php $sno = 1; ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $sno++ ?></td>
                                <td><?= $row['nurse_id'] ?></td>
                                <td><?= $row['from_date'] ?></td>
                                <td><?= $row['from_time'] ?></td>
                                <td><?= $row['to_date'] ?></td>
                                <td><?= $row['to_time'] ?></td>
                                <td><?= $row['reason'] ?></td>
                                <td class="status"><?= $row['status'] ?></td>
                                <td>
                                    <?php if ($row['status'] == 'Pending'): ?>
                                        <button class="approve-btn" data-id="<?= $row['id'] ?>">Approve</button>
                                        <button class="deny-btn" data-id="<?= $row['id'] ?>">Deny</button>
                                    <?php else: ?>
                                        <?= $row['status'] ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="9">No leave requests found.</td></tr>
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
        </main>
    </div>

    <script src="leave_approve.js"></script>
</body>
</html>

<?php $conn->close(); ?>
