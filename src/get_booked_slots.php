<?php

$conn = mysqli_connect("localhost", "root", "", "turfbookingsystem", 3307);

$date = $_POST['date'] ?? '';
$turf = $_POST['turf'] ?? '';

$booked = [];

if ($date && $turf) {

    $date = mysqli_real_escape_string($conn, $date);
    $turf = mysqli_real_escape_string($conn, $turf);

    $result = mysqli_query($conn,
        "SELECT time_slot FROM ticket 
         WHERE date='$date' AND turfs='$turf'"
    );

    while ($row = mysqli_fetch_assoc($result)) {
        $booked[] = $row['time_slot'];
    }
}

echo json_encode($booked);
