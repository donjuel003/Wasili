<?php
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body{
    width: 100vw;
    height: fit-content;
    font-family: 'Poppins', sans-serif;
    font-size: 0.88rem;
    user-select: none;
    overflow-x: hidden;
    color: #edeffd;
    background-color: #181a1e;
    }
    .table-bordered {
    color: #edeffd;
    background-color: #181a1e;
    border: 1px solid #edeffd;
}

.table-bordered th, 
.table-bordered td {
    border: 1px solid #202528;
    padding: 10px;
}

.table-bordered thead {
    background-color: #25272c;
    color: #edeffd;
}
.btn-primary {
    background-color: #058283 !important;
    border-color: #046b69 !important;
    color: #ffffff !important;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-primary:hover {
    background-color: #046b69 !important;
    transform: scale(1.05);
}

.btn-primary:active {
    background-color: #034f4d !important;
    transform: scale(0.98);
}



    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Bookings Report</h2>
    <button class="btn btn-primary mb-3" onclick="window.location.href='generate_report_pdf.php'">Download PDF</button>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Origin</th>
                <th>Destination</th>
                <th>Service</th>
                <th>Weight</th>
                <th>Receiver</th>
                <th>Status</th>
                <th>Booking Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['origin_county'] . ' - ' . $row['origin_depot'] ?></td>
                <td><?= $row['destination_county'] . ' - ' . $row['destination_depot'] ?></td>
                <td><?= $row['service_type'] ?></td>
                <td><?= $row['weight'] ?> kg</td>
                <td><?= $row['receiver_name'] ?> (<?= $row['receiver_phone'] ?>)</td>
                <td><?= ucfirst($row['shipment_status']) ?></td>
                <td><?= $row['booking_date'] ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
