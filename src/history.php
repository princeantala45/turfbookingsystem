<?php
session_start();
date_default_timezone_set('Asia/Kolkata');



include "db.php";



if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}

$username = $_SESSION['username'];

/* Get user ID */
$stmtUser = $conn->prepare("SELECT user_id FROM signup WHERE username = ?");
$stmtUser->bind_param("s", $username);
$stmtUser->execute();
$userResult = $stmtUser->get_result();

if ($userResult->num_rows == 0) {
  die("User not found.");
}

$user = $userResult->fetch_assoc();
$user_id = $user['user_id'];

/* Get booking history */
$stmt = $conn->prepare("SELECT * FROM ticket WHERE user_id = ? ORDER BY date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Booking History | Turf Booking System</title>

<link href="./output.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="turf.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link rel="shortcut icon" href="./gallery/favicon.png" type="image/x-icon">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100">

<?php include "header.php"; ?>

<section>
        <div class="line-turf">
            <p>Home /</p>
            <p style="margin-left: 5px;"> Booking History</p>
        </div>
     </section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

<h1 class="text-2xl sm:text-3xl font-bold text-green-600 text-center mb-8">
  My Booking History
</h1>

<?php if ($result->num_rows > 0): ?>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

<?php while ($row = $result->fetch_assoc()): 

$timeSlotParts = explode('-', $row['time_slot']);
$startTime = trim($timeSlotParts[0]);
$bookingDateTime = strtotime($row['date'] . ' ' . $startTime);
$canCancel = ($bookingDateTime > strtotime('+1 hour')) && strtolower($row['status']) != 'cancelled';

?>

<div class="p-5 sm:p-6 bg-white rounded-xl shadow-lg border-l-4 border-green-600 flex flex-col justify-between">

<div>
<h3 class="text-lg sm:text-xl font-semibold text-green-800 mb-3 break-words">
  <?php echo htmlspecialchars(ucfirst($row['turfs'])); ?>
</h3>

<p class="text-sm sm:text-base"><strong>Status:</strong>
<span class="<?php echo strtolower($row['status']) == 'cancelled' ? 'text-red-600' : 'text-green-600'; ?> font-semibold">
  <?php echo htmlspecialchars(ucfirst($row['status'])); ?>
</span>
</p>

<p class="text-sm sm:text-base mt-1"><strong>Date:</strong> <?php echo htmlspecialchars($row['date']); ?></p>
<p class="text-sm sm:text-base"><strong>Time Slot:</strong> <?php echo htmlspecialchars($row['time_slot']); ?></p>

<p class="text-sm sm:text-base"><strong>Booking Time:</strong>
  <?php echo date("d M Y h:i A", strtotime($row['booking_time'])); ?>
</p>

<hr class="my-3">

<p class="text-sm sm:text-base"><strong>Name:</strong> <?php echo htmlspecialchars($row['fullname']); ?></p>
<p class="text-sm sm:text-base"><strong>Mobile:</strong> <?php echo htmlspecialchars($row['mobile']); ?></p>

<p class="text-sm sm:text-base"><strong>Payment:</strong>
  <?php echo strtoupper(htmlspecialchars($row['payment_method'])); ?>
</p>

<p class="mt-2 text-sm sm:text-base break-all">
  <span class="text-green-700 font-semibold">Reference:</span>
  <span class="font-bold text-green-600 bg-green-100 px-3 py-1 rounded text-xs sm:text-sm">
    <?php echo htmlspecialchars($row['payment_reference']); ?>
  </span>
</p>
</div>

<!-- Buttons -->
<div class="mt-6 flex flex-col sm:flex-row gap-3">

  <!-- View Invoice -->
  <a href="view_ticket.php?booking_id=<?php echo $row['booking_id']; ?>"
     class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-xl shadow-md transition duration-200 text-sm sm:text-base w-full sm:w-auto">
     <i class="fa-solid fa-download"></i>
     View Invoice
  </a>

  <?php if ($canCancel): ?>
    <button onclick="confirmCancel(<?php echo $row['booking_id']; ?>)"
      class="flex items-center justify-center gap-2 bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded-xl shadow-md transition duration-200 text-sm sm:text-base w-full sm:w-auto">
      <i class="fa-solid fa-xmark"></i>
      Cancel Order
    </button>

  <?php elseif (strtolower($row['status']) == 'cancelled'): ?>
    <span class="text-red-600 font-semibold text-center py-2 text-sm sm:text-base">
      Already Cancelled
    </span>

  <?php else: ?>
    <span class="text-gray-400 font-semibold text-center py-2 text-sm sm:text-base">
      Cannot Cancel (Less than 1 hour left)
    </span>
  <?php endif; ?>

</div>

</div>

<?php endwhile; ?>
</div>

<?php else: ?>
<p class="text-center text-gray-500 mt-10 text-sm sm:text-base">
  No bookings found.
</p>
<?php endif; ?>

</div>

<?php include "footer.php"; ?>

<script>
function confirmCancel(bookingId) {
  Swal.fire({
    title: "Are you sure?",
    text: "You want to cancel this booking?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#dc2626",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Yes, cancel it!"
  }).then((result) => {

    if (result.isConfirmed) {

      fetch("cancel_booking.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "booking_id=" + bookingId
      })
      .then(response => response.text())
      .then(data => {

        if (data.trim() === "success") {

          Swal.fire({
            icon: "success",
            title: "Cancelled Successfully!",
            text: "Your booking has been cancelled.",
            confirmButtonColor: "#16a34a"
          }).then(() => {
            location.reload();
          });

        } else if (data.trim() === "time_error") {

          Swal.fire("Cannot Cancel",
                    "Less than 1 hour left for booking.",
                    "error");

        } else if (data.trim() === "already_cancelled") {

          Swal.fire("Info",
                    "Booking already cancelled.",
                    "info");

        } else {

          Swal.fire("Error",
                    "Something went wrong.",
                    "error");

        }

      });

    }

  });
}
</script>
  <script src="main.js"></script>
  <script src="all-animation.js"></script>




</body>
</html>
