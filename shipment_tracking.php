<?php
// Database configuration
$sname = "localhost";
$uname = "root";
$password = "";
$database = "myshop";

$conn = new mysqli($sname, $uname, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['action']) && $data['action'] === 'track') {
        $shipmentCode = $data['shipment_code'];

        $stmt = $conn->prepare("SELECT * FROM shipments WHERE shipment_code = ?");
        $stmt->bind_param("s", $shipmentCode);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $shipment = $result->fetch_assoc();
            echo json_encode(["success" => true, "shipment" => $shipment]);
        } else {
            echo json_encode(["success" => false, "message" => "No shipment found."]);
        }

        $stmt->close();
        exit;
    }

    if (isset($data['action']) && $data['action'] === 'update') {
        $shipmentCode = $data['shipment_code'];
        $status = $data['status'];

        $stmt = $conn->prepare("UPDATE shipments SET status = ? WHERE shipment_code = ?");
        $stmt->bind_param("ss", $status, $shipmentCode);

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            echo json_encode(["success" => true, "message" => "Status updated successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update status."]);
        }

        $stmt->close();
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Shipment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #333;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background: #202528;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 60%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 20px;
            background: #058283;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #046666;
        }

        .status-section {
            text-align: center;
            margin-top: 20px;
        }

        .status-buttons button {
            display: inline-block;
            margin: 10px 5px;
            padding: 10px 20px;
            background: #ccc;
            color: #333;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .status-buttons button.active {
            background: #058283;
            color: #fff;
        }

        .status-message {
            margin-top: 20px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Track Shipment</h1>
        <form id="trackForm">
            <label for="trackingNumber">Enter Tracking Number:</label>
            <input type="text" id="trackingNumber" placeholder="Enter shipment code" required>
            <button type="button" onclick="trackShipment()">Track</button>
        </form>

        <div id="shipmentDetails"></div>

        <div class="status-section">
            <div class="status-buttons">
                <button id="ordered-btn" onclick="updateStatus('ordered')">Ordered</button>
                <button id="transit-btn" onclick="updateStatus('in transit')">In Transit</button>
                <button id="delivered-btn" onclick="updateStatus('delivered')">Delivered</button>
            </div>
            <div id="statusMessage" class="status-message">Status: Not updated</div>
        </div>
    </div>

    <script>
        const shipmentDetails = document.getElementById("shipmentDetails");
        const statusMessage = document.getElementById("statusMessage");
        const buttons = document.querySelectorAll(".status-buttons button");

        function trackShipment() {
            const trackingNumber = document.getElementById("trackingNumber").value;
            if (!trackingNumber) {
                alert("Please enter a tracking number.");
                return;
            }

            fetch("shipment_tracking.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ action: "track", shipment_code: trackingNumber })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    shipmentDetails.innerHTML = `
                        <h3>Shipment Details</h3>
                        <p><strong>Tracking Number:</strong> ${data.shipment.shipment_code}</p>
                        <p><strong>Origin:</strong> ${data.shipment.origin}</p>
                        <p><strong>Destination:</strong> ${data.shipment.destination}</p>
                        <p><strong>Status:</strong> ${data.shipment.status}</p>
                    `;
                } else {
                    shipmentDetails.innerHTML = `<p>${data.message}</p>`;
                }
            })
            .catch(error => console.error("Error tracking shipment:", error));
        }

        function updateStatus(status) {
            const trackingNumber = document.getElementById("trackingNumber").value;
            if (!trackingNumber) {
                alert("Please enter a tracking number before updating the status.");
                return;
            }

            fetch("shipment_tracking.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ action: "update", shipment_code: trackingNumber, status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    statusMessage.textContent = `Status: ${status}`;
                    buttons.forEach(button => button.classList.remove("active"));
                    document.querySelector(`#${status.replace(" ", "-")}-btn`).classList.add("active");
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error("Error updating status:", error));
        }
    </script>
</body>

</html>
