<?php
$DB_HOST = "";
$DB_USER = "";
$DB_PASS = "";
$DB_NAME = "";

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>