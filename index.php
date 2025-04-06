<?php
session_start();
$conn = new mysqli("localhost", "root", "", "myshop");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = ""; // Initialize error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Check credentials
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password' AND role='$role'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        // Redirect to the correct dashboard
        if ($role === "admin") {
            header("Location: dashboard.php?id=" . $user['id']);
        } else {
            header("Location: user-dashboard.php?id=" . $user['id']);
        }
        exit(); // Stop script execution after redirect
    } else {
        $error_message = "Invalid email, password, or role.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            width: 100%;
            height: 100vh;
            background: linear-gradient(to left, rgba(13, 13, 25, 0.5) 50%, rgba(13, 13, 25, 0.5) 50%), url(scania.jpg) center / cover;
            background-repeat: no-repeat;
        }
        .container {
            width: 25%;
            padding: 20px;
            background: rgba(255, 255, 255, 0.2); /* Semi-transparent white */
            backdrop-filter: blur(10px); /* Blur effect */
            border-radius: 8px;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="container shadow">
        <h3 class="text-center">Login</h3>
        
        <!-- Error Message Box -->
        <div id="message-box">
            <?php if (!empty($error_message)) { echo '<div class="alert alert-danger">' . $error_message . '</div>'; } ?>
        </div>

        <form method="post">
            <div class="mb-2">
                <label>Email</label>
                <input type="email" name="email" class="form-control form-control-sm" required>
            </div>
            <div class="mb-2">
                <label>Password</label>
                <input type="password" name="password" class="form-control form-control-sm" required>
            </div>
            <div class="mb-2">
                <label>Role</label>
                <select name="role" class="form-select form-select-sm">
                    <option value="user" selected>User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-sm w-100" style="background-color: #058283; border-color: #058283; color: white;">Login</button>
            <p class="mt-2 text-center">Don't have an account? <a href="register.php">Register</a></p>
        </form>
    </div>
</body>
</html>
