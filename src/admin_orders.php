<?php
session_start();

// Admin check
if (!isset($_SESSION['username'])) {
    header("Location: admin_login.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "turfbookingsystem");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch orders with username join
$result = mysqli_query($conn, "
    SELECT ps.id, s.username, ps.product_names, ps.grand_total, 
           ps.payment_method, ps.payment_ref, ps.created_at
    FROM product_shopping ps
    JOIN signup s ON ps.user_id = s.user_id
    ORDER BY ps.id DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ADMIN | Orders</title>
  <link rel="shortcut icon" href="./gallery/favicon.png" type="image/x-icon">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<style>
@keyframes slideUp {
  0% { opacity:0; transform:translateY(20px); }
  100% { opacity:1; transform:translateY(0); }
}
.animate-slideUp { animation: slideUp 0.4s ease-out forwards; }
</style>
</head>
<body class="bg-gray-100">

<div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
  <!-- Heading + Back Button -->
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-3 sm:space-y-0">
    <h1 class="text-2xl sm:text-3xl font-bold text-blue-600">📦 All Orders</h1>
    <a href="admin_dashboard.php" 
       class="w-full sm:w-auto text-center px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
       ⬅ Back to Dashboard
    </a>
  </div>

  <?php if(mysqli_num_rows($result) > 0): ?>
    <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
      <table class="min-w-full text-sm text-left border-collapse">
        <thead class="bg-blue-600 text-white text-xs sm:text-sm">
          <tr>
            <th class="px-3 sm:px-4 py-2">#</th>
            <th class="px-3 sm:px-4 py-2">Username</th>
            <th class="px-3 sm:px-4 py-2">Products</th>
            <th class="px-3 sm:px-4 py-2">Amount</th>
            <th class="px-3 sm:px-4 py-2">Payment</th>
            <th class="px-3 sm:px-4 py-2">Reference</th>
            <th class="px-3 sm:px-4 py-2">Date</th>
            <th class="px-3 sm:px-4 py-2">Status</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr class="border-b hover:bg-gray-50 animate-slideUp">
              <td class="px-3 sm:px-4 py-2 font-bold"><?= $row['id'] ?></td>
              <td class="px-3 sm:px-4 py-2"><?= htmlspecialchars($row['username']) ?></td>
              <td class="px-3 sm:px-4 py-2 text-gray-700 break-words max-w-xs sm:max-w-sm">
                <?= htmlspecialchars($row['product_names']) ?>
              </td>
              <td class="px-3 sm:px-4 py-2 font-semibold whitespace-nowrap">₹<?= number_format($row['grand_total'], 2) ?></td>
              <td class="px-3 sm:px-4 py-2"><?= strtoupper(htmlspecialchars($row['payment_method'])) ?></td>
              <td class="px-3 sm:px-4 py-2 text-green-800 break-all"><?= htmlspecialchars($row['payment_ref']) ?></td>
              <td class="px-3 sm:px-4 py-2 text-xs sm:text-sm whitespace-nowrap"><?= htmlspecialchars($row['created_at']) ?></td>
              <td class="px-3 sm:px-4 py-2">
                <?php
                  $createdAt = new DateTime($row['created_at']);
                  $now = new DateTime();
                  $daysPassed = $createdAt->diff($now)->days;
                  $totalDeliveryDays = 10;
                  $remainingDays = max($totalDeliveryDays - $daysPassed, 0);

                  if ($remainingDays > 0) {
                      echo "<span class='text-blue-600 font-semibold'>🚚 {$remainingDays} days left</span>";
                  } else {
                      echo "<span class='text-green-600 font-bold'>✅ Delivered</span>";
                  }
                ?>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p class="text-center text-gray-500 mt-10">No orders found.</p>
  <?php endif; ?>
</div>

</body>
</html>
