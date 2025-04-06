<?php
session_start();
header('Content-Type: application/json');

// Database connection
$conn = new mysqli('localhost', 'root', '', 'myshop');
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => "Database connection failed"]));
}

// Validate session
if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'error' => 'Session expired. Please login again.']));
}

$current_user_id = $_SESSION['user_id'];

// Get the correct partner ID based on which interface is calling
if (isset($_GET['partner_id'])) {
    // Called from admin_m.php (admin viewing conversation with a user)
    $partner_id = intval($_GET['partner_id']);
} elseif (isset($_GET['user2_id'])) {
    // Called from customer_m.php (customer viewing conversation with admin)
    $partner_id = intval($_GET['user2_id']);
} else {
    die(json_encode(['success' => false, 'error' => 'Missing conversation partner ID']));
}

if ($partner_id <= 0) {
    die(json_encode(['success' => false, 'error' => 'Invalid user ID provided']));
}

// Verify the partner user exists
$check_user = $conn->prepare("SELECT id, role FROM users WHERE id = ?");
$check_user->bind_param('i', $partner_id);
if (!$check_user->execute()) {
    die(json_encode(['success' => false, 'error' => 'Failed to verify user']));
}

$user_result = $check_user->get_result();
if ($user_result->num_rows === 0) {
    die(json_encode(['success' => false, 'error' => 'The requested user does not exist']));
}

$partner_data = $user_result->fetch_assoc();
$is_partner_admin = ($partner_data['role'] === 'admin');

// Fetch the conversation
$sql = "SELECT 
            m.id, m.sender_id, m.receiver_id, m.message, m.timestamp,
            u.name as sender_name, u.role as sender_role
        FROM messages m
        JOIN users u ON m.sender_id = u.id
        WHERE (m.sender_id = ? AND m.receiver_id = ?)
           OR (m.sender_id = ? AND m.receiver_id = ?)
        ORDER BY m.timestamp ASC";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die(json_encode(['success' => false, 'error' => 'Database query preparation failed']));
}

$stmt->bind_param('iiii', $current_user_id, $partner_id, $partner_id, $current_user_id);
if (!$stmt->execute()) {
    die(json_encode(['success' => false, 'error' => 'Failed to execute query']));
}

$result = $stmt->get_result();
$messages = [];

while ($row = $result->fetch_assoc()) {
    $messages[] = [
        'id' => $row['id'],
        'sender_id' => $row['sender_id'],
        'sender_name' => $row['sender_name'],
        'sender_role' => $row['sender_role'],
        'message' => $row['message'],
        'timestamp' => $row['timestamp'],
        'is_current_user' => ($row['sender_id'] == $current_user_id),
        'is_admin_message' => ($row['sender_role'] == 'admin')
    ];
}

// Prepare response with additional context
$response = [
    'success' => true,
    'messages' => $messages,
    'meta' => [
        'current_user_id' => $current_user_id,
        'partner_id' => $partner_id,
        'is_partner_admin' => $is_partner_admin,
        'total_messages' => count($messages)
    ]
];

// For debugging (remove in production)
if (isset($_GET['debug'])) {
    $response['debug'] = [
        'query_parameters' => $_GET,
        'server_info' => [
            'php_version' => phpversion(),
            'db_server' => $conn->server_info
        ]
    ];
}

echo json_encode($response);
$conn->close();
?>