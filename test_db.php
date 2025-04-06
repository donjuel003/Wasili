<?php
$conn = new mysqli('localhost', 'root', '', 'myshop');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Test insert
$sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES (1, 2, 'Test message')";
if ($conn->query($sql) === TRUE) {
    echo "Test message inserted successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Test select
$sql = "SELECT * FROM messages";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "Messages found: " . $result->num_rows;
} else {
    echo "No messages found";
}

$conn->close();
?>