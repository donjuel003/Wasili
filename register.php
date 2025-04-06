<?php
$conn = new mysqli("localhost", "root", "", "myshop");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = ""; // Initialize error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    // Check if email already exists
    $check_email = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($check_email);

    if ($result->num_rows > 0) {
        $error_message = "Error: Email already exists! Try a different email.";
    } else {
        // Insert new user
        $sql = "INSERT INTO users (name, email, password, phone, role) VALUES ('$name', '$email', '$password', '$phone', '$role')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>
                    document.getElementById('message-box').innerHTML = '<div class=\"alert alert-success\">Registration successful! Redirecting to login...</div>';
                    setTimeout(function(){ window.location.href='login.php'; }, 3000);
                  </script>";
        } else {
            $error_message = "Error: " . $conn->error;
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
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
            background:  rgba(255, 255, 255, 0.2); /* Semi-transparent white */
            border-radius: 8px;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="container shadow">
        <h3 class="text-center">Register</h3>
        
        <!-- Error Message Box -->
        <div id="message-box">
            <?php if (!empty($error_message)) { echo '<div class="alert alert-danger">' . $error_message . '</div>'; } ?>
        </div>
        
        <form method="post">
            <div class="mb-2">
                <label>Name</label>
                <input type="text" name="name" class="form-control form-control-sm" required>
            </div>
            <div class="mb-2">
                <label>Email</label>
                <input type="email" name="email" class="form-control form-control-sm" required>
            </div>
            <div class="mb-2">
                <label>Password</label>
                <input type="password" name="password" class="form-control form-control-sm" required>
            </div>
            <div class="mb-2">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control form-control-sm" required>
            </div>
            <div class="mb-2">
                <label>Role</label>
                <select name="role" class="form-select form-select-sm">
                    <option value="user" selected>User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-sm w-100" style="background-color: #058283; border-color: #058283; color: white;">Register</button>
            <p class="mt-2 text-center">Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
</html>
