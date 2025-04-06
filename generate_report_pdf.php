<?php
require('fpdf.php');

$servername = "localhost";
$username = "root"; // Change if necessary
$password = ""; // Change if necessary
$database = "myshop";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch bookings
$sql = "SELECT * FROM bookings ORDER BY created_at DESC";
$result = $conn->query($sql);

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(190, 10, 'Bookings Report', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(10, 10, 'ID', 1);
$pdf->Cell(40, 10, 'Origin', 1);
$pdf->Cell(40, 10, 'Destination', 1);
$pdf->Cell(25, 10, 'Service', 1);
$pdf->Cell(20, 10, 'Weight', 1);
$pdf->Cell(30, 10, 'Receiver', 1);
$pdf->Cell(25, 10, 'Status', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 9);
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(10, 8, $row['id'], 1);
    $pdf->Cell(40, 8, $row['origin_county'] . '-' . $row['origin_depot'], 1);
    $pdf->Cell(40, 8, $row['destination_county'] . '-' . $row['destination_depot'], 1);
    $pdf->Cell(25, 8, $row['service_type'], 1);
    $pdf->Cell(20, 8, $row['weight'] . ' kg', 1);
    $pdf->Cell(30, 8, $row['receiver_name'], 1);
    $pdf->Cell(25, 8, ucfirst($row['shipment_status']), 1);
    $pdf->Ln();
}

$pdf->Output();
$conn->close();
?>
