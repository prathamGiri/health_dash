<?php
// Database credentials
$servername = ""; 
$username   = "";
$password   = "";
$database   = "";

// Create connection with error reporting
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Database connection failed: (" . mysqli_connect_errno() . ") " . mysqli_connect_error());
}
?>
