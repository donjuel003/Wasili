<?php
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

// Handle status updates and other field updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_shipment'])) {
        $shipment_id = intval($_POST['shipment_id']);

        // Sanitize inputs
        $name = filter_var($_POST['name'] ?? '', FILTER_SANITIZE_STRING);
        $contact = filter_var($_POST['contact'] ?? '', FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_STRING);
        $origin_county = filter_var($_POST['origin_county'] ?? '', FILTER_SANITIZE_STRING);
        $receiver_name = filter_var($_POST['receiver_name'] ?? '', FILTER_SANITIZE_STRING);
        $receiver_phone = filter_var($_POST['receiver_phone'] ?? '', FILTER_SANITIZE_STRING);
        $receiver_email = filter_var($_POST['receiver_email'] ?? '', FILTER_SANITIZE_STRING);
        $destination_county = filter_var($_POST['destination_county'] ?? '', FILTER_SANITIZE_STRING);
        $service_type = filter_var($_POST['service_type'] ?? '', FILTER_SANITIZE_STRING);
        $service_detail = filter_var($_POST['service_detail'] ?? '', FILTER_SANITIZE_STRING);
        $booking_date = filter_var($_POST['booking_date'] ?? '', FILTER_SANITIZE_STRING);
        $scheduled_arrival = filter_var($_POST['scheduled_arrival'] ?? '', FILTER_SANITIZE_STRING);
        $weight = filter_var($_POST['weight'] ?? '', FILTER_SANITIZE_NUMBER_FLOAT);
        $length = filter_var($_POST['length'] ?? '', FILTER_SANITIZE_NUMBER_FLOAT);
        $width = filter_var($_POST['width'] ?? '', FILTER_SANITIZE_NUMBER_FLOAT);
        $description = filter_var($_POST['description'] ?? '', FILTER_SANITIZE_STRING);
        $shipment_status = filter_var($_POST['shipment_status'] ?? '', FILTER_SANITIZE_STRING);

        $sql = "UPDATE bookings SET name=?, contact=?, email=?, origin_county=?, receiver_name=?, receiver_phone=?, receiver_email=?, destination_county=?, service_type=?, service_detail=?, booking_date=?, scheduled_arrival=?, weight=?, length=?, width=?, description=?, shipment_status=? WHERE id=?";

        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sssssssssssssssssi", $name, $contact, $email, $origin_county, $receiver_name, $receiver_phone, $receiver_email, $destination_county, $service_type, $service_detail, $booking_date, $scheduled_arrival, $weight, $length, $width, $description, $shipment_status, $shipment_id);

            if ($stmt->execute()) {
                $message = "Shipment updated successfully.";
            } else {
                $message = "Failed to update shipment: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $message = "Failed to prepare statement: " . $conn->error;
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update Shipment
    if (isset($_POST['update_shipment'])) {
        $shipment_id = intval($_POST['shipment_id']);

        // Sanitize inputs (code omitted for brevity, same as before)

        $sql = "UPDATE bookings SET name=?, contact=?, email=?, origin_county=?, receiver_name=?, receiver_phone=?, 
                receiver_email=?, destination_county=?, service_type=?, service_detail=?, booking_date=?, 
                scheduled_arrival=?, weight=?, length=?, width=?, description=?, shipment_status=? WHERE id=?";

        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sssssssssssssssssi", $name, $contact, $email, $origin_county, $receiver_name, $receiver_phone,
                $receiver_email, $destination_county, $service_type, $service_detail, $booking_date, $scheduled_arrival, 
                $weight, $length, $width, $description, $shipment_status, $shipment_id);

            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Shipment updated successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to update shipment: " . $stmt->error]);
            }

            $stmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to prepare statement: " . $conn->error]);
        }
        exit;
    }

    // Generate PDF
    if (isset($_POST['generate_shipments_pdf'])) {
        require('fpdf.php');
        require_once 'phpqrcode/qrlib.php';
    
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'myshop');
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        $shipment_id = intval($_POST['search_id']);
        $sql = "SELECT * FROM bookings WHERE id = ? AND status = 'approved'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $shipment_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            // Generate QR Code
            $qrData = 'Shipment ID: ' . $row['id'] . '\nReceiver: ' . $row['receiver_name'] . '\nStatus: ' . $row['shipment_status'];
            $qrTempDir = 'temp/';
            if (!file_exists($qrTempDir)) {
                mkdir($qrTempDir);
            }
            $qrFileName = $qrTempDir . 'qr_' . $row['id'] . '.png';
            QRcode::png($qrData, $qrFileName, QR_ECLEVEL_L, 4);
    
            class PDF extends FPDF {
                function Header() {
                    $this->SetFont('Arial', 'B', 16);
                    $this->SetFillColor(5, 130, 131);
                    $this->SetTextColor(255);
                    $this->Cell(0, 15, 'Shipment Details Report', 0, 1, 'C', true);
                    $this->Ln(10);
                }
    
                function Footer() {
                    $this->SetY(-15);
                    $this->SetFont('Arial', 'I', 10);
                    $this->SetTextColor(50, 50, 50);
                    $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
                }
            }
    
            $pdf = new PDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', 12);
    
            $sections = [
                'Sender Information' => [
                    'Sender Name' => $row['name'],
                    'Sender Contact' => $row['contact'],
                    'Sender Email' => $row['email'],
                    'Origin County' => $row['origin_county']
                ],
                'Receiver Information' => [
                    'Receiver Name' => $row['receiver_name'],
                    'Receiver Phone' => $row['receiver_phone'],
                    'Receiver Email' => $row['receiver_email'],
                    'Destination County' => $row['destination_county']
                ],
                'Shipment Details' => [
                    'Service Type' => $row['service_type'],
                    'Service Detail' => $row['service_detail'],
                    'Booking Date' => $row['booking_date'],
                    'Scheduled Arrival' => $row['scheduled_arrival'],
                    'Weight' => $row['weight'] . ' kg',
                    'Length' => $row['length'] . ' cm',
                    'Width' => $row['width'] . ' cm',
                    'Description' => $row['description'],
                    'Shipment Status' => $row['shipment_status']
                ]
            ];
    
            foreach ($sections as $sectionTitle => $fields) {
                $pdf->SetFont('Arial', 'B', 14);
                $pdf->SetFillColor(5, 130, 131);
                $pdf->SetTextColor(255);
                $pdf->Cell(0, 10, $sectionTitle, 0, 1, 'L', true);
                $pdf->Ln(5);
    
                $pdf->SetFont('Arial', '', 12);
                $pdf->SetTextColor(0);
    
                foreach ($fields as $key => $value) {
                    $pdf->SetFont('Arial', 'B', 12);
                    $pdf->SetTextColor(5, 130, 131);
                    $pdf->Cell(50, 10, $key . ':', 0, 0, 'L');
                    $pdf->SetFont('Arial', '', 12);
                    $pdf->SetTextColor(0);
                    $pdf->Cell(0, 10, $value, 0, 1, 'L');
                }
                $pdf->Ln(5);
            }
    
            // Add QR Code to PDF
            $pdf->Image($qrFileName, 150, 10, 40, 40);
    
            $pdf->Output('D', 'shipment_details.pdf');
            unlink($qrFileName);
            exit;
        } else {
            echo json_encode(["status" => "error", "message" => "No shipment found to generate PDF."]);
        }
        $stmt->close();
        $conn->close();
    }
}



