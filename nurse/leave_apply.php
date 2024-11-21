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

// Handle form submission to apply for leave
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $from_date = $_POST['from_date'];
    $from_time = $_POST['from_time'];
    $to_date = $_POST['to_date'];
    $to_time = $_POST['to_time'];
    $reason = $_POST['reason'];


    // Update the SQL query to include `from_time` and `to_time`
    $sql = "INSERT INTO leave_requests (nurse_id, from_date, from_time, to_date, to_time, reason, status) 
            VALUES (?, ?, ?, ?, ?, ?, 'Pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $nurse_id, $from_date, $from_time, $to_date, $to_time, $reason);

    if ($stmt->execute()) {
        $success_message = "Leave application submitted successfully.";
    } else {
        $error_message = "Failed to submit leave application.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Leave</title>
    <link rel="stylesheet" href="leave_apply.css">
</head>
<body>
    <div class="dashboard-container">
        <aside>
            <h2>Nurse Portal</h2>
            <ul>
                <li><a href="nurse_dashboard.php">Home</a></li>
                <li><a href="view_task.php">View Tasks</a></li>
                <li><a href="leave_apply.php">Leave Apply</a></li>
                <li><a href="patient_notes.php">Patient Notes</a></li>
                <li><a href="patient_history.php">Patient History</a></li>
                <li><a href="leave_summary.php">Leave Summary</a></li>
                <li><a href="./alternate_viewtask.php">Alternate View Task</a></li>
                <li><a href="logout.php">Log out</a></li>
            </ul>
        </aside>
        <main>
            <div class="form-container">
                <h1>Apply for Leave</h1>

                <!-- Display success or error messages -->
                <?php if (isset($success_message)): ?>
                    <p class="success"><?php echo htmlspecialchars($success_message); ?></p>
                <?php elseif (isset($error_message)): ?>
                    <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
                <?php endif; ?>

                <!-- Leave application form -->
                <form id="applyleaveForm" action="leave_apply.php" method="POST">
                    <label for="nurse_id">Nurse ID:</label>
                    <input type="text" id="nurse_id" name="nurse_id" value="<?php echo htmlspecialchars($nurse_id); ?>" readonly required>

                    <label for="from_date">From Date:</label>
                    <input type="date" id="from_date" name="from_date" required>

                    <label for="from_time">From Time:</label>
                    <input type="time" id="from_time" name="from_time" required>

                    <label for="to_date">To Date:</label>
                    <input type="date" id="to_date" name="to_date" required>

                    <label for="to_time">To Time:</label>
                    <input type="time" id="to_time" name="to_time" required>

                    <label for="reason">Reason:</label>
                    <textarea id="reason" name="reason" required></textarea>

                    

                    <div class="button-group">
                        <button type="submit">Submit</button>
                        <button type="reset">Cancel</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
    <script src="leave_apply.js"></script>
</body>
</html>
