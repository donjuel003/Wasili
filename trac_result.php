<?php
session_start();
require "trac.php"; // Database connection
require "fpdf.php";
require "phpqrcode/qrlib.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];

    // Fetch shipment details
    $stmt = $conn->prepare("SELECT * FROM shipments WHERE shipment_no = ?");
    $stmt->bind_param("s", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $shipment = $result->fetch_assoc();
        $tracking_no = $shipment['tracking_no'];
        $shipment_no = $shipment['shipment_no'];

        // Generate QR Code
        if (!is_dir("qrcodes")) mkdir("qrcodes", 0777, true);
        if (!is_dir("tickets")) mkdir("tickets", 0777, true);

        $qrData = "Tracking No: $tracking_no\nShipment No: $shipment_no";
        $qrFile = "qrcodes/$tracking_no.png";
        QRcode::png($qrData, $qrFile, QR_ECLEVEL_L, 5);

        // Generate PDF Ticket
        class PDF extends FPDF {
            function Header() {
                $this->SetFont('Arial', 'B', 14);
                $this->Cell(190, 10, 'Shipment Ticket', 0, 1, 'C');
                $this->Ln(5);
            }
        }

        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 12);
        foreach ($shipment as $key => $value) {
            $pdf->Cell(50, 10, ucfirst(str_replace("_", " ", $key)) . ": $value", 0, 1);
        }
        $pdf->Image($qrFile, 80, $pdf->GetY(), 50, 50);
        
        // Save and Provide Download Link
        $pdfFile = "tickets/$tracking_no.pdf";
        $pdf->Output("F", $pdfFile);
        
        echo "<p>Shipment found!</p>";
        echo "<a href='$pdfFile' target='_blank'>Download Ticket</a>";
    } else {
        echo "<p style='color: red;'>Invalid Booking ID. No shipment found.</p>";
    }

    $stmt->close();
}
$conn->close();
?>
