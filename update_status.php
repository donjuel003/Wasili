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
    <fom action="" method="POST">
        <label for="shipment_code">Shipment Code:</label>
        <input type="text" id="shipment_code" name="shipment_code" placeholder="Enter Shipment Code" required>
        
        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="ordered">Ordered</option>
            <option value="in transit">In Transit</option>
            <option value="delivered">Delivered</option>
        </select>
        
        <button type="submit">Update Status</button>
    </fom>

    <?php
    // Database connection settings
    $sname = "localhost";
    $uname = "root";
    $password = "";
    $database = "myshop";

    // Create connection
    $conn = mysqli_connect($sname, $uname, $password, $database);

    // Check connection
    if (!$conn) {
        die("<p class='message error'>Connection failed: " . mysqli_connect_error() . "</p>");
    }

    // Process the fom if submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $shipment_code = mysqli_real_escape_string($conn, $_POST['shipment_code']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        // Check if the shipment code exists
        $check_sql = "SELECT * FROM shipments WHERE shipment_code = '$shipment_code'";
        $result = $conn->query($check_sql);

        if ($result->num_rows > 0) {
            // Update the status in the database
            $update_sql = "UPDATE shipments SET status = '$status' WHERE shipment_code = '$shipment_code'";
            if (mysqli_query($conn, $update_sql)) {
                echo "<p class='message success'>Status updated successfully!</p>";
            } else {
                echo "<p class='message error'>Error updating status: " . mysqli_error($conn) . "</p>";
            }
        } else {
            echo "<p class='message error'>Shipment code not found!</p>";
        }
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</body>
</html>
