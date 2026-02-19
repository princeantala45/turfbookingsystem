<?php


$host = $_ENV['DB_HOST'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$db   = $_ENV['DB_NAME'];
$port = $_ENV['DB_PORT'];

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$date = $_POST['date'] ?? '';
$turf = $_POST['turf'] ?? '';

$stmt = $conn->prepare("
    SELECT time_slot 
    FROM ticket 
    WHERE date = ? 
    AND turfs = ? 
    AND status = 'Booked'
");

$stmt->bind_param("ss", $date, $turf);
$stmt->execute();
$result = $stmt->get_result();

$booked = [];

while ($row = $result->fetch_assoc()) {
    $booked[] = trim($row['time_slot']);
}

echo json_encode($booked);
?>
