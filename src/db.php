<?php
$host = "sql103.infinityfree.com";
$user = "if0_41202575";
$pass = "zhV4nrptyWkc4k";
$db   = "if0_41202575_turfbookingsystem";
$port = 3306;

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>