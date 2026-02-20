<?php


include "db.php";


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
