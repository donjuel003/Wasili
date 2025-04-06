


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Responsive Dashboard Design #1 | AsmrProg</title>
    <style>


form {
    background: linear-gradient(145deg, #202528, #202528);
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    text-align: center;
    width: 100%;
    max-width: 400px;
    margin: auto;
    margin-top: 10px; /* Adds spacing from the table */
}

form h1 {
    font-size: 24px;
    color: #666;
    margin-bottom: 15px;
    font-weight: bold;
}

form label {
    font-size: 14px;
    color: #666;
    display: block;
    margin-bottom: 10px;
    text-align: left;
}

form input[type="text"] {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 16px;
    color: #058283;
    outline: none;
    transition: all 0.3s ease;
}

form input[type="text"]:focus {
    border-color: #058283;
    box-shadow: 0 0 5px rgba(5, 130, 131, 0.5);
}

form button {
    background-color: #058283;
    color: #fff;
    border: none;
    padding: 12px 20px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
}

form button:hover {
    background-color: #046666;
    transform: translateY(-2px);
}

form button:active {
    transform: translateY(0);
}

@media (max-width: 480px) {
    form {
        padding: 20px;
    }

    form h1 {
        font-size: 20px;
    }

    form input[type="text"] {
        font-size: 14px;
    }

    form button {
        font-size: 14px;
    }
}


.result {
    margin-top: 20px;
    background:  #202528;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.result table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.result table th,
.result table td {
    border: 1px solid  #202528;
    padding: 10px;
    text-align: left;
}

.result table th {
    background-color: #058283;
    color: white;
    font-weight: bold;
    
}

.result table tr:nth-child(even) {
    background-color:  #202528;
}

.result table tr:hover {
    background-color:  #202528;
}

.print-btn {
    background-color: #058283;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    margin-top: 20px; /* Adds spacing from the table */
}

.print-btn:hover {
    background-color: #046666;
}

.print-btn span.material-icons-sharp {
    font-size: 20px;
}


    </style>
</head>

<body>

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
                <a href="dashboard.html" class="nav-link ">
                    <span class="material-icons-sharp">
                        dashboard
                    </span>
                    <h3>Dashboard</h3>
                </a>

                <a href="Tracker.html" class="nav-link active ">
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
                <a href="#" class="nav-link">
                    <span class="material-icons-sharp">
                        logout
                    </span>
                    <h3>Logout</h3>
                </a>
            </div>
        </aside>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
<form method="POST" action="">
    <h1>Track Shipment</h1>
    <label for="trackingNumber">Enter Tracking Number:</label>
    <input type="text" name="trackingNumber" id="trackingNumber" required>
    <button type="submit" name="track_shipment">Track</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['track_shipment'])) {
    $trackingNumber = $_POST['trackingNumber'];
    $sname = "localhost";
    $uname = "root";
    $password = "";
    $database = "myshop";

    $conn = mysqli_connect($sname, $uname, $password, $database);
    if (!$conn) {
        die("<p class='error'>Connection failed: " . mysqli_connect_error() . "</p>");
    }

    $stmt = $conn->prepare("SELECT id, origin, destination, email, phone, name, shipment_code, created_at FROM clients WHERE shipment_code = ?");
    $stmt->bind_param("s", $trackingNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $shipmentDetails = $result->fetch_assoc();

        echo "<div class='result'>
                <table>
                    <thead>
                        <tr>
                            <th>Field</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>";
        foreach ($shipmentDetails as $field => $value) {
            echo "<tr><td>" . ucfirst(str_replace('_', ' ', $field)) . "</td><td>" . htmlspecialchars($value) . "</td></tr>";
        }
        echo "</tbody>
            </table>
        </div>";

        // Print Ticket Button
        echo "<form method='POST' action='generate_pdf.php' target='_blank'>
        <input type='hidden' name='shipmentDetails' value='" . htmlspecialchars(json_encode($shipmentDetails)) . "'>
       <button type='submit' class='print-button'>
            <span class='print-icon'>&#128424;</span> Print Ticket
        </button>
    </form>";
    
    } else {
        echo "<p class='error'>No shipment found with the provided tracking number.</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

</main>



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

            
            <!-- Status Section -->
<!-- Status Section -->
<!DOCTYPE html>
<html lang="en">



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Shipment Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h4 {
            color: #058283;
        }

        fom {
            margin-bottom: 20px;
        }

        label {
            display: inline-block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input, select {
            display: block;
            margin-bottom: 15px;
            padding: 10px;
            width: 100%;
            max-width: 400px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #058283;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #046666;
        }

        .message {
            font-weight: bold;
            color: #333;
            margin-top: 20px;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
<h4>Update Shipment Status</h4>
            <form action="" method="POST">
                <label for="shipment_code">Shipment Code:</label>
                <input type="text" id="shipment_code" name="shipment_code" required>
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="ordered">Ordered</option>
                    <option value="in transit">In Transit</option>
                    <option value="delivered">Delivered</option>
                </select>
                <button type="submit" name="update_status">Update Status</button>
            </form>

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
                $shipment_code = $_POST['shipment_code'];
                $status = $_POST['status'];
                $sname = "localhost";
                $uname = "root";
                $password = "";
                $database = "myshop";

                $conn = mysqli_connect($sname, $uname, $password, $database);
                if (!$conn) {
                    die("<p class='error'>Connection failed: " . mysqli_connect_error() . "</p>");
                }

                $stmt = $conn->prepare("SELECT * FROM shipments WHERE shipment_code = ?");
                $stmt->bind_param("s", $shipment_code);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $update_stmt = $conn->prepare("UPDATE shipments SET status = ? WHERE shipment_code = ?");
                    $update_stmt->bind_param("ss", $status, $shipment_code);
                    if ($update_stmt->execute()) {
                        echo "<p class='success'>Shipment status updated successfully.</p>";
                    } else {
                        echo "<p class='error'>Error updating shipment status.</p>";
                    }
                    $update_stmt->close();
                } else {
                    echo "<p class='error'>Shipment code not found.</p>";
                }

                $stmt->close();
                $conn->close();
            }
            ?>
</body>

</html>




    </div>



    <script src="calculator.js"></script>
    <script>
    function printTicket() {
        const content = document.querySelector('.result').innerHTML;
        const printWindow = window.open('', '_blank', 'width=800,height=600');
        printWindow.document.open();
        printWindow.document.write(`
            <html>
            <head>
                <title>Shipment Ticket</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                    th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
                    th { background-color: #058283; color: white; }
                </style>
            </head>
            <body>
                ${content}
            </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    }
</script>

</body>

</html>