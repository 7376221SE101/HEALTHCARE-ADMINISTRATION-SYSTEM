<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Login</title>
    <link rel="stylesheet" href="doctor_login.css">
</head>
<body>
    <div class="login-container">
        <div class="logo-section">
        <img src="./hospital.png" alt="Health Care Logo" class="logo">           
            <h1>WELCOME 👋</h1>
        </div>
        <div class="login-form">
            <div class="user-selection">
                <button class="user-button">Admin</button>
                <button class="user-button active">Doctor</button>
                <button class="user-button">Nurse</button>
            </div>
            <h3>Login as Doctor</h3>
            <form action="./doctor_dashboard.php" method="POST">
                <label for="username">Username*</label>
                <input type="text" id="username" name="username" required>
                
                <label for="password">Password*</label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
 