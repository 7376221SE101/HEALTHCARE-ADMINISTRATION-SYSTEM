<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['nurse_id'])) {
    header("Location: login.html");
    exit;
}

$nurse_id = $_SESSION['nurse_id']; // Get the logged-in nurse's ID

// Database connection
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "care_track";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch nurse details based on session nurse_id
$stmt = $conn->prepare("SELECT name FROM nurses WHERE nurse_id = ?");
$stmt->bind_param("s", $nurse_id);
$stmt->execute();
$result = $stmt->get_result();

$nurse_name = "Unknown"; // Default fallback
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nurse_name = $row['name'];
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nurse Portal</title>
    <link rel="stylesheet" href="nurse_dashboard.css">
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
                    <p>Welcome back, <strong><?php echo htmlspecialchars($nurse_name); ?></strong></p>
                </div>
                <div class="task-overview">
                    <h3>Task Overview</h3>
                    <p>Number of Days Present: <span>500</span></p>
                    <p>Number of Days Absent: <span>5</span></p>
                </div>
                <div class="task-stats">
                    <canvas id="taskStatsChart"></canvas>
                </div>
                <div class="nurse-profile">
                    <h3>NURSE</h3>
                    <p>ID: <?php echo htmlspecialchars($nurse_id); ?></p>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="nurse_dashboard.js"></script>
</body>
</html>




