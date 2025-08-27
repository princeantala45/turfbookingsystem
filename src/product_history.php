<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "turfbookingsystem");

if (!$conn) die("Connection failed: ".mysqli_connect_error());

// Check login
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Get user_id
$user_query = "SELECT user_id FROM signup WHERE username='$username'";
$user_result = mysqli_query($conn, $user_query);
if($user_result && mysqli_num_rows($user_result) > 0){
    $user = mysqli_fetch_assoc($user_result);
    $user_id = $user['user_id'];
}else{
    die("User not found.");
}

// Fetch product orders for this user
$result = mysqli_query($conn, "SELECT * FROM product_shopping WHERE user_id=$user_id ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>MY ORDERS | TURFBOOKING SYSTEM</title>
<link href="./output.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="contact.css">
<link rel="stylesheet" href="turf.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<link rel="shortcut icon" href="./gallery/favicon.png" type="image/x-icon">
<style>
@keyframes slideUp {
  0% { opacity:0; transform:translateY(20px); }
  100% { opacity:1; transform:translateY(0); }
}
.animate-slideUp { animation: slideUp 0.5s ease-out forwards; }
</style>
</head>
<body>

<?php include "header.php"; ?>
<section>
  <div class="line-turf">
    <p>Home /</p>
    <p style="margin-left: 5px;"> My Orders</p>
  </div>
</section>

<div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
  <h1 class="text-2xl sm:text-3xl font-bold text-blue-600 text-center mb-8">🛒 My Product Orders</h1>

  <?php if(mysqli_num_rows($result) > 0): ?>
    <!-- Responsive grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php while($row = mysqli_fetch_assoc($result)): ?>
        <div class="p-5 bg-white rounded-xl shadow-lg border-l-4 border-green-600 animate-slideUp flex flex-col">
          <h3 class="text-lg sm:text-xl font-semibold text-green-800 mb-2">Products:</h3>
          <p class="text-gray-700 break-words"><?= htmlspecialchars($row['product_names']) ?></p>

          <p class="mt-2 text-sm sm:text-base"><b>Subtotal:</b> ₹<?= number_format($row['subtotal'],2) ?></p>
          <p class="text-sm sm:text-base"><b>SGST:</b> ₹<?= number_format($row['sgst'],2) ?> | <b>CGST:</b> ₹<?= number_format($row['cgst'],2) ?></p>
          <p class="font-bold text-sm sm:text-base"><b>Grand Total:</b> ₹<?= number_format($row['grand_total'],2) ?></p>

          <p class="mt-2 text-sm sm:text-base"><b>Name:</b> <?= htmlspecialchars($row['fullname']) ?></p>
          <p class="text-sm sm:text-base"><b>Mobile:</b> <?= htmlspecialchars($row['mobile']) ?></p>
          <p class="text-sm sm:text-base"><b>Address:</b> <?= htmlspecialchars($row['address']) ?>, <?= htmlspecialchars($row['city']) ?>, <?= htmlspecialchars($row['state']) ?> - <?= htmlspecialchars($row['pincode']) ?></p>
          <p class="text-sm sm:text-base"><b>Payment Method:</b> <?= strtoupper(htmlspecialchars($row['payment_method'])) ?></p>
          <p class="mt-2 text-green-700 font-semibold text-sm sm:text-base">
            Reference: <span class="font-bold text-green-600 bg-green-100 px-2 py-1 rounded break-all"><?= htmlspecialchars($row['payment_ref']) ?></span>
          </p>
          <p class="text-gray-400 text-xs sm:text-sm mt-1">Ordered on: <?= htmlspecialchars($row['created_at']) ?></p>

          <!-- Delivery Status Calculation -->
          <?php
            $createdAt = new DateTime($row['created_at']);
            $now = new DateTime();
            $daysPassed = $createdAt->diff($now)->days;
            $totalDeliveryDays = 10;
            $remainingDays = max($totalDeliveryDays - $daysPassed, 0);

            if ($remainingDays > 0) {
                echo "<p class='text-blue-600 font-semibold mt-2 text-sm sm:text-base'>
                        🚚 Delivery within {$remainingDays} days
                      </p>";
            } else {
                echo "<p class='text-green-600 font-bold mt-2 text-sm sm:text-base'>
                        ✅ Delivered
                      </p>";
            }
          ?>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <p class="text-center text-gray-500 mt-10">No product orders found.</p>
  <?php endif; ?>
</div>

<?php include "footer.php"; ?>
<script src="main.js"></script>
<script src="all-animation.js"></script>
</body>
</html>
