<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title> Dashboard </title>
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
                <a href="dashboard.php" class="nav-link active">
                    <span class="material-icons-sharp">
                        dashboard
                    </span>
                    <h3>Dashboard</h3>
                </a>

                <a href="Booking-Widget.php" class="nav-link ">
                    <span class="material-icons-sharp">
                        calendar_month
                    </span>
                    <h3>Booking Widget</h3>
                </a>
                
                <a href="view_bookings.php" class="nav-link">
                    <span class="material-icons-sharp">
                        local_shipping
                        </span>
                    <h3>View Bookings</h3>
                </a>

                <a href="pricer.php" class="nav-link">
                    <span class="material-icons-sharp">
                        credit_card
                        </span>
                    <h3>Pricing Calculator</h3>
                </a><br>
                
                <a href="approved_shipments.php" class="nav-link">
                    <span class="material-icons-sharp">
                        print
                    </span>
                    <h3>Manage Shipments <br> & Print Invoice</h3>
                </a>

                <a href="admin_m.php" class="nav-link">
                    <span class="material-icons-sharp">
                        mail_outline
                    </span>
                    <h3>Messages</h3>
                    <span class="message-count">.</span>
                </a>
                <a href="users.php" class="nav-link">
                    <span class="material-icons-sharp">
                        person_outline
                    </span>
                    <h3>Users</h3>
                </a>

                <a href="reports.php" class="nav-link">
                    <span class="material-icons-sharp">
                        receipt_long
                    </span>
                    <h3>Reports</h3>
                </a>

            

                <a href="users.php" class="nav-link">
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
            <?php
            // Database connection
            $mysqli = new mysqli("localhost", "root", "", "myshop");

            // Check connection
            if ($mysqli->connect_error) {
                die("Connection failed: " . $mysqli->connect_error);
            }

            // Query for total shipments
            $total_query = "SELECT COUNT(*) AS total_shipments FROM bookings";
            $total_result = $mysqli->query($total_query);
            $total_shipments = $total_result->fetch_assoc()['total_shipments'];

            // Query for delivered shipments
            $delivered_query = "SELECT COUNT(*) AS delivered_shipments FROM bookings WHERE shipment_status = 'Delivered'";
            $delivered_result = $mysqli->query($delivered_query);
            $delivered_shipments = $delivered_result->fetch_assoc()['delivered_shipments'];

            $mysqli->close();
            ?>



<div class="analyse">
                <div class="orders">
                    <div class="status">
                        <div class="info">
                            <h3>Total Bookings</h3>
                            <h1><?php echo $total_shipments; ?></h1>
                        </div>
                        <div class="progresss">
                            <svg>
                                <circle cx="38" cy="38" r="36"></circle>
                            </svg>
                            <div class="percentage">
                                <p><?php echo ($total_shipments > 0) ? round(( $total_shipments) * 1) : 0; ?>%</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="deliveries">
                        <div class="status">
                            <div class="info">
                                <h3>Delivered</h3>
                                <h1><?php echo $delivered_shipments; ?></h1>
                            </div>
                            <div class="progresss">
                                <svg>
                                    <circle cx="38" cy="38" r="36"></circle>
                                </svg>
                                <div class="percentage">
                                    <p><?php echo ($total_shipments > 0) ?   round(($delivered_shipments / $total_shipments) * 100) . "%" : "0%"; ?></p>
                                </div>
                            </div>
                        </div>
                </div>
            </div>

            <!-- End of Analyses -->
        
            <!-- Graphs-->
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
                width: 380px;
                height: 380px;
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

        <!-- Right Section -->
        <div class="right-section">
            <div class="nav">
                

                <div class="profile">
                    <div class="info">
                        <p>Dashboard</p>
                     
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
                    <h2>Data</h2>
                    
                </div>
            
                <?php
                    // Connect to the database
                    $servername = "localhost";
                    $username = "root";       // replace with your DB username
                    $password = "";           // replace with your DB password
                    $dbname = "myshop";

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                        // Fetch total number of users
                        $sql = "SELECT COUNT(*) AS total FROM users";
                        $result = $conn->query($sql);

                        $total_users = 0;
                        if ($result && $row = $result->fetch_assoc()) {
                            $total_users = $row['total'];
                        }

                        $conn->close();
                        ?>

                        <!-- Stat 1: Total Customers -->
                        <div class="notification">
                            <div class="icon">
                                <span class="material-icons-sharp">
                                    people
                                </span>
                            </div>
                            <div class="content">
                                <div class="info">
                                    <h3>Total Users</h3>
                                    <small class="text_muted">
                                        <?php echo $total_users; ?>
                                    </small>
                                </div>
                            </div>
                        </div>

                        <?php
                        // Reconnect to the database if needed
                        $conn = new mysqli($servername, $username, $password, $dbname);

                        // Check connection again (optional if you're in the same file)
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Fetch total number of bookings
                        $sql = "SELECT COUNT(*) AS total FROM bookings";
                        $result = $conn->query($sql);

                        $total_bookings = 0;
                        if ($result && $row = $result->fetch_assoc()) {
                            $total_bookings = $row['total'];
                        }

                        $conn->close();
                        ?>

                            <!-- Stat 2: Total Bookings -->
                            <div class="notification">
                                <div class="icon">
                                <span class="material-icons-sharp">calendar_month</span>
                                </div>
                                <div class="content">
                                    <div class="info">
                                        <h3>Total Bookings</h3>
                                        <small class="text_muted">
                                            <?php echo $total_bookings; ?>
                                        </small>
                                    </div>
                                
                                </div>
                            </div>


                            <?php
                                // Reconnect to the database if not already connected
                                $conn = new mysqli($servername, $username, $password, $dbname);

                                // Check connection again
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // Fetch total approved bookings
                                $sql = "SELECT COUNT(*) AS total FROM bookings WHERE status = 'approved'";
                                $result = $conn->query($sql);

                                $total_approved = 0;
                                if ($result && $row = $result->fetch_assoc()) {
                                    $total_approved = $row['total'];
                                }

                                $conn->close();
                                ?>

                                <!-- Stat 3: Total Approved Bookings -->
                                <div class="notification">
                                    <div class="icon">
                                        <span class="material-icons-sharp">
                                            check_box
                                        </span>
                                    </div>
                                    <div class="content">
                                        <div class="info">
                                            <h3>Approved Bookings</h3>
                                            <small class="text_muted">
                                                <?php echo $total_approved; ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>


                                <?php
                                // Reconnect to the database if not already connected
                                $conn = new mysqli($servername, $username, $password, $dbname);

                                // Check connection again
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // Fetch total pending bookings
                                $sql = "SELECT COUNT(*) AS total FROM bookings WHERE status = 'pending'";
                                $result = $conn->query($sql);

                                $total_pending = 0;
                                if ($result && $row = $result->fetch_assoc()) {
                                    $total_pending = $row['total'];
                                }

                                $conn->close();
                                ?>

                                <!-- Stat 4: Total Pending Bookings -->
                                <div class="notification">
                                    <div class="icon">
                                        <span class="material-icons-sharp">
                                        pending_actions
                                        </span>
                                    </div>
                                    <div class="content">
                                        <div class="info">
                                            <h3>Pending Bookings</h3>
                                            <small class="text_muted">
                                                <?php echo $total_pending; ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>







        </div>


    </div>



    <script src="orders.js"></script>
    <script src="index.js"></script>
</body>

</html>