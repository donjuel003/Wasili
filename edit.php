<?php

$sname = "localhost";
$uname = "root";
$password = "";
$database = "myshop";

// Create connection
$conn = mysqli_connect($sname, $uname, $password, $database);


$id = "";
$origin = "";
$destination = "";
$description = "";
$email = "";
$phone = "";
$name = "";
$shipment_code = "";

$errorMessage = "";
$successMessage = "";

if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
    //GET method: Show the data of the client

    if(!isset ($_GET["id"]) ) {
        header ("location: Manage-Orders.php");
        exit;
    }

    $id = $_GET["id"];

    //Read the row of the selected client from database table
    $sql = "SELECT * FROM clients WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();


    if (!$row){
        header("location: Manage-Orders.php");
        exit;
    }


    
    $origin = $row ["origin"];
    $destination= $row ["destination"];
    $description= $row ["description"];
    $email= $row ["email"];
    $phone= $row ["phone"];
    $name= $row ["name"];
    $shipment_code= $row ["shipment_code"];
}
else{
    //Post method: Update the data of the client

    
    $id = $_POST["id"];
    $origin = $_POST["origin"];
    $destination = $_POST["destination"];
    $description = $_POST["description"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $name = $_POST["name"];
    $shipment_code = $_POST["shipment_code"];

    do{
        if ( empty($id) || empty($origin) || empty($destination) || empty($description) || empty($email) || empty($phone) || empty($name) || empty($shipment_code) ){
            $errorMessage = "All fields are required";
            break;
        }


        $sql = "UPDATE clients ".
        "SET origin = '$origin' , destination = '$destination' , description = '$description' , email = '$email' , phone = '$phone', name = '$name', shipment_code = '$shipment_code'".
        "WHERE id = $id";


        $result = $conn->query($sql);

        if(!$result) {
            $errorMessage = "invalid query: " . $conn->error;
            break;
        }


        $successMessage = "Client updated correctly";

        header("location: Manage-Orders.php");
        exit;

    }while(false);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <style>
        body {
            background-color: #181a1e;
            color: white; /* Text readable against the dark background */
        }

        .container {
            background-color: #20232a; /* Dark gray background for the container */
            border-radius: 8px;
            padding: 20px;
        }

        .form-control {
            background-color: #2c2f33; /* Medium gray for input fields */
            color: #058283; /* Text inside input fields */
            border: 1px solid #4a4d52; /* Slightly lighter gray for borders */
        }

        .form-control:focus {
            background-color: #2c2f33; /* Retain medium gray on focus */
            color: #058283;
            border-color: #058283; /* Highlight border on focus */
            box-shadow: none; /* Remove default blue shadow on focus */
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h2>Edit Order Details</h2>


        <?php
        if( !empty($errorMessage)){
           echo"
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>

        <form method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Origin</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="origin" value="<?php echo $origin; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Destination</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="destination" value="<?php echo $destination; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Description</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="description" value="<?php echo $description; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Email</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Phone</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Name</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Shipment_Code</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="shipment_code" value="<?php echo $shipment_code; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="offset-sm-3 col-sm-3 d-grid">
            <button type="submit" class="btn" style="background-color: #058283; border-color: #058283; color: white;">Submit</button>
        </div>
        <div class="col-sm-3 d-grid">
            <a class="btn" href="Manage-Orders.php" role="button" style="background-color: #058283; border-color: #058283; color: white;">Cancel</a>
        </div>
    </div>
</form>

    </div>
</body>
</html>