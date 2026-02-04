<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// DB connect
$conn = mysqli_connect("localhost", "root", "", "turfbookingsystem");
if (!$conn) {
    die("DB Connection failed: " . mysqli_connect_error());
}

// safe scalar helper
function scalar($conn, $sql) {
    $res = mysqli_query($conn, $sql);
    if (!$res) return 0;
    $row = mysqli_fetch_row($res);
    return $row ? (int)$row[0] : 0;
}

// totals
$total_users     = scalar($conn, "SELECT COUNT(*) FROM signup");
$total_bookings  = scalar($conn, "SELECT COUNT(*) FROM ticket");
$total_products  = scalar($conn, "SELECT COUNT(*) FROM product");
$total_orders    = scalar($conn, "SELECT COUNT(*) FROM product_shopping");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ADMIN DASHBOARD</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="./gallery/favicon.png" type="image/x-icon">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Header -->
  <header class="bg-white shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
      <h1 class="text-2xl font-bold text-indigo-700 flex items-center gap-2">🏟️ Turf Admin</h1>
      <nav class="space-x-6">
        <a href="admin_dashboard.php" class="text-sm font-medium text-gray-600 hover:text-indigo-600">Dashboard</a>
        <a href="admin_user.php" class="text-sm font-medium text-gray-600 hover:text-indigo-600">Users</a>
        <a href="admin_product.php" class="text-sm font-medium text-gray-600 hover:text-indigo-600">Products</a>
        <a href="admin_booking.php" class="text-sm font-medium text-gray-600 hover:text-indigo-600">Bookings</a>
        <a href="admin_orders.php" class="text-sm font-medium text-gray-600 hover:text-indigo-600">Orders</a>
        <a href="logout.php" class="text-sm font-semibold text-red-500 hover:text-red-700">Logout</a>
      </nav>
    </div>
  </header>

  <!-- Content -->
  <main class="max-w-6xl mx-auto p-6">
    <div class="bg-white rounded-2xl shadow p-6">
      <h2 class="text-xl md:text-2xl font-semibold text-center mb-8">📊 Admin Dashboard</h2>

      <!-- Stats -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-blue-50 border border-blue-100 p-5 rounded-xl shadow-sm hover:shadow-md transition">
          <p class="text-sm text-blue-600">Total Users</p>
          <h2 class="text-3xl font-bold text-blue-900 mt-2"><?= $total_users ?></h2>
        </div>
        <div class="bg-green-50 border border-green-100 p-5 rounded-xl shadow-sm hover:shadow-md transition">
          <p class="text-sm text-green-600">Total Bookings</p>
          <h2 class="text-3xl font-bold text-green-900 mt-2"><?= $total_bookings ?></h2>
        </div>
        <div class="bg-purple-50 border border-purple-100 p-5 rounded-xl shadow-sm hover:shadow-md transition">
          <p class="text-sm text-purple-600">Total Products</p>
          <h2 class="text-3xl font-bold text-purple-900 mt-2"><?= $total_products ?></h2>
        </div>
        <div class="bg-yellow-50 border border-yellow-100 p-5 rounded-xl shadow-sm hover:shadow-md transition">
          <p class="text-sm text-yellow-600">Total Orders</p>
          <h2 class="text-3xl font-bold text-yellow-900 mt-2"><?= $total_orders ?></h2>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="flex flex-wrap justify-center gap-4">
        <a href="admin_orders.php" class="px-4 py-2 rounded-xl bg-indigo-50 text-indigo-700 border border-indigo-200 hover:bg-indigo-100 transition">📦 View Orders</a>
        <a href="admin_user.php" class="px-4 py-2 rounded-xl bg-indigo-50 text-indigo-700 border border-indigo-200 hover:bg-indigo-100 transition">👤 Users</a>
        <a href="admin_product.php" class="px-4 py-2 rounded-xl bg-indigo-50 text-indigo-700 border border-indigo-200 hover:bg-indigo-100 transition">🛒 Products</a>
        <a href="admin_booking.php" class="px-4 py-2 rounded-xl bg-indigo-50 text-indigo-700 border border-indigo-200 hover:bg-indigo-100 transition">🎫 Bookings</a>
      </div>
    </div>
  </main>

</body>
</html>
