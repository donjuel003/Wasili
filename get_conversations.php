<?php
session_start();
header('Content-Type: application/json');

// Database connection
$conn = new mysqli('localhost', 'root', '', 'myshop');
if ($conn->connect_error) {
    die(json_encode(['error' => "Connection failed: " . $conn->connect_error]));
}

$current_user_id = $_SESSION['user_id'];

// Get all unique conversation partners with last message
$sql = "SELECT 
            u.id as partner_id,
            u.name as partner_name,
            u.role as partner_role,
            MAX(m.timestamp) as last_message_time,
            (SELECT message FROM messages 
             WHERE ((sender_id = ? AND receiver_id = u.id) OR 
                   (sender_id = u.id AND receiver_id = ?))
             ORDER BY timestamp DESC LIMIT 1) as last_message
        FROM users u
        JOIN messages m ON (m.sender_id = u.id OR m.receiver_id = u.id)
        WHERE (m.sender_id = ? OR m.receiver_id = ?) AND u.id != ?
        GROUP BY u.id, u.name, u.role
        ORDER BY last_message_time DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param('iiiii', $current_user_id, $current_user_id, 
                         $current_user_id, $current_user_id, $current_user_id);
$stmt->execute();
$result = $stmt->get_result();

$conversations = [];
while ($row = $result->fetch_assoc()) {
    $conversations[] = [
        'partner_id' => $row['partner_id'],
        'partner_name' => $row['partner_name'],
        'partner_role' => $row['partner_role'],
        'last_message' => $row['last_message'],
        'last_message_time' => $row['last_message_time']
    ];
}

echo json_encode(['success' => true, 'conversations' => $conversations]);
$conn->close();
?>