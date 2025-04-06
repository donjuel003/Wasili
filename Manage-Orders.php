<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Manage Orders</title>
    <style>
        .styled-button, .styled-button1 {
            background-color: #058283;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
        }

        .styled-button:hover, .styled-button1:hover {
            background-color: #046666;
        }

        .styled-button1 span {
            vertical-align: middle;
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
                
                <a href="Manage-Orders.html" class="nav-link active">
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
            <h1>MANAGE LOCAL ORDERS</h1>
            
            <div class="tracker-buttons1">
                <a class="styled-button" href="create.php">New Order</a>
            </div>
            <br><br>


            <table class="table-container1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Origin</th>
                        <th>Destination</th>
                        <th>Description</th>
                        <th>Email@gmail.com</th>
                        <th>ContactInfo</th>
                        <th>Name</th>
                        <th>Shipment No</th>
                        <th>Booking Date</th>
                        <th>Edit</th>
                        
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sname = "localhost";
                $uname = "root";
                $password = "";
                $database = "myshop";

                // Create connection
                $conn = mysqli_connect($sname, $uname, $password, $database);

                // Check connection
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // Read all rows from the database table
                $sql = "SELECT * FROM clients";
                $result = $conn->query($sql);

                if (!$result) {
                    die("Invalid query: " . $conn->error);
                }

                // Display rows
                            while ($row = $result->fetch_assoc()) {
                echo "
                <tr>
                    <td>{$row["id"]}</td>
                    <td>{$row["origin"]}</td>
                    <td>{$row["destination"]}</td>
                    <td>{$row["description"]}</td>
                    <td>{$row["email"]}</td>
                    <td>{$row["phone"]}</td>
                    <td>{$row["name"]}</td>
                    <td>{$row["shipment_code"]}</td>
                    <td>{$row["created_at"]}</td>
                    <td>
                            <div class='tracker-buttons1'>
                                <a  button class='styled-button' href='edit.php?id={$row["id"]}'>Edit</button></a>
                            </div>

                    </td>

                        
                    <td>
                            <div class='tracker-buttons1'>
                                <a button class='styled-button1' href='delete.php?id={$row["id"]}'>
                                    <span class='material-icons-sharp'>
                                        delete
                                    </span>
                                </button></a>
                            </div>

                    </td>
                    </tr>
                    ";
                }
                ?>

                    
                    <tr></tr>
                    
                </tbody>
            </table>

            <br>
           

            
        </main>
        <!-- End of Main Content -->

       



    </div>



    <script src="calculator.js"></script>
</body>

</html>