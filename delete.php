<?php
if ( isset ($_GET["id"]) ){
    $id = $_GET["id"];

    $sname = "localhost";
$uname = "root";
$password = "";
$database = "myshop";

// Create connection
$conn = mysqli_connect($sname, $uname, $password, $database);

$sql = "DELETE FROM clients WHERE id=$id";
$conn->query($sql);
}

header("location: Manage-Orders.php");
exit;
?>