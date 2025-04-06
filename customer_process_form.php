<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myshop";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the user is logged in before booking
if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "You must be logged in to make a booking.";
    $_SESSION['message_type'] = "error";
    header("Location: customer_booking.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

// Ensure the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $origin_county = isset($_POST['origin_county']) ? htmlspecialchars($_POST['origin_county']) : null;
    $origin_depot = isset($_POST['origin_depot']) ? htmlspecialchars($_POST['origin_depot']) : null;
    $destination_county = isset($_POST['destination_county']) ? htmlspecialchars($_POST['destination_county']) : null;
    $destination_depot = isset($_POST['destination_depot']) ? htmlspecialchars($_POST['destination_depot']) : null;
    $service_type = isset($_POST['service_type']) ? htmlspecialchars($_POST['service_type']) : null;
    $service_detail = isset($_POST['service_detail']) ? htmlspecialchars($_POST['service_detail']) : null;
    $weight = isset($_POST['weight-input']) ? htmlspecialchars($_POST['weight-input']) : null;
    $width = isset($_POST['width-input']) ? htmlspecialchars($_POST['width-input']) : null;
    $height = isset($_POST['height-input']) ? htmlspecialchars($_POST['height-input']) : null;
    $length = isset($_POST['length-input']) ? htmlspecialchars($_POST['length-input']) : null;
    $name = isset($_POST['name-input']) ? htmlspecialchars($_POST['name-input']) : null;
    $email = isset($_POST['Email-input']) ? filter_var($_POST['Email-input'], FILTER_SANITIZE_EMAIL) : null;
    $contact = isset($_POST['number-input']) ? htmlspecialchars($_POST['number-input']) : null;
    $description = isset($_POST['description-input']) ? htmlspecialchars($_POST['description-input']) : null;

    // Prepare SQL query to insert booking data, including user_id
    $stmt = $conn->prepare("
        INSERT INTO bookings (
            user_id, origin_county, origin_depot, destination_county, destination_depot, 
            service_type, service_detail, weight, width, height, length, 
            name, email, contact, description, status, created_at
        ) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())
    ");

    $stmt->bind_param(
        "issssssdddsssss", 
        $user_id, $origin_county, $origin_depot, $destination_county, $destination_depot, 
        $service_type, $service_detail, $weight, $width, $height, $length, 
        $name, $email, $contact, $description
    );

    // Execute query and handle response
    if ($stmt->execute()) {
        $_SESSION['message'] = "Booking submitted. Awaiting approval.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
        $_SESSION['message_type'] = "error";
    }

    $stmt->close();
}

// Close database connection and redirect
$conn->close();
header("Location: customer_booking.php");
exit();
?>
