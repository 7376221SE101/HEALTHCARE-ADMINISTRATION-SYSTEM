<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Portal</title>
    <link rel="stylesheet" href="./doctor_dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <aside>
            <h2>Doctor Portal</h2>
            <ul>
                <li><a href="./doctor_dashboard.php">Home</a></li>
                <li><a href="./patient_history.php">Patient History</a></li>
                <li><a href="./logout.php">Log out</a></li>
            </ul>
        </aside>
        <main>
            <div class="main-content-wrapper">
                <!-- Greeting Section -->
                <div class="greeting">
                    <h2>Hello! Doctor <span>👋</span></h2>
                </div>
                <!-- Task Overview Section -->
                <div class="task-overview">
                    <h3>Task Overview</h3>
                    <p>Number of Days Present: <span>87</span></p>
                    <p>Number of Days Absent: <span>9</span></p>
                </div>
                <!-- Chart Section -->
                <div class="task-stats">
                    <canvas id="taskStatsChart"></canvas>
                </div>
                <!-- Profile Section -->
                <div class="admin-profile">
                    <h3>DOCTOR</h3>
                    <p>DOC001</p>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="./doctor_dashboard.js"></script> <!-- Linked JavaScript file -->
</body>
</html>
