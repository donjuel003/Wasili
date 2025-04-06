<?php
require "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addUser'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    if (!empty($name) && !empty($email) && !empty($role)) {
        $stmt = $conn->prepare("INSERT INTO users (name, email, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $role);

        if ($stmt->execute()) {
            echo "User added successfully!";
        } else {
            echo "SQL Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Please fill in all fields!";
    }
}
?>
