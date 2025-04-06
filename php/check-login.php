<?php  
session_start(); // Start the session to manage user data
include "../db_conn.php"; // Include the database connection file

// Check if all required POST fields are set
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['role'])) {

    // Function to sanitize and validate user input
    function test_input($data) {
        $data = trim($data); // Remove whitespace from the beginning and end
        $data = stripslashes($data); // Remove backslashes
        $data = htmlspecialchars($data); // Convert special characters to HTML entities
        return $data;
    }

    // Sanitize input values
    $username = test_input($_POST['username']);
    $password = test_input($_POST['password']);
    $role = test_input($_POST['role']);

    // Validate that username and password are not empty
    if (empty($username)) {
        header("Location: ../index.php?error=User Name is Required"); // Redirect if username is empty
        exit(); // Stop script execution
    } else if (empty($password)) {
        header("Location: ../index.php?error=Password is Required"); // Redirect if password is empty
        exit(); // Stop script execution
    } else {
        // Hash the password using md5 (not recommended for production systems)
        $password = md5($password); 
        
        // Query to fetch user information
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $sql); // Execute the query

        // Check if a user is found
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result); // Fetch user data as an associative array
            
            // Verify the password and role
            if ($row['password'] === $password && $row['role'] == $role) {
                // Store user data in session variables
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['username'] = $row['username'];

                // Redirect based on the user role
                if ($row['role'] === 'admin') {
                    header("Location: ../dashboard.php"); // Redirect to the admin dashboard
                } elseif ($row['role'] === 'user') {
                    header("Location: ../user-dashboard.php"); // Redirect to the user dashboard
                }
                exit(); // Stop script execution
            } else {
                header("Location: ../index.php?error=Incorrect Username, Password, or Role"); // Redirect with error message
                exit(); // Stop script execution
            }
        } else {
            header("Location: ../index.php?error=Incorrect Username, Password, or Role"); // Redirect if no matching user is found
            exit(); // Stop script execution
        }
    }
} else {
    // Redirect to the index page if the required POST data is not set
    header("Location: ../index.php");
    exit(); // Stop script execution
}
