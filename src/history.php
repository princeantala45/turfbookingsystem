<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "turfbookingsystem");

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Check if user is logged in
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}

$username = $_SESSION['username'];

// Get user_id from username
$user_query = "SELECT user_id FROM signup WHERE username = '$username'";
$user_result = mysqli_query($conn, $user_query);

if ($user_result && mysqli_num_rows($user_result) > 0) {
  $user = mysqli_fetch_assoc($user_result);
  $user_id = $user['user_id'];
} else {
  die("User not found.");
}

// Get ticket history
$result = mysqli_query($conn, "SELECT * FROM ticket WHERE user_id = $user_id ORDER BY date DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>BOOKING HISTORY | TURFBOOKING SYSTEM</title>
  <link href="./output.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="shortcut icon" href="./gallery/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="turf.css">
  <style>
    @keyframes slideUp {
      0% {
        opacity: 0;
        transform: translateY(20px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-slideUp {
      animation: slideUp 0.5s ease-out forwards;
    }
  </style>
</head>

<body>

  <?php include "header.php"; ?>

  <section>
    <div class="line-turf flex text-sm text-gray-600 px-6 pt-4">
      <p>Home /</p>
      <p class="ml-1 font-medium text-blue-600">Booking History</p>
    </div>
  </section>

  <div class="max-w-6xl mx-auto p-6">
    <h1 class="text-3xl font-bold text-blue-600 text-center mb-8">📜 My Booking History</h1>

    <?php if (mysqli_num_rows($result) > 0): ?>
      <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <div class="p-5 bg-white rounded-xl shadow-lg border-l-4 border-blue-600 animate-slideUp">
            <h3 class="text-xl font-semibold text-blue-800 mb-2"><?= htmlspecialchars(ucfirst($row['turfs'])) ?></h3>
            <p><b>Date:</b> <?= htmlspecialchars($row['date']) ?></p>
            <p><b>Name:</b> <?= htmlspecialchars($row['fullname']) ?></p>
            <p><b>Mobile:</b> <?= htmlspecialchars($row['mobile']) ?></p>
            <p><b>Address:</b> <?= htmlspecialchars($row['address']) ?>, <?= htmlspecialchars($row['city']) ?>, <?= htmlspecialchars($row['state']) ?> - <?= htmlspecialchars($row['pincode']) ?></p>
            <p><b>Payment:</b> <?= strtoupper(htmlspecialchars($row['payment_method'])) ?></p>
            <p class="mt-2">
              <span class="text-green-700 font-semibold">Reference:</span>
              <span class="font-bold text-green-600 bg-green-100 px-2 py-1 rounded">
  <?= htmlspecialchars($row['payment_reference']) ?>
</span>

            </p>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <p class="text-center text-gray-500 mt-10">No bookings found.</p>
    <?php endif; ?>
  </div>

  <?php include "footer.php"; ?>
  <script src="main.js"></script>
</body>

</html>