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

// Check if the nurse is logged in
if (!isset($_SESSION['nurse_id'])) {
    header("Location: index.php"); // Redirect to login page if session is not active
    exit;
}

// Retrieve nurse ID from the session
$nurse_id = $_SESSION['nurse_id'];

// Pagination setup
$records_per_page = 8; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
$offset = ($page - 1) * $records_per_page; // Offset for SQL query

// Fetch total records for pagination
$total_records_sql = "SELECT COUNT(*) AS total FROM leave_requests WHERE nurse_id = ?";
$total_stmt = $conn->prepare($total_records_sql);
$total_stmt->bind_param("s", $nurse_id);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_records = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_records / $records_per_page);

// Fetch leave records with pagination
$sql = "SELECT id, nurse_id, from_date, from_time, to_date, to_time, reason, status 
        FROM leave_requests 
        WHERE nurse_id = ? 
        LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $nurse_id, $offset, $records_per_page);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Summary</title>
    <link rel="stylesheet" href="leave_summary.css">
</head>
<body>
    <div class="dashboard-container">
        <aside>
            <h2>Nurse Portal</h2>
            <ul>
                <li><a href="nurse_dashboard.php">Home</a></li>
                <li><a href="view_task.php">View Tasks</a></li>
                <li><a href="leave_apply.php">Apply for Leave</a></li>
                <li><a href="patient_notes.php">Patient Notes</a></li>
                <li><a href="patient_history.php">Patient History</a></li>
                <li><a href="leave_summary.php">Leave Summary</a></li>
                <li><a href="./alternate_viewtask.php">Alternate View Task</a></li>
                <li><a href="./logout.php">Log out</a></li>

            </ul>
        </aside>
        <main>
            <h1>Leave Summary</h1>
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
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php $sno = $offset + 1; ?>
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
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="8">No leave records found.</td></tr>
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

    <script src="leave_summary.js"></script>
</body>
</html>

<?php 
$stmt->close(); 
$total_stmt->close(); 
$conn->close(); 
?>