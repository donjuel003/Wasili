<?php
session_start();
header('Content-Type: application/json');

// Database connection
$conn = new mysqli('localhost', 'root', '', 'myshop');
if ($conn->connect_error) {
    die(json_encode(['error' => "Connection failed: " . $conn->connect_error]));
}

// Get current user ID from session
$current_user_id = $_SESSION['user_id'];

// Get POST data
$receiver_id = isset($_POST['receiver_id']) ? intval($_POST['receiver_id']) : 0;
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Validate inputs
if ($receiver_id <= 0) {
    die(json_encode(['error' => 'Invalid receiver ID']));
}

if (empty($message)) {
    die(json_encode(['error' => 'Message cannot be empty']));
}

// Insert message
$sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('iis', $current_user_id, $receiver_id, $message);

if ($stmt->execute()) {
    // Get the newly created message with sender info
    $new_msg_id = $conn->insert_id;
    $get_msg = $conn->prepare("
        SELECT m.*, u.name as sender_name, u.role as sender_role
        FROM messages m
        JOIN users u ON m.sender_id = u.id
        WHERE m.id = ?
    ");
    $get_msg->bind_param('i', $new_msg_id);
    $get_msg->execute();
    $msg_result = $get_msg->get_result();
    $message_data = $msg_result->fetch_assoc();
    
    echo json_encode([
        'success' => true,
        'message' => [
            'id' => $message_data['id'],
            'sender_id' => $message_data['sender_id'],
            'sender_name' => $message_data['sender_name'],
            'sender_role' => $message_data['sender_role'],
            'message' => $message_data['message'],
            'timestamp' => $message_data['timestamp'],
            'is_current_user' => true
        ]
    ]);
} else {
    echo json_encode(['error' => 'Failed to send message']);
}

$conn->close();
?>