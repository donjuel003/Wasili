<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require "trac.php"; // Database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Shipment</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery Included -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(to left, rgba(13, 13, 25, 0.5) 50%, rgba(13, 13, 25, 0.5) 50%), 
                        url('scania.jpg') center / cover no-repeat;
            color: white;
        }
        .container {
            max-width: 600px;
            background: rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        }
        h2 {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #058283;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            transition: 0.3s;
        }
        button:hover {
            background-color: #056b6c;
        }
        #trackingResult {
            display: none;
            background: rgba(255, 255, 255, 0.9);
            color: black;
            border-radius: 5px;
            padding: 15px;
            margin-top: 15px;
            text-align: left;
        }
        .error {
            color: red;
        }
        #printTicket {
            display: none;
            margin-top: 10px;
            padding: 10px;
            background-color: #058283;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        #printTicket:hover {
            background-color:rgb(11, 80, 80);
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Track Your Shipment</h2>
        <form id="trackingForm">
            <div class="form-group">
                <input type="text" id="booking_id" name="booking_id" placeholder="Enter Booking ID" required>
            </div>
            <button type="submit">Track</button>
        </form>
        <div id="trackingResult"></div>
        <button id="printTicket">Print Ticket</button>
    </div>

    <script>
        $(document).ready(function () {
            $("#trackingForm").submit(function (event) {
                event.preventDefault();
                var bookingID = $("#booking_id").val().trim();

                if (bookingID === "") {
                    $("#trackingResult").html("<p class='error'>Please enter a Booking ID.</p>").show();
                    return;
                }

                $.ajax({
                    url: "track_result.php",
                    type: "POST",
                    data: { booking_id: bookingID },
                    dataType: "json",
                    beforeSend: function () {
                        $("#trackingResult").html("<p>Searching for shipment...</p>").show();
                    },
                    success: function (response) {
                        if (response.status === "success") {
                            var data = response.data;
                            var html = "<h3>Shipment Details</h3>";
                            html += `<p><strong>Booking ID:</strong> ${data.id}</p>`;
                            html += `<p><strong>From:</strong> ${data.origin_county} (${data.origin_depot})</p>`;
                            html += `<p><strong> To:</strong>${data.destination_county} (${data.destination_depot})</p>`;
                            html += `<p><strong>Service Type:</strong> ${data.service_type}</p>`;
                            html += `<p><strong>Service Detail:</strong> ${data.service_detail}</p>`;
                            html += `<p><strong>Weight:</strong> ${data.weight} kg</p>`;
                            html += `<p><strong>Dimensions:</strong> ${data.width} x ${data.height} x ${data.length} cm</p>`;
                            html += `<p><strong>Status:</strong> <span style='color: green;'>${data.status}</span></p>`;
                            html += `<p><strong>Receiver:</strong> ${data.receiver_name} (${data.email}, ${data.contact})</p>`;
                            html += `<p><strong>Description:</strong> ${data.description}</p>`;
                            
                            $("#trackingResult").html(html).show();
                            $("#printTicket").show().off("click").on("click", function() {
                                window.open("generate_trac_ticket.php?booking_id=" + bookingID, "_blank");
                            });
                        } else {
                            $("#trackingResult").html("<p class='error'>" + response.message + "</p>").show();
                            $("#printTicket").hide();
                        }
                    },
                    error: function () {
                        $("#trackingResult").html("<p class='error'>Error retrieving shipment data. Please try again.</p>").show();
                        $("#printTicket").hide();
                    }
                });
            });
        });
    </script>

</body>
</html>
