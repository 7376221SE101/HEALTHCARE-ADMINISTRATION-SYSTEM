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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_name = $_POST['patient_name'];
    $note = $_POST['note'];

    // Insert the patient note into the database
    $stmt = $conn->prepare("INSERT INTO patient_notes (nurse_id, patient_name, note) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nurse_id, $patient_name, $note);

    if ($stmt->execute()) {
        $success_message = "Patient note added successfully.";
    } else {
        $error_message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Notes</title>
    <link rel="stylesheet" href="patient_notes.css">
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
                <li><a href="alternate_viewtask.php">Alternate View Task</a></li>
                <li><a href="logout.php">Log out</a></li>
            </ul>
        </aside>
        
        <main>
            <div class="main-content-wrapper">
                <h1>Patient Notes</h1>

                <!-- Display success or error messages -->
                <?php if (isset($success_message)): ?>
                    <p class="success"><?php echo htmlspecialchars($success_message); ?></p>
                <?php elseif (isset($error_message)): ?>
                    <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
                <?php endif; ?>

                <!-- Patient Note Form -->
                <div class="add-note-form">
                    <h2>Add New Patient Note</h2>
                    <form id="patientNoteForm" action="patient_notes.php" method="POST">
                        <label for="patient_name">Patient Name:</label>
                        <input type="text" id="patient_name" name="patient_name" required>
                        
                        <label for="note">Note:</label>
                        <textarea id="note" name="note" required></textarea>
                        
                        <input type="hidden" name="nurse_id" value="<?php echo htmlspecialchars($nurse_id); ?>">
                        <div class="button-group">
                            <button type="submit">Add Note</button>
                            <button type="button" onclick="window.location.href='patient_notes.php'">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script src="patient_notes.js"></script>
</body>
</html>
