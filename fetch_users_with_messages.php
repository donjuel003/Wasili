<?php
header('Content-Type: application/json');

// Database connection
$conn = new mysqli('localhost', 'root', '', 'myshop');

if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

// Fetch users who have sent messages to the admin
$sql = "SELECT DISTINCT u.id, u.name, u.email
        FROM users u
        JOIN messages m ON u.id = m.sender
        WHERE m.receiver = (SELECT id FROM users WHERE role = 'admin')
        ORDER BY u.name ASC";
$result = $conn->query($sql);

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode($users);

$conn->close();
?>