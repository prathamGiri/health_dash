<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("../connection.php");
header("Content-Type: application/json");

$sql = "SELECT hostname, os_type, date, time, uptime, freeram, totalram, cores
        FROM details
        ORDER BY id DESC
        LIMIT 20";

$result = $conn->query($sql);

if (!$result) {
    die(json_encode(["error" => $conn->error]));
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
$conn->close();
?>
