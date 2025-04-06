<?php
// db.php - Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Updated password
$dbname = "myshop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch shipment status data
$sql = "SELECT shipment_status, COUNT(*) as count FROM bookings WHERE shipment_status IN ('In transit', 'arrived', 'dispatched for delivery', 'delivered', 'returned', 'hold') GROUP BY shipment_status";
$result = $conn->query($sql);

$shipmentData = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $shipmentData[$row['shipment_status']] = $row['count'];
  }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shipment Status Charts</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    .chartContainer {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-wrap: wrap;
      gap: 20px;
      padding: 20px;
    }
    .chart {
      width: 400px;
      height: 400px;
    }
  </style>
</head>
<body>
  <!-- Graphs -->
  <div class="chartContainer">
    <div class="chart">
      <canvas id="barChart"></canvas>
    </div>
    <div class="chart">
      <canvas id="doughnut"></canvas>
    </div>
  </div>

  <script>
    const shipmentData = <?php echo json_encode($shipmentData); ?>;
    const labels = Object.keys(shipmentData);
    const counts = Object.values(shipmentData);

    // Bar Chart
    const ctxBar = document.getElementById('barChart').getContext('2d');
    new Chart(ctxBar, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: 'Shipment Status Count',
          data: counts,
          backgroundColor: '#044444',
          borderColor: '#058283',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    // Doughnut Chart
    const ctxDoughnut = document.getElementById('doughnut').getContext('2d');
    new Chart(ctxDoughnut, {
      type: 'doughnut',
      data: {
        labels: labels,
        datasets: [{
          label: 'Shipment Status Distribution',
          data: counts,
          backgroundColor: [
            '#044444', '#058283', '#066666', '#089999', '#0AABBB', '#0CCCCD'
          ],
          borderColor: '#058283',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    });
  </script>
</body>
</html>
