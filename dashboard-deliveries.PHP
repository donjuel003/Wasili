<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Responsive Dashboard Design #1 | AsmrProg</title>
</head>


<body class="dark-mode">

    <div class="container">
        <!-- Sidebar Section -->
        <aside>
            <div class="toggle">
                <div class="logo">
                    <img src="images/logo.png">
                    <h2>WASILI<span class="danger"></span></h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">
                        close
                    </span>
                </div>
            </div>

            <div class="sidebar">
                <a href="dashboard.html" class="nav-link active">
                    <span class="material-icons-sharp">
                        dashboard
                    </span>
                    <h3>Dashboard</h3>
                </a>

                <a href="Tracker.html" class="nav-link ">
                    <span class="material-icons-sharp">
                        search
                    </span>
                    <h3>Track Shipments</h3>
                </a>

                <a href="Booking-Widget.html" class="nav-link ">
                    <span class="material-icons-sharp">
                        calendar_month
                    </span>
                    <h3>Booking Widget</h3>
                </a>
                
                <a href="Manage-Orders.html" class="nav-link">
                    <span class="material-icons-sharp">
                        local_shipping
                        </span>
                    <h3>Manage Orders</h3>
                </a>

                <a href="#" class="nav-link">
                    <span class="material-icons-sharp">
                        credit_card
                        </span>
                    <h3>Pricing Calculator</h3>
                </a>
                
                <a href="#" class="nav-link">
                    <span class="material-icons-sharp">
                        print
                    </span>
                    <h3>Print Invoice</h3>
                </a>
                <a href="#" class="nav-link">
                    <span class="material-icons-sharp">
                        insights
                    </span>
                    <h3>Analytics</h3>
                </a>
                <a href="#" class="nav-link">
                    <span class="material-icons-sharp">
                        mail_outline
                    </span>
                    <h3>Messages</h3>
                    <span class="message-count">27</span>
                </a>
                <a href="users.html" class="nav-link">
                    <span class="material-icons-sharp">
                        person_outline
                    </span>
                    <h3>Users</h3>
                </a>

                
                <a href="#" class="nav-link">
                    <span class="material-icons-sharp">
                        settings
                    </span>
                    <h3>Settings</h3>
                </a>
                <a href="#" class="nav-link">
                    <span class="material-icons-sharp">
                        add
                    </span>
                    <h3>New Login</h3>
                </a>
                <a href="logout.php"  class="nav-link">
                    <span class="material-icons-sharp">
                        logout
                    </span>
                    <h3>Logout</h3>
                </a>
            </div>
        </aside>
        <!-- End of Sidebar Section -->

        <main>
            <h1>DASHBOARD</h1>
        
            <!-- Analyses -->
            <div class="analyse">
                <div class="orders">
                   <a href="dashboard-orders.html">
                    <div class="status">
                        <div class="info">
                            <h3>Total Orders</h3>
                            <h1>$65,024</h1>
                        </div>
                        <div class="progresss">
                            <svg>
                                <circle cx="38" cy="38" r="36"></circle>
                            </svg>
                            <div class="percentage">
                                <p>+81%</p>
                            </div>
                        </div>
                    </div>
                   </a>
                    
                </div>
                
                <div class="deliveries">
                    <a href="dashboard-deliveries.html">
                        <div class="status">
                            <div class="info">
                                <h3>Deliveries</h3>
                                <h1>14,147</h1>
                            </div>
                            <div class="progresss">
                                <svg>
                                    <circle cx="38" cy="38" r="36"></circle>
                                </svg>
                                <div class="percentage">
                                    <p>+21%</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- End of Analyses -->


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
        
            <!-- Graphs-->
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
      width: 350px;
      height: 350px;
    }
  </style>
</head>

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
            <!-- End of Graphs -->
        
        </main>
        <!-- End of Main Content -->
        
        <!-- End of Main Content -->

        <!-- Right Section -->
        <div class="right-section">
            <div class="nav">
                <button id="menu-btn">
                    <span class="material-icons-sharp">
                        menu
                    </span>
                </button>
                <div class="dark-mode">
                    <span class="material-icons-sharp ">
                        light_mode
                    </span>
                    <span class="material-icons-sharp active">
                        dark_mode
                    </span>
                </div>

                <div class="profile">
                    <div class="info">
                        <p>Hello, <b>Welcome</b></p>
                        <small class="text-muted">Admin</small>
                    </div>
                    <div class="profile-photo">
                        <img src="images/profile-1.jpg">
                    </div>
                </div>

            </div>

            
            <!-- End of Nav -->

            <div class="user-profile">
                <div class="logo">
                    <img src="images/logo.png">
                    <h2>WASILI</h2>
                    <p>Guaranteed safe and on time delivery</p>
                </div>
            </div>

            <div class="reminders">
                <div class="header">
                    <h2>STATS</h2>
                    <span class="material-icons-sharp">
                        insights
                    </span>
                </div>
            
                <!-- Stat 1: Total Customers -->
                <div class="notification">
                    <div class="icon">
                        <span class="material-icons-sharp">
                            people
                        </span>
                    </div>
                    <div class="content">
                        <div class="info">
                            <h3>Total Customers</h3>
                            <small class="text_muted">
                                1,200
                            </small>
                        </div>
                        <span class="material-icons-sharp">
                            more_vert
                        </span>
                    </div>
                </div>
            

            
                <!-- Stat 3: Active Users -->
                <div class="notification">
                    <div class="icon">
                        <span class="material-icons-sharp">
                            verified_user
                        </span>
                    </div>
                    <div class="content">
                        <div class="info">
                            <h3>Active Users</h3>
                            <small class="text_muted">
                                980
                            </small>
                        </div>
                        <span class="material-icons-sharp">
                            more_vert
                        </span>
                    </div>
                </div>
            
                <!-- Stat 4: Total Revenue -->
                <div class="notification">
                    <div class="icon">
                        <span class="material-icons-sharp">
                            attach_money
                        </span>
                    </div>
                    <div class="content">
                        <div class="info">
                            <h3>Total Revenue</h3>
                            <small class="text_muted">
                                $1.5M
                            </small>
                        </div>
                        <span class="material-icons-sharp">
                            more_vert
                        </span>
                    </div>
                </div>
            
                <!-- Stat 5: Status -->
                <div class="notification">
                    <div class="icon">
                        <span class="material-icons-sharp">
                            toggle_on
                        </span>
                    </div>
                    <div class="content">
                        <div class="info">
                            <h3>Status</h3>
                            <small class="text_muted">
                                Active
                            </small>
                        </div>
                        <span class="material-icons-sharp">
                            more_vert
                        </span>
                    </div>
                </div>
            </div>
            

        </div>


    </div>



    <script src="orders.js"></script>
    <script src="index.js"></script>
</body>

</html>