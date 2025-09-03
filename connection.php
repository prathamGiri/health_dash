<?php
$DB_HOST = "10.114.97.179"
$DB_USER = "dashboard_user";
$DB_PASS = "StrongPassword123!";
$DB_NAME = "dashboard_data";

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>