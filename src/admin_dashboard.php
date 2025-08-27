<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "turfbookingsystem";

$conn = mysqli_connect($host, $user, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM signup"))['total'];
$total_bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM ticket"))['total'];
$total_products = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM product"))['total'];
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM product_shopping"))['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN DASHBOARD</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="shortcut icon" href="./gallery/favicon.png" type="image/x-icon">
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Header -->
  <header class="bg-white shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
      <h1 class="text-xl font-bold text-indigo-700">🏟️ Turf Admin Panel</h1>
      <nav class="space-x-4">
        <a href="admin_dashboard.php" class="text-sm text-gray-600 hover:text-indigo-600 font-medium">Dashboard</a>
        <a href="admin_user.php" class="text-sm text-gray-600 hover:text-indigo-600 font-medium">Users</a>
        <a href="admin_product.php" class="text-sm text-gray-600 hover:text-indigo-600 font-medium">Products</a>
        <a href="admin_booking.php" class="text-sm text-gray-600 hover:text-indigo-600 font-medium">Bookings</a>
        <a href="admin_orders.php" class="text-sm text-gray-600 hover:text-indigo-600 font-medium">Orders</a>
        <a href="logout.php" class="text-sm text-red-500 hover:text-red-700 font-semibold">Logout</a>
      </nav>
    </div>
  </header>

  <!-- Main Content -->
  <div class="max-w-6xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl shadow-md p-6">
      <h2 class="text-xl md:text-2xl font-semibold text-center mb-6">📊 ADMIN DASHBOARD</h2>

      <!-- Chart -->
      <div class="flex justify-center mb-8">
        <div class="w-full sm:w-80">
          <canvas id="circleChart"></canvas>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        <div class="bg-blue-50 p-4 rounded-xl text-center shadow">
          <p class="text-sm text-blue-600">Total Users</p>
          <h2 class="text-xl font-bold text-blue-900"><?= $total_users ?></h2>
        </div>
        <div class="bg-green-50 p-4 rounded-xl text-center shadow">
          <p class="text-sm text-green-600">Total Bookings</p>
          <h2 class="text-xl font-bold text-green-900"><?= $total_bookings ?></h2>
        </div>
        <div class="bg-purple-50 p-4 rounded-xl text-center shadow">
          <p class="text-sm text-purple-600">Total Products</p>
          <h2 class="text-xl font-bold text-purple-900"><?= $total_products ?></h2>
        </div>
        <div class="bg-yellow-50 p-4 rounded-xl text-center shadow">
  <p class="text-sm text-yellow-600">Total Orders</p>
  <h2 class="text-xl font-bold text-yellow-900"><?= $total_orders ?></h2>
</div>

      </div>
    </div>
  </div>

  <!-- Chart Script -->
  <script>
    const ctx = document.getElementById('circleChart').getContext('2d');
    new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Users', 'Bookings', 'Products'],
        datasets: [{
          data: [<?= $total_users ?>, <?= $total_bookings ?>, <?= $total_products ?>],
          backgroundColor: ['#3B82F6', '#10B981', '#8B5CF6'],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              font: { size: 14 },
              padding: 12
            }
          },
          datalabels: {
            formatter: (value, context) => {
              const sum = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
              return ((value / sum) * 100).toFixed(1) + '%';
            },
            color: '#fff',
            font: {
              weight: 'bold',
              size: 10
            }
          }
        }
      },
      plugins: [ChartDataLabels]
    });
    labels: ['Users', 'Bookings', 'Products', 'Orders'],
datasets: [{
  data: [<?= $total_users ?>, <?= $total_bookings ?>, <?= $total_products ?>, <?= $total_orders ?>],
  backgroundColor: ['#3B82F6', '#10B981', '#8B5CF6', '#F59E0B'],
  borderWidth: 1
}]

  </script>

</body>
</html>
