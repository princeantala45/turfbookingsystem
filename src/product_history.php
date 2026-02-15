<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "turfbookingsystem");

if (!$conn) die("Connection failed: " . mysqli_connect_error());

// Check login
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* -------- Cancel Order -------- */
if (isset($_GET['cancel'])) {
    $order_id = (int)$_GET['cancel'];

    $stmtCancel = $conn->prepare("UPDATE product_shopping 
                                  SET status='Cancelled' 
                                  WHERE id=? AND user_id=? AND status='Processing'");
    $stmtCancel->bind_param("ii", $order_id, $user_id);
    $stmtCancel->execute();

    header("Location: product_history.php?cancelled=1");
    exit();
}

// Fetch product orders securely
$stmt = $conn->prepare("SELECT * FROM product_shopping WHERE user_id = ? ORDER BY id DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MY ORDERS | TURFBOOKING SYSTEM</title>

<link href="./output.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="contact.css">
<link rel="stylesheet" href="turf.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<link rel="shortcut icon" href="./gallery/favicon.png" type="image/x-icon">

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
@keyframes slideUp {
  0% { opacity:0; transform:translateY(20px); }
  100% { opacity:1; transform:translateY(0); }
}
.animate-slideUp { animation: slideUp 0.5s ease-out forwards; }
</style>
</head>
<body class="bg-gray-50">

<?php include "header.php"; ?>

<section>
    <div class="line-turf">
        <p>Home /</p>
        <p style="margin-left: 5px;"> My Orders</p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">

<h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-blue-600 text-center mb-6 sm:mb-8">
🛒 My Product Orders
</h1>

<?php if ($result->num_rows > 0): ?>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">

<?php while ($row = $result->fetch_assoc()): ?>

<div class="p-4 sm:p-5 bg-white rounded-xl shadow-md hover:shadow-lg transition duration-300 border-l-4 border-green-600 animate-slideUp flex flex-col justify-between">

<div>

<h3 class="text-base sm:text-lg font-semibold text-green-800 mb-2">
Products:
</h3>

<p class="text-gray-700 break-words text-sm sm:text-base">
<?= htmlspecialchars($row['product_names']); ?>
</p>

<div class="mt-3 space-y-1 text-xs sm:text-sm">
<p><b>Subtotal:</b> ₹<?= number_format($row['subtotal'], 2); ?></p>
<p>
<b>SGST:</b> ₹<?= number_format($row['sgst'], 2); ?> |
<b>CGST:</b> ₹<?= number_format($row['cgst'], 2); ?>
</p>
<p class="font-bold text-gray-800">
Grand Total: ₹<?= number_format($row['grand_total'], 2); ?>
</p>
</div>

<div class="mt-3 text-xs sm:text-sm space-y-1 break-words">
<p><b>Name:</b> <?= htmlspecialchars($row['fullname']); ?></p>
<p><b>Mobile:</b> <?= htmlspecialchars($row['mobile']); ?></p>
<p>
<b>Address:</b>
<?= htmlspecialchars($row['address']); ?>,
<?= htmlspecialchars($row['city']); ?>,
<?= htmlspecialchars($row['state']); ?> -
<?= htmlspecialchars($row['pincode']); ?>
</p>
<p><b>Payment:</b> <?= strtoupper(htmlspecialchars($row['payment_method'])); ?></p>
</div>

<p class="mt-2 text-green-700 font-semibold text-xs sm:text-sm break-all">
Reference:
<span class="font-bold text-green-600 bg-green-100 px-2 py-1 rounded">
<?= htmlspecialchars($row['payment_ref']); ?>
</span>
</p>

<p class="text-gray-400 text-xs mt-1">
Ordered on: <?= htmlspecialchars($row['created_at']); ?>
</p>

<div class="mt-2 text-xs sm:text-sm">
<b>Status:</b>
<?php if ($row['status'] == 'Processing'): ?>
<span class="text-yellow-600 font-semibold">Processing</span>
<?php elseif ($row['status'] == 'Cancelled'): ?>
<span class="text-red-600 font-semibold">Cancelled</span>
<?php else: ?>
<span class="text-green-600 font-semibold">Delivered</span>
<?php endif; ?>
</div>

</div>

<div class="mt-4 flex flex-col sm:flex-row gap-2">

<?php if ($row['status'] == 'Processing'): ?>
<a href="?cancel=<?= $row['id']; ?>"
class="w-full sm:w-auto text-center bg-red-500 text-white px-3 py-2 rounded text-xs sm:text-sm hover:bg-red-600 transition"
onclick="confirmCancel(event, <?= $row['id']; ?>)">
Cancel Order
</a>
<?php endif; ?>

<a href="product_invoice.php?id=<?= $row['id']; ?>"
class="w-full sm:w-auto text-center bg-blue-600 text-white px-3 py-2 rounded text-xs sm:text-sm hover:bg-blue-700 transition">
View Invoice
</a>

</div>

</div>

<?php endwhile; ?>

</div>

<?php else: ?>

<div class="text-center mt-10 px-4">
<p class="text-gray-500 text-base sm:text-lg">No product orders found.</p>
<a href="product.php"
class="mt-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
Browse Products
</a>
</div>

<?php endif; ?>

</div>

<?php include "footer.php"; ?>

<script>
function confirmCancel(event, orderId) {
    event.preventDefault();

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, cancel it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "?cancel=" + orderId;
        }
    });
}
</script>

<?php if (isset($_GET['cancelled'])): ?>
<script>
Swal.fire({
    title: 'Cancelled!',
    text: 'Your order has been cancelled successfully.',
    icon: 'success',
    confirmButtonColor: '#3085d6'
});
</script>
<?php endif; ?>

<script src="main.js"></script>
<script src="all-animation.js"></script>

</body>
</html>
