<?php
include('db_doctor_connection.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Hash the password input using SHA-256
    $hashed_password = hash('sha256', $password);

    // Debugging output - remove these lines after testing
    echo "Computed Hash: " . $hashed_password . "<br>";

    $stmt = $conn->prepare("SELECT * FROM doctor_users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $hashed_password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        session_start();
        $_SESSION['admin_logged_in'] = true;
        header("Location: doctor_dashboard.php");
        exit();
    } else {
        header("Location: doctor_login.php?error=invalid_credentials");
        exit();
    }
}

?>
