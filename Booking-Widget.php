


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Booking_Widget</title>
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
                <a href="dashboard.php" class="nav-link ">
                    <span class="material-icons-sharp">
                        dashboard
                    </span>
                    <h3>Dashboard</h3>
                </a>

                <a href="Booking-Widget.php" class="nav-link active">
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
                </a>
                
                <a href="approved_shipments.php" class="nav-link">
                    <span class="material-icons-sharp">
                        print
                    </span>
                    <h3>Manage Shipments<br>& Print Invoice</h3>
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
                <a href="logout.php" class="nav-link">
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


<?php
session_start();
if (isset($_SESSION['message'])) {
    $message = htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8');
    echo "<script>
        window.onload = function() {
            alert('$message');
        };
    </script>";
    // Clear the session message
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>

    <h1>SPECIAL SHIPMENT DETAILS</h1>
    <form action="process_form.php" method="POST">

        <!-- Origin Details -->
        <div class="determine">
            <table class="container-table">
                <tr>
                    <td class="location-cell">
                        <span class="location-text">Origin</span>
                        <span class="material-icons-sharp">place</span>
                    </td>
                    <td class="dropdown-cell">
                        <div class="dropdown-group">
                            <select name="origin_county" id="origin_county">
                                <option value="" disabled selected>Select County</option>
                                <option value="NAIROBI">NAIROBI</option>
                                <option value="MOMBASA">MOMBASA</option>
                                <option value="KISUMU">KISUMU</option>
                                <option value="NAKURU">NAKURU</option>
                                <option value="ELDORET">ELDORET</option>
                                <option value="GARISSA">GARISSA</option>
                                <option value="TURKANA">TURKANA</option>
                                <option value="KAJIADO">KAJIADO</option>
                                
                            </select>
                            <select name="origin_depot" id="origin_depot">
                                <option value="" disabled selected>Select Depot</option>
                                <option value="COUNTY-HQ">COUNTY-HQ</option>
                                <option value="OFC-002">OFC-002</option>
                                <option value="OFC-003">OFC-003</option>
                            </select>
                        </div>
                    </td>
                </tr>
            </table>

            <!-- Destination Details -->
            <table class="container-table">
                <tr>
                    <td class="location-cell">
                        <span class="location-text">Destination</span>
                        <span class="material-icons-sharp">place</span>
                    </td>
                    <td class="dropdown-cell">
                        <div class="dropdown-group">
                            <select name="destination_county" id="destination_county">
                                <option value="" disabled selected>Select County</option>
                                <option value="" disabled selected>Select County</option>
                                <option value="NAIROBI">NAIROBI</option>
                                <option value="MOMBASA">MOMBASA</option>
                                <option value="KISUMU">KISUMU</option>
                                <option value="NAKURU">NAKURU</option>
                                <option value="ELDORET">ELDORET</option>
                                <option value="GARISSA">GARISSA</option>
                                <option value="TURKANA">TURKANA</option>
                                <option value="KAJIADO">KAJIADO</option>
                                
                            </select>
                            <select name="destination_depot" id="destination_depot">
                                <option value="" disabled selected>Select Depot</option>
                                <option value="COUNTY-HQ">COUNTY-HQ</option>
                                <option value="OFC-002">OFC-002</option>
                                <option value="OFC-003">OFC-003</option>
                            </select>
                        </div>
                    </td>
                </tr>
            </table>

            <!-- Service Details -->
            <table class="container-table">
                <tr>
                    <td class="location-cell">
                        <span class="location-text">Service</span>
                        <span class="material-icons-sharp">settings</span>
                    </td>
                    <td class="dropdown-cell">
                        <div class="dropdown-group">
                            <select name="service_type" id="service_type">
                                <option value="" disabled selected>Select Service</option>
                                <option value="1">STANDARD</option>
                                <option value="2">EXPRESS</option>
                                <option value="3">OVERNIGHT</option>
                            </select>
                            <select name="service_detail" id="service_detail">
                                <option value="" disabled selected>Select Type</option>
                                <option value="PARCEL">PARCEL</option>
                                <option value="DOCUMENT">DOCUMENT</option>
                                <option value="FREIGHT">FREIGHT</option>
                                <option value="FRAGILE">FRAGILE</option>
                                <option value="HAZARDOUS">HAZARDOUS</option>
                            </select>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Shipment Dimensions -->
        <div class="determine1">
            <table class="container-table1">
                <tr>
                    <td class="location-cell1"><span class="location-text1">Weight</span></td>
                    <td class="dropdown-cell1"><input type="text" name="weight-input" id="weight-input" placeholder="Enter weight in Kg"></td>
                </tr>
            </table>
            <table class="container-table1">
                <tr>
                    <td class="location-cell1"><span class="location-text1">Width</span></td>
                    <td class="dropdown-cell1"><input type="text" name="width-input" id="width-input" placeholder="Enter width in cm"></td>
                </tr>
            </table>
            <table class="container-table1">
                <tr>
                    <td class="location-cell1"><span class="location-text1">Height</span></td>
                    <td class="dropdown-cell1"><input type="text" name="height-input" id="height-input" placeholder="Enter height in cm"></td>
                </tr>
            </table>
            <table class="container-table1">
                <tr>
                    <td class="location-cell1"><span class="location-text1">Length</span></td>
                    <td class="dropdown-cell1"><input type="text" name="length-input" id="length-input" placeholder="Enter length in cm"></td>
                </tr>
            </table>
        </div>

        <!-- Contact Details -->
        <div class="determine1">
            <table class="container-table1">
                <tr>
                    <td class="location-cell1"><span class="location-text1">Name</span></td>
                    <td class="dropdown-cell1"><input type="text" name="name-input" id="name-input" placeholder="Full Name"></td>
                </tr>
            </table>
            <table class="container-table1">
                <tr>
                    <td class="location-cell1"><span class="location-text1">Email</span></td>
                    <td class="dropdown-cell1"><input type="text" name="Email-input" id="email-input" placeholder="email@gmail.com"></td>
                </tr>
            </table>
            <table class="container-table1">
                <tr>
                    <td class="location-cell1"><span class="location-text1">Contact</span></td>
                    <td class="dropdown-cell1"><input type="text" name="number-input" id="number-input" placeholder="Phone No"></td>
                </tr>
            </table>
            <table class="container-table1">
                <tr>
                    <td class="location-cell1"><span class="location-text1">Description</span></td>
                    <td class="dropdown-cell1"><input type="text" name="description-input" id="description-input" placeholder="Description"></td>
                </tr>
            </table>
        </div>

        <!-- Submit Button -->
        <div class="button-container">
    <button class="styled-button" type="submit">Book Now</button>
    <button class="styled-button" type="reset">Clear</button>
    <button class="styled-button">
        <a href="view_bookings.php" style="text-decoration: none; color: inherit;">View Bookings</a>
    </button>

</div>


    </form>
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
            

                

            </div>

            
            <!-- End of Nav -->

            

        </div>


    </div>



    <script src="calculator.js"></script>
</body>

</html>