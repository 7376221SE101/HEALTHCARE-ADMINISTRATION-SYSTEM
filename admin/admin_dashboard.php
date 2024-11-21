<!-- admin_dashboard.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal</title>
    <link rel="stylesheet" href="./admin_dashboard.css">
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
                <div class="greeting">
                    <h2>Hello! Admin <span>👋</span></h2>
                </div>
                <div class="task-overview">
                    <h3>Task Overview</h3>
                    <p>Number of Staffs Present: <span>500</span></p>
                    <p>Number of Staffs Absent: <span>5</span></p>
                </div>
                <div class="task-stats">
                    <canvas id="taskStatsChart"></canvas>
                </div>
                <div class="admin-profile">
                    <h3>ADMIN</h3>
                    <p>ADM001</p>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="./admin_dashboard.js"></script>
</body>
</html>
