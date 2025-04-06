<?php
session_start();
$conn = new mysqli("localhost", "root", "", "myshop");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Wasili Courier Service</title>
   <link rel="stylesheet" href="waf.css">
</head>

<body>

   <div class="container-fluid">
      <div class="container">
         <h2 class="logo">WASILI</h2>
         <nav>
            <ul>
               <li class="active">Home</li>
               <li><a href="about-Us.html"> About </a></li>
               <li><a href="service.html">Services</a></li>   
               <li><a href="contact.html">Email</a></li>  
               <li><a href="customer_m.php">Chat</a></li>       
               <a href="logout.php">  <button class="btn btn2">Log Out</button> </a>
            </ul>
         </nav>
      </div>

      <div class="content">
         <h3>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h3>
         <h3>LOGISTICS SERVICES</h3>
         <h1>CARGO<br> TRANSPORT</h1>
         <p>Send your parcel today and guarantee yourself safe and on-time delivery</p>


         <a href="trac_shipments.php"> <button class="btn">Track Shipments</button> </a>

         <a href="customer_booking.php"><button class="btn btn2">Book Shipment </button> </a>

         
         
      </div>
   </div>  

   <footer>
      <div class="row">
         <div class="col">
            <img src="images\images\service-icon-1.png" class="logo">
            <p>Send your parcel today and guarantee yourself safe and on-time delivery. Join us and be part of the Wasili community for the best experience.</p>
         </div>
         <div class="col">
            <h3>Office <div class="underline"><span></span></div></h3>
            <p>Moi Avenue</p>
            <p>CBD, Nairobi</p>
            <p>0420-00100, Kenya</p>
            <p class="email-id">kjewell003@gmail.com</p>
            <h4>+254(0) 791-979-364</h4>
         </div>
         <div class="col">
            <h3>Links <div class="underline"><span></span></div></h3>
            <ul>
               <li><a href="">Home</a></li>
               <li><a href="about-Us.html">About</a></li>
               <li><a href="service.html">Service</a></li>
               <li><a href="contact.html">Contact Us</a></li>
            </ul>
         </div>
         <div class="col">
            <h3>Newsletter <div class="underline"><span></span></div></h3>
            <form>
               <i class="far fa-envelope"></i>
               <input type="email" placeholder="Enter your email" required>
               <button type="submit"><i class="fas fa-arrow-right"></i></button>
            </form>
         </div>
         <div class="social-icons">
            <i class="fab fa-facebook-f"></i>
            <i class="fab fa-twitter"></i>
            <i class="fab fa-whatsapp"></i>
         </div>
      </div>
      <hr>
      <p class="copyright">Wasili Courier Service Ltd. @ - All Rights Reserved</p>
   </footer>

</body>
</html>
