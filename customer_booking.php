<?php
session_start();
if (isset($_SESSION['message'])) {
    $message = htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8');
    $message_type = $_SESSION['message_type'] === "success" ? "#d4edda" : "#f8d7da"; // Green for success, red for error
    $text_color = $_SESSION['message_type'] === "success" ? "#155724" : "#721c24";

    echo "<div style='padding: 10px; background-color: $message_type; color: $text_color; text-align: center; border-radius: 5px; margin-bottom: 10px;'>
            <strong>$message</strong>
          </div>";

    // Clear the message after displaying
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Customer Booking</title>
    <style>
        body {
            width: 100%;
            height: 100vh;
            background: linear-gradient(to left, rgba(13, 13, 25, 0.5) 50%, rgba(13, 13, 25, 0.5) 50%), url(scania.jpg) center / cover;
            background-repeat: no-repeat;
        }
        main {
        width: 90%;
        max-width: 1200px;
        padding: 2rem;
        background:  transparent; 
        border-radius: 1rem;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    .message-box {
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 10px;
            font-weight: bold;
        }
    </style>
    </style>
    
</head>

<body>
    <!-- Display session message at the top -->
<?php
if (isset($_SESSION['message'])) {
    $message = htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8');
    $message_type = $_SESSION['message_type'] === "success" ? "#d4edda" : "#f8d7da"; // Green for success, red for error
    $text_color = $_SESSION['message_type'] === "success" ? "#155724" : "#721c24";

    echo "<div class='message-box' style='background-color: $message_type; color: $text_color;'>
            $message
          </div>";

    // Clear the message after displaying
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>
    

    <div class="container">


<!-- Main Content -->
<main>



    <form action="customer_process_form.php" method="POST">

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

</div>


    </form>
</main>
<!-- End of Main Content -->


        

    </div>



    <script src="calculator.js"></script>
</body>

</html>