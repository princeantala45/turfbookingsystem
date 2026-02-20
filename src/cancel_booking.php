<?php
session_start();
date_default_timezone_set('Asia/Kolkata');



include "db.php";


if (!isset($_POST['booking_id'])) {
    exit("error");
}

$booking_id = intval($_POST['booking_id']);

/* Get booking details */
$stmt = $conn->prepare("SELECT * FROM ticket WHERE booking_id = ?");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    exit("error");
}

$row = $result->fetch_assoc();

/* Already cancelled check */
if (strtolower($row['status']) == 'cancelled') {
    exit("already_cancelled");
}

/* Time check */
$timeSlotParts = explode('-', $row['time_slot']);
$startTime = trim($timeSlotParts[0]);
$bookingDateTime = strtotime($row['date'] . ' ' . $startTime);

if ($bookingDateTime <= strtotime('+1 hour')) {
    exit("time_error");
}

/* 1. Update ticket status */
$updateTicket = $conn->prepare("UPDATE ticket SET status = 'cancelled' WHERE booking_id = ?");
$updateTicket->bind_param("i", $booking_id);
$updateTicket->execute();

/* 2. Free the slot (IMPORTANT PART) */
/* Change this query based on your slot table structure */
$updateSlot = $conn->prepare("
    UPDATE slots 
    SET status = 'available' 
    WHERE turf_name = ? AND date = ? AND time_slot = ?
");
$updateSlot->bind_param(
    "sss",
    $row['turfs'],
    $row['date'],
    $row['time_slot']
);
$updateSlot->execute();

echo "success";
?>
