
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
    width: 150px;
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
            <form method="POST">
                <h1>Track Shipment</h1>
                <label for="trackingNumber">Enter Tracking Number:</label>
                <input type="text" name="trackingNumber" id="trackingNumber" required>
                <button type="submit">Track</button>
            </form>
        
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $trackingNumber = $_POST['trackingNumber'];

                // Database connection parameters
                $sname = "localhost";
                $uname = "root";
                $password = "";
                $database = "myshop";

                // Create connection
                $conn = mysqli_connect($sname, $uname, $password, $database);

                // Check connection
                if (!$conn) {
                    die("<p class='error'>Connection failed: " . mysqli_connect_error() . "</p>");
                }

                // Prepare and execute the query
                $stmt = $conn->prepare("SELECT * FROM clients WHERE shipment_code = ?");
                $stmt->bind_param("s", $trackingNumber);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<div class='result'>
                        <table>
                            <thead>
                                <tr>
                                    <th>Field</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>Tracking Number</td><td>" . htmlspecialchars($row['shipment_code']) . "</td></tr>";
                        echo "<tr><td>Origin</td><td>" . htmlspecialchars($row['origin']) . "</td></tr>";
                        echo "<tr><td>Destination</td><td>" . htmlspecialchars($row['destination']) . "</td></tr>";
                        echo "<tr><td>Description</td><td>" . htmlspecialchars($row['description']) . "</td></tr>";
                        echo "<tr><td>Contact Info</td><td>" . htmlspecialchars($row['phone']) . "</td></tr>";
                        echo "<tr><td>Email</td><td>" . htmlspecialchars($row['email']) . "</td></tr>";
                        echo "<tr><td>Name</td><td>" . htmlspecialchars($row['name']) . "</td></tr>";
                        echo "<tr><td>Booking Date</td><td>" . htmlspecialchars($row['created_at']) . "</td></tr>";
                    }
                    echo "</tbody>
                        </table>
                        <a href='generate_pdf.php?trackingNumber=" . urlencode($trackingNumber) . "' class='print-btn'>
                            <span class='material-icons-sharp'>print</span> Print Ticket
                        </a>
                    </div>";
                } else {
                    echo "<p class='error'>No shipment found with the provided tracking number.</p>";
                }

                // Close connection
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
<div class="status-section">
    <div class="status-wrapper">
        <!-- Buttons on the left side -->
        <div class="status-buttons">
            <button id="ordered-btn" class="status-btn active">Ordered</button>
            <button id="transit-btn" class="status-btn">In Transit</button>
            <button id="delivered-btn" class="status-btn">Delivered</button>
        </div>

        <!-- Progress Line on the right side -->
        <div class="status-line">
            <div class="status-progress"></div>
        </div>
    </div>

    <div id="status-message" class="status-message">
        Status: Your shipment has been ordered.
    </div>
</div>

<style>
    .status-section {
        text-align: center;
        padding: 20px;
        background-color: #202528;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        margin-top: 20px;
    }

    .status-wrapper {
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        max-width: 800px;
        margin: 0 auto 10px;
    }

    .status-buttons {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        height: 300px; /* Set height to match the line */
    }

    .status-btn {
        background-color: transparent;
        color: #ccc;
        border: none;
        padding: 10px 20px;
        border-radius: 20px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 10px;
        height: 100px; /* Match the height of the line */
    }

    .status-btn:hover {
        color: #058283;
        box-shadow: 0 0 8px #058283;
    }

    .status-btn.active {
        color: #058283;
        font-weight: bold;
        box-shadow: 0 0 10px #058283;
    }

    .status-line {
        position: relative;
        width: 4px;
        height: 300px; /* Match the height of the buttons */
        background-color: #ccc;
        margin: 10px auto;
        border-radius: 2px;
        overflow: hidden;
    }

    .status-progress {
        position: absolute;
        width: 100%;
        background-color: #058283;
        height: 0;
        transition: height 0.3s ease;
    }

    .status-message {
        font-size: 16px;
        color: #ccc;
    }
</style>

<script>
    const orderedBtn = document.getElementById("ordered-btn");
    const transitBtn = document.getElementById("transit-btn");
    const deliveredBtn = document.getElementById("delivered-btn");
    const statusMessage = document.getElementById("status-message");
    const statusProgress = document.querySelector(".status-progress");
    const statusButtons = document.querySelectorAll(".status-btn");

    const updateStatus = (btn, message, progress) => {
        // Reset all buttons
        statusButtons.forEach(button => button.classList.remove("active"));
        // Activate the clicked button
        btn.classList.add("active");
        // Update the status message
        statusMessage.textContent = `Status: ${message}`;
        // Update the progress line
        statusProgress.style.height = progress + "%"; // This adjusts the vertical fill
    };

    orderedBtn.addEventListener("click", () => {
        updateStatus(orderedBtn, "Your shipment has been ordered.", 33);
    });

    transitBtn.addEventListener("click", () => {
        updateStatus(transitBtn, "Your shipment is in transit.", 66);
    });

    deliveredBtn.addEventListener("click", () => {
        updateStatus(deliveredBtn, "Your shipment has been delivered.", 100);
    });
</script>




    </div>



    <script src="calculator.js"></script>
</body>

</html>