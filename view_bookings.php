<?php
// Start session
session_start();

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

// Handle delete request
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    if (!$conn->query("DELETE FROM bookings WHERE id = $id")) {
        die("Error deleting booking: " . $conn->error);
    }
}

// Handle approve request
if (isset($_POST['approve'])) {
    $id = $_POST['id'];
    if (!$conn->query("UPDATE bookings SET status = 'approved' WHERE id = $id")) {
        die("Error approving booking: " . $conn->error);
    }
}

// Fetch pending bookings
$pendingBookings = $conn->query("SELECT * FROM bookings WHERE status = 'pending'");
if (!$pendingBookings) {
    die("Error fetching pending bookings: " . $conn->error);
}

// Fetch approved bookings
$approvedBookings = $conn->query("SELECT * FROM bookings WHERE status = 'approved'");
if (!$approvedBookings) {
    die("Error fetching approved bookings: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Bookings</title>
    <style>
        body {
            background-color: #202528;
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #058283;
            padding: 8px;
            text-align: left;
            color: #7d8da1;
        }
        tr:nth-child(even) {
            background-color: #282e33;
        }
        tr:hover {
            background-color: #343a40;
        }
        th {
            background-color: #058283;
            color: #fff;
            padding: 12px 8px;
        }
        h1 {
            color: #fff;
            margin-top: 40px;
        }
        button {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }
        .approve-btn {
            background-color: #28a745;
            color: white;
            border-radius: 4px;
        }
        .delete-btn {
            background-color: #dc3545;
            color: white;
            border-radius: 4px;
        }
        button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <h1>Pending Bookings</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Origin County</th>
            <th>Origin Depot</th>
            <th>Destination County</th>
            <th>Destination Depot</th>
            <th>Service Type</th>
            <th>Service Detail</th>
            <th>Weight</th>
            <th>Width</th>
            <th>Height</th>
            <th>Length</th>
            <th>Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Description</th>
            <th>Booking Date</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $pendingBookings->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['origin_county']) ?></td>
            <td><?= htmlspecialchars($row['origin_depot']) ?></td>
            <td><?= htmlspecialchars($row['destination_county']) ?></td>
            <td><?= htmlspecialchars($row['destination_depot']) ?></td>
            <td><?= htmlspecialchars($row['service_type']) ?></td>
            <td><?= htmlspecialchars($row['service_detail']) ?></td>
            <td><?= htmlspecialchars($row['weight']) ?></td>
            <td><?= htmlspecialchars($row['width']) ?></td>
            <td><?= htmlspecialchars($row['height']) ?></td>
            <td><?= htmlspecialchars($row['length']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['contact']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><?= htmlspecialchars($row['booking_date']) ?></td>
            <td>
                <form method="post" style="display:inline-block;">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                    <button type="submit" name="approve" class="approve-btn">Approve</button>
                    <br>
                </form>
                <form method="post" style="display:inline-block;">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                    <button type="submit" name="delete" class="delete-btn">Delete</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h1>Approved Bookings</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Origin County</th>
            <th>Origin Depot</th>
            <th>Destination County</th>
            <th>Destination Depot</th>
            <th>Service Type</th>
            <th>Service Detail</th>
            <th>Weight</th>
            <th>Width</th>
            <th>Height</th>
            <th>Length</th>
            <th>Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Description</th>
            <th>Booking Date</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $approvedBookings->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['origin_county']) ?></td>
            <td><?= htmlspecialchars($row['origin_depot']) ?></td>
            <td><?= htmlspecialchars($row['destination_county']) ?></td>
            <td><?= htmlspecialchars($row['destination_depot']) ?></td>
            <td><?= htmlspecialchars($row['service_type']) ?></td>
            <td><?= htmlspecialchars($row['service_detail']) ?></td>
            <td><?= htmlspecialchars($row['weight']) ?></td>
            <td><?= htmlspecialchars($row['width']) ?></td>
            <td><?= htmlspecialchars($row['height']) ?></td>
            <td><?= htmlspecialchars($row['length']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['contact']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><?= htmlspecialchars($row['booking_date']) ?></td>
            <td>
                <form method="post" style="display:inline-block;">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                    <br>
                    <button type="submit" name="delete" class="delete-btn">Delete</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
