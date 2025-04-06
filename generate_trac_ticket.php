<?php
require "trac.php";
require "fpdf.php";

// Check if booking ID is provided
if (!isset($_GET['booking_id']) || empty($_GET['booking_id'])) {
    die("Invalid request. No Booking ID provided.");
}

$booking_id = $_GET['booking_id'];

// Fetch shipment details from the database
$sql = "SELECT * FROM bookings WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $booking_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $shipment = $result->fetch_assoc();

    // Generate QR code data
    $qrData = "Booking ID: " . $shipment['id'] . "\nStatus: " . strtoupper($shipment['status']);
    $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qrData);

    // Download QR code image
    $qrImagePath = 'qr_' . $shipment['id'] . '.png';
    file_put_contents($qrImagePath, file_get_contents($qrUrl));

    // Create PDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Header Section
    $pdf->SetFont('Arial', 'B', 24);
    $pdf->SetTextColor(5, 130, 131);
    $pdf->Cell(0, 15, 'Shipment Details', 0, 1, 'C');
    $pdf->Ln(5);

    // Introduction Message
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->MultiCell(0, 10, "This document serves as confirmation of your shipment details. Please keep it for reference.", 0, 'C');
    $pdf->Ln(10);

    // Booking ID
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->SetTextColor(5, 130, 131);
    $pdf->Cell(0, 10, 'Booking ID: ' . $shipment['id'], 0, 1, 'L');

    // Shipment Information
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->MultiCell(0, 8, "From: " . $shipment['origin_county'] . " (" . $shipment['origin_depot'] . ")", 0, 'L');
    $pdf->MultiCell(0, 8, "To: " . $shipment['destination_county'] . " (" . $shipment['destination_depot'] . ")", 0, 'L');
    $pdf->MultiCell(0, 8, "Service Type: " . $shipment['service_type'], 0, 'L');
    $pdf->MultiCell(0, 8, "Service Detail: " . $shipment['service_detail'], 0, 'L');
    $pdf->MultiCell(0, 8, "Weight: " . $shipment['weight'] . " kg", 0, 'L');
    $pdf->MultiCell(0, 8, "Dimensions: " . $shipment['width'] . ' x ' . $shipment['height'] . ' x ' . $shipment['length'] . ' cm', 0, 'L');
    $pdf->MultiCell(0, 8, "Status: " . strtoupper($shipment['status']), 0, 'L');
    $pdf->MultiCell(0, 8, "Receiver: " . $shipment['receiver_name'] . " (" . $shipment['email'] . ", " . $shipment['contact'] . ")", 0, 'L');
    $pdf->MultiCell(0, 8, "Description: " . $shipment['description'], 0, 'L');
    $pdf->Ln(10);

    // QR Code Section
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->SetTextColor(5, 130, 131);
    $pdf->Cell(0, 10, 'Scan QR Code for More Details', 0, 1, 'C');
    $pdf->Image($qrImagePath, ($pdf->GetPageWidth() - 50) / 2, $pdf->GetY(), 50, 50);

    // Footer with company email
    $pdf->Ln(60);
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->SetTextColor(100, 100, 100);
    $pdf->MultiCell(0, 10, "Thank you for choosing our service. For support, contact us at jkmartin047@gmail.com", 0, 'C');

    // Delete temporary QR code image
    unlink($qrImagePath);

    // Output PDF
    $pdf->Output('D', 'shipment_details_' . $shipment['id'] . '.pdf');
} else {
    echo "Invalid Booking ID. Shipment not found.";
}

$stmt->close();
$conn->close();
?>
