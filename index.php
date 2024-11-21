<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Care Track Login</title>
    <link rel="stylesheet" href="./index.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <div class="logo">
                    <img src="./images/hospital.png" alt="Health Care Logo">
                </div>
                <h1>CARE TRACK</h1>
            </div>
            <div class="buttons">
                <button onclick="redirectTo('admin')">Admin</button>
                <button onclick="redirectTo('doctor')">Doctor</button>
                <button onclick="redirectTo('nurse')">Nurse</button>
            </div>
        </div>
    </div>
    <script>
        function redirectTo(role) {
            if (role === 'admin') {
                window.location.href = './admin/admin_login.php';
            }
            else if (role === 'doctor') {
                window.location.href = './doctor/doctor_login.php';
            }
            else if (role === 'nurse') {
                window.location.href = './nurse/nurse_login.php';
            }
        }
    </script>
</body>
</html>
