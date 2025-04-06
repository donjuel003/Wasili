<?php
session_start();
require "trac.php"; // Database connection

header('Content-Type: application/json'); // Return JSON data

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized access. Please log in."]);
    exit();
}

$user_id = $_SESSION['user_id']; // Get logged-in user's ID

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];

    if (!$conn) {
        echo json_encode(["status" => "error", "message" => "Database connection failed."]);
        exit();
    }

    // Query to check if the booking belongs to the logged-in user
    $sql = "SELECT * FROM bookings WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "SQL Error: " . $conn->error]);
        exit();
    }

    $stmt->bind_param("ii", $booking_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $shipment = $result->fetch_assoc();

        echo json_encode([
            "status" => "success",
            "data" => $shipment
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Booking not found."]);
    }

    $stmt->close();
}
$conn->close();
?>