// Search by ID
$row = null;
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

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Approved Shipments</title>
    <style>
       input[type="number"], input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #058283; /* Thin border */
            outline: none;
            box-sizing: border-box;
            border-radius: 4px;
            text-align: center;
            font-size: 0.9rem;
            margin-bottom: 10px;
            
        }

        input[type="number"]:focus, input[type="text"]:focus, input[type="email"]:focus, textarea:focus {
            background-color:rgb(47, 53, 56); /* Gray background on focus */
            transition: background-color 0.2s ease; /* Smooth transition */
        }


        button {
            padding: 10px 20px;
            border: none;
            background-color: #058283;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1.7rem;
        }

        button:hover {
            background-color: #058283;
        }

        .shipment-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 2fr));
            gap: 30px;
        }

        .section {
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }
    </style>
</head>
<body>
    <div class="container">
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
                <a href="dashboard.php" class="nav-link">
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
                
                <a href="approved_shipments.php" class="nav-link active ">
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
            <h1>Approved Shipments</h1>

            <?php if (isset($message)) : ?>
                <div class="status-message <?php echo (strpos($message, 'Failed') === 0 ? 'error' : 'success'); ?>">
                    <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>

            <form action="approved_shipments.php" method="POST">
                <label for="shipment_id">Search by ID:</label>
                <input type="number" name="search_id" id="shipment_id" placeholder="Enter Shipment ID">
                <button type="submit">Search</button>
            </form>

            <?php if ($row) : ?>
                <form action="approved_shipments.php" method="POST">
                    <input type="hidden" name="shipment_id" value="<?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>">

                    <div class="shipment-grid">
                        <div class="sender-details section">
                            <h2>Sender Details</h2>
                            <label for="name">Name:</label>
                            <input type="text" name="name" value="<?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Sender's Name">
                            <label for="contact">Phone:</label>
                            <input type="text" name="contact" value="<?php echo htmlspecialchars($row['contact'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Sender's Phone">
                            <label for="email">Email:</label>
                            <input type="text" name="email" value="<?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Sender's Email">
                            <label for="origin_county">Origin:</label>
                            <input type="text" name="origin_county" value="<?php echo htmlspecialchars($row['origin_county'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Origin County">
                        </div>

                        <div class="receiver-details section">
                            <h2>Receiver Details</h2>
                            <label for="receiver_name">Name:</label>
                            <input type="text" name="receiver_name" value="<?php echo htmlspecialchars($row['receiver_name'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Receiver's Name">
                            <label for="receiver_phone">Phone:</label>
                            <input type="text" name="receiver_phone" value="<?php echo htmlspecialchars($row['receiver_phone'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Receiver's Phone">
                            <label for="receiver_email">Email:</label>
                            <input type="text" name="receiver_email" value="<?php echo htmlspecialchars($row['receiver_email'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Receiver's Email">
                            <label for="destination_county">Destination:</label>
                            <input type="text" name="destination_county" value="<?php echo htmlspecialchars($row['destination_county'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Destination County">
                        </div>

                        <div class="shipment-details section">
                            <h2>Shipment Details</h2>
                            <label for="service_type">Service Type:</label>
                            <input type="text" name="service_type" value="<?php echo htmlspecialchars($row['service_type'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Service Type">
                            <label for="service_detail">Service Detail:</label>
                            <input type="text" name="service_detail" value="<?php echo htmlspecialchars($row['service_detail'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Service Detail">
                            <label for="booking_date">Booking Date:</label>
                            <input type="text" name="booking_date" value="<?php echo htmlspecialchars($row['booking_date'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="YYYY-MM-DD">
                            <label for="scheduled_arrival">Scheduled Arrival:</label>
                            <input type="text" name="scheduled_arrival" value="<?php echo htmlspecialchars($row['scheduled_arrival'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="YYYY-MM-DD">
                            <label for="weight">Weight:</label>
                            <input type="text" name="weight" value="<?php echo htmlspecialchars($row['weight'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Weight in kg">
                            <label for="length">Length:</label>
                            <input type="text" name="length" value="<?php echo htmlspecialchars($row['length'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Length in cm">
                            <label for="width">Width:</label>
                            <input type="text" name="width" value="<?php echo htmlspecialchars($row['width'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Width in cm">
                            <label for="description">Description:</label>
                            <input type="text" name="description" value="<?php echo htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Describe the shipment">
                        </div>

                        <div class="shipment-status section">
                            <h2>Shipment Status</h2>
                            <label for="shipment-status">Status:</label>
                            <select name="shipment_status" id="shipment-status">
                                <?php
                                $statuses = ['in transit', 'arrived', 'dispatched for delivery', 'delivered', 'returned', 'hold'];
                                foreach ($statuses as $status) {
                                    $selected = ($row['shipment_status'] == $status) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($status, ENT_QUOTES, 'UTF-8') . "' $selected>" . htmlspecialchars(ucfirst($status), ENT_QUOTES, 'UTF-8') . "</option>";
                                }
                                ?>
                            </select>
                            <br>
                            <br>
                            <br>
                            <button type="submit" name="update_shipment">Update Shipment</button>


                            <br>
                            <br>

                            <?php if ($row) : ?>
                                <form action="approved_shipments.php" method="POST">
                                    <input type="hidden" name="search_id" value="<?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <button type="submit" name="generate_shipments_pdf" style="background-color: #058283; color: white; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
                                        Print Ticket (PDF)
                                    </button>
                                </form>
                            <?php endif; ?>

                        </div>
                    </div>
                </form>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
