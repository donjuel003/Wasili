<?php
require('fpdf.php');

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myshop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$row = null;
$message = "";

// Handle search by ID
if (isset($_POST['search_id']) && !empty($_POST['search_id'])) {
    $search_id = intval($_POST['search_id']);

    $sql = "SELECT * FROM bookings WHERE id = ? AND status = 'approved'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $search_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        $message = "No shipment found with ID: $search_id";
    }

    $stmt->close();
}

// Handle PDF generation
if (isset($_POST['generate_shipments_pdf']) && isset($_POST['search_id'])) {
    $search_id = intval($_POST['search_id']);

    $sql = "SELECT * FROM bookings WHERE id = ? AND status = 'approved'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $search_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Generate QR code URL
        $qrData = "Shipment ID: " . $row['id'] . "\nStatus: " . $row['shipment_status'];
        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qrData);

        // Download QR code image
        $qrImagePath = 'qr_code_' . $row['id'] . '.png';
        file_put_contents($qrImagePath, file_get_contents($qrUrl));

        // Generate the PDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);

        // Add shipment details to the PDF
        $pdf->Cell(0, 10, 'Shipment Details', 0, 1, 'C');
        $pdf->Ln(10);

        $fields = [
            'Shipment ID' => $row['id'],
            'Sender Name' => $row['name'],
            'Sender Contact' => $row['contact'],
            'Sender Email' => $row['email'],
            'Origin County' => $row['origin_county'],
            'Receiver Name' => $row['receiver_name'],
            'Receiver Phone' => $row['receiver_phone'],
            'Receiver Email' => $row['receiver_email'],
            'Destination County' => $row['destination_county'],
            'Service Type' => $row['service_type'],
            'Service Detail' => $row['service_detail'],
            'Booking Date' => $row['booking_date'],
            'Scheduled Arrival' => $row['scheduled_arrival'],
            'Weight' => $row['weight'] . ' kg',
            'Length' => $row['length'] . ' cm',
            'Width' => $row['width'] . ' cm',
            'Description' => $row['description'],
            'Shipment Status' => $row['shipment_status']
        ];

        foreach ($fields as $key => $value) {
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(50, 10, $key . ':', 0, 0);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(0, 10, $value, 0, 1);
        }

        // Add QR Code to the PDF
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Scan the QR Code for Shipment Details', 0, 1, 'C');
        $pdf->Image($qrImagePath, ($pdf->GetPageWidth() - 50) / 2, $pdf->GetY(), 50, 50);

        // Delete QR code image after use
        unlink($qrImagePath);

        $pdf->Output('D', 'shipment_details.pdf');
        exit;
    } else {
        $message = "Unable to generate PDF. Shipment not found.";
    }

    $stmt->close();
}

$conn->close();
?>
