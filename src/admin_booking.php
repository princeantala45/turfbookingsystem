<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "turfbookingsystem",3307);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT t.*, s.email AS user_email 
        FROM ticket t 
        JOIN signup s ON t.user_id = s.user_id 
        ORDER BY t.date DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BOOKING TRACKER | ADMIN</title>
  <link rel="shortcut icon" href="./gallery/favicon.png" type="image/x-icon">
   <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
  <div class="container mx-auto py-10 px-4">
    <div class="flex items-center justify-between mb-8">
      <h1 class="text-3xl font-bold text-blue-700">📊 All Turf Bookings</h1>
      <a href="admin_dashboard.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition">
        ⬅️ Back to Dashboard
      </a>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-blue-600 text-white">
          <tr>
            <th class="px-4 py-2 text-left">Booking ID</th>
            <th class="px-4 py-2 text-left">Username</th>
            <th class="px-4 py-2 text-left">Full Name</th>
            <th class="px-4 py-2 text-left">Turf</th>
            <th class="px-4 py-2 text-left">Date</th>
            <th class="px-4 py-2 text-left">Payment Method</th>
            <th class="px-4 py-2 text-left">Ref</th>
            <th class="px-4 py-2 text-left">Email</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr class="hover:bg-gray-50">
              <td class="px-4 py-2"><?php echo $row['booking_id']; ?></td>
              <td class="px-4 py-2"><?php echo $row['username']; ?></td>
              <td class="px-4 py-2"><?php echo $row['fullname']; ?></td>
              <td class="px-4 py-2"><?php echo ucfirst($row['turfs']); ?></td>
              <td class="px-4 py-2"><?php echo $row['date']; ?></td>
              <td class="px-4 py-2"><?php echo ucfirst($row['payment_method']); ?></td>
              <td class="px-4 py-2 font-mono text-xs bg-green-100 text-green-800 rounded"><?php echo $row['payment_reference']; ?></td>
              <td class="px-4 py-2"><?php echo $row['user_email']; ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
