<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "turfbookingsystem", 3307);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Check login
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}

$username = $_SESSION['username'];

// Get user_id securely
$stmtUser = $conn->prepare("SELECT user_id FROM signup WHERE username = ?");
$stmtUser->bind_param("s", $username);
$stmtUser->execute();
$userResult = $stmtUser->get_result();

if ($userResult->num_rows == 0) {
  die("User not found.");
}

$user = $userResult->fetch_assoc();
$user_id = $user['user_id'];

// Get booking history
$stmt = $conn->prepare("SELECT * FROM ticket WHERE user_id = ? ORDER BY date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>BOOKING HISTORY | TURFBOOKING SYSTEM</title>
  <link href="./output.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="turf.css">
</head>

<body>

<?php include "header.php"; ?>

<section>
  <div class="flex text-sm text-gray-600 px-6 pt-4">
    <p>Home /</p>
    <p class="ml-1 font-medium text-blue-600">Booking History</p>
  </div>
</section>

<div class="max-w-6xl mx-auto p-6">
  <h1 class="text-3xl font-bold text-blue-600 text-center mb-8">
    My Booking History
  </h1>

  <?php if ($result->num_rows > 0): ?>
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">

      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="p-5 bg-white rounded-xl shadow-lg border-l-4 border-blue-600">

          <h3 class="text-xl font-semibold text-blue-800 mb-2">
            <?php echo htmlspecialchars(ucfirst($row['turfs'])); ?>
          </h3>

          <p><strong>Status:</strong>
            <span class="text-green-600 font-semibold">
              <?php echo htmlspecialchars(ucfirst($row['status'])); ?>
            </span>
          </p>

          <p><strong>Date:</strong>
            <?php echo htmlspecialchars($row['date']); ?>
          </p>

          <p><strong>Time:</strong>
            <?php echo date("d M Y h:i A", strtotime($row['booking_time'])); ?>
          </p>

          <hr class="my-2">

          <p><strong>Name:</strong>
            <?php echo htmlspecialchars($row['fullname']); ?>
          </p>

          <p><strong>Mobile:</strong>
            <?php echo htmlspecialchars($row['mobile']); ?>
          </p>

          <p><strong>Address:</strong>
            <?php
              echo htmlspecialchars($row['address']) . ", " .
                   htmlspecialchars($row['city']) . ", " .
                   htmlspecialchars($row['state']) . " - " .
                   htmlspecialchars($row['pincode']);
            ?>
          </p>

          <p><strong>Payment:</strong>
            <?php echo strtoupper(htmlspecialchars($row['payment_method'])); ?>
          </p>

          <p class="mt-2">
            <span class="text-green-700 font-semibold">Reference:</span>
            <span class="font-bold text-green-600 bg-green-100 px-2 py-1 rounded">
              <?php echo htmlspecialchars($row['payment_reference']); ?>
            </span>
          </p>

          <!-- View Ticket Button -->
          <div class="mt-4">
            <a href="view_ticket.php?booking_id=<?php echo $row['booking_id']; ?>"
               class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
              View Ticket
            </a>
          </div>

        </div>
      <?php endwhile; ?>

    </div>
  <?php else: ?>
    <p class="text-center text-gray-500 mt-10">No bookings found.</p>
  <?php endif; ?>

</div>

<?php include "footer.php"; ?>

</body>
</html>
