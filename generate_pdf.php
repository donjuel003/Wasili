<?php
require('fpdf.php'); // Ensure the FPDF library is correctly included

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['shipmentDetails'])) {
    $shipmentDetails = json_decode($_POST['shipmentDetails'], true);

    // Generate PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetMargins(15, 15, 15);
    $pdf->SetAutoPageBreak(true, 15);

    // Define colors
    $teal = [5, 130, 131]; // #058283
    $white = [255, 255, 255]; // White

    // Title Section
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->SetTextColor($teal[0], $teal[1], $teal[2]);
    $pdf->Cell(0, 10, 'Shipment Details', 0, 1, 'C'); // Centered title
    $pdf->Ln(5);

    // Decorative Line
    $pdf->SetDrawColor($teal[0], $teal[1], $teal[2]);
    $pdf->SetLineWidth(0.8);
    $pdf->Line(15, 25, 195, 25); // Horizontal line
    $pdf->Ln(10);

    // Details Section
    $pdf->SetFont('Arial', '', 12);
    foreach ($shipmentDetails as $field => $value) {
        // Add field name
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetTextColor($teal[0], $teal[1], $teal[2]);
        $pdf->Cell(60, 10, ucfirst(str_replace('_', ' ', $field)) . ':', 0, 0); // Field name

        // Add field value
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0, 0, 0); // Black text
        $pdf->Cell(0, 10, $value, 0, 1); // Field value
    }

    // Footer Section
    $pdf->Ln(15); // Line break for spacing
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->SetTextColor(128, 128, 128); // Gray text
    $pdf->Cell(0, 10, 'Generated on: ' . date('Y-m-d H:i:s'), 0, 1, 'L'); // Date and time of PDF generation
    $pdf->Cell(0, 10, 'WASILI COURIER SERVICE!', 0, 1, 'C'); // Footer message

    // Output the PDF to the browser
    $pdf->Output('I', 'ShipmentDetails.pdf'); // Inline view in browser
    exit;
} else {
    echo "<p style='color: red; font-family: Arial, sans-serif;'>Invalid request. No shipment details provided.</p>";
}
