<?php
$conn = new mysqli('localhost', 'root', '', 'myshop');

// Test connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Test direct insertion
$sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES (5, 8, 'Manual test message')";

if ($conn->query($sql) {
    echo "Manual insert successful!<br>";
    
    // Verify the record exists
    $result = $conn->query("SELECT * FROM messages WHERE sender_id = 5 AND receiver_id = 8");
    if ($result->num_rows > 0) {
        echo "Message found in database:<br>";
        print_r($result->fetch_assoc());
    } else {
        echo "Message not found after insertion!";
    }
} else {
    echo "Insert failed: " . $conn->error;
}

$conn->close();
?>