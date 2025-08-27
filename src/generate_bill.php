<?php
session_start();

// ---- Database Connection ----
$conn = new mysqli("localhost", "root", "", "turfbookingsystem");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// ------------------ Turf Booking ------------------
if (isset($_POST['turf_booking'])) {
    $username = $_SESSION['username'] ?? null;
    $payment_method = $_POST['payment_method'];

    if (!$username) {
        echo "<script>alert('Please login first!'); window.location.href='login.php';</script>";
        exit;
    }

    // Fetch user_id
    $stmt = $conn->prepare("SELECT id FROM users WHERE username=? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();

    if (!$user_id) {
        echo "<script>alert('User not found!'); window.location.href='login.php';</script>";
        exit;
    }

    // Insert into booking table
    $stmt = $conn->prepare("INSERT INTO booking (user_id, username, turf_name, booking_date, total_amount, payment_method) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssis", $user_id, $username, $_POST['turf_name'], $_POST['booking_date'], $_POST['total_amount'], $payment_method);
    $stmt->execute();
    $booking_id = $stmt->insert_id;
    $stmt->close();

    // Insert into payment table
    if ($payment_method == "upi") {
        $stmt = $conn->prepare("INSERT INTO upi (booking_id, user_id, username, upiid, amount) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssi", $booking_id, $user_id, $username, $_POST['upi_id'], $_POST['total_amount']);
        $stmt->execute();
        $stmt->close();
    } elseif ($payment_method == "card") {
        $stmt = $conn->prepare("INSERT INTO card_data (booking_id, user_id, username, card_number, card_holder, expiry, cvv, amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssssi", $booking_id, $user_id, $username, $_POST['card_number'], $_POST['card_holder'], $_POST['expiry'], $_POST['cvv'], $_POST['total_amount']);
        $stmt->execute();
        $stmt->close();
    }
}

// ------------------ Cart Checkout ------------------
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Cart is empty!'); window.location.href='cart.php';</script>";
    exit;
}

$product_ids = array_map(fn($item) => $item['product_id'], $_SESSION['cart']);
$qty_map = array_column($_SESSION['cart'], 'qty', 'product_id');
$ids = implode(",", $product_ids);
$products = [];
$total = 0;

$result = mysqli_query($conn, "SELECT * FROM product WHERE product_id IN ($ids)");
while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['product_id'];
    $qty = $qty_map[$id];
    $line_total = $row['product_price'] * $qty;
    $products[] = [
        'id' => $id,
        'name' => $row['product_name'],
        'qty' => $qty,
        'price' => $row['product_price']
    ];
    $total += $line_total;
}

// GST Calculation
$sgst = round($total * 0.09, 2);
$cgst = round($total * 0.09, 2);
$grand_total = $total + $sgst + $cgst;

// Number to words function
function convertNumberToWords($number) {
    $words = [0=>'Zero',1=>'One',2=>'Two',3=>'Three',4=>'Four',5=>'Five',6=>'Six',7=>'Seven',8=>'Eight',9=>'Nine',
        10=>'Ten',11=>'Eleven',12=>'Twelve',13=>'Thirteen',14=>'Fourteen',15=>'Fifteen',16=>'Sixteen',17=>'Seventeen',
        18=>'Eighteen',19=>'Nineteen',20=>'Twenty',30=>'Thirty',40=>'Forty',50=>'Fifty',60=>'Sixty',70=>'Seventy',
        80=>'Eighty',90=>'Ninety'];
    if($number<21) return $words[$number];
    if($number<100) return $words[10*floor($number/10)].($number%10?'-'.$words[$number%10]:'');
    if($number<1000) return $words[floor($number/100)].' Hundred'.($number%100?' and '.convertNumberToWords($number%100):'');
    if($number<100000) return convertNumberToWords(floor($number/1000)).' Thousand'.($number%1000?' '.convertNumberToWords($number%1000):'');
    return "$number";
}

// Invoice reference
$ref = "PRODUCT". rand(10000,99999);
$product_names = implode(", ", array_map(fn($p)=>$p['name']." (x{$p['qty']})",$products));

// ------------------ QR Code ------------------
$fullname = $_SESSION['fullname'] ?? '';
$email = $_SESSION['email'] ?? '';
$mobile = $_SESSION['mobile'] ?? '';
$address = $_SESSION['address'] ?? '';
$city = $_SESSION['city'] ?? '';
$state = $_SESSION['state'] ?? '';
$pincode = $_SESSION['pincode'] ?? '';
$username = $_SESSION['username'] ?? 'guest';
$payment_method = $_POST['payment_method'] ?? 'COD';
$turf_name = $_POST['turf_name'] ?? '';
$booking_date = $_POST['booking_date'] ?? '';
$total_amount = $_POST['total_amount'] ?? 0;

$qrData = "🧾 Booking & Product Bill\n";
$qrData .= "👤 Name: $fullname\n";
$qrData .= "📧 Email: $email\n";
$qrData .= "📞 Mobile: $mobile\n";
$qrData .= "🏠 Address: $address, $city, $state - $pincode\n\n";

$qrData .= "🏟️ Turf Booking:\n";
$qrData .= "Turf Name: $turf_name\n";
$qrData .= "Booking Date: $booking_date\n";
$qrData .= "Amount Paid: ₹$total_amount\n";
$qrData .= "Payment Method: $payment_method\n\n";

$qrData .= "🛒 Products:\n";
foreach ($products as $p) {
    $qrData .= $p['name'] . " (x{$p['qty']}) - ₹" . ($p['price'] * $p['qty']) . "\n";
}
$qrData .= "\nSubtotal: ₹$total\nSGST: ₹$sgst\nCGST: ₹$cgst\nGrand Total: ₹$grand_total\n";
$qrData .= "Invoice Ref: $ref";

// Generate QR code
$qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($qrData);

// ------------------ Product Checkout ------------------
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Please login first!'); window.location.href='login.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<script>alert('Invalid Access!'); window.location.href='checkout.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id']; 
$username = $_SESSION['username'];

$fullname = $_POST['fullname'] ?? '';
$email = $_POST['email'] ?? '';
$mobile = $_POST['mobile'] ?? '';
$state = $_POST['state'] ?? '';
$city = $_POST['city'] ?? '';
$pincode = $_POST['pincode'] ?? '';
$address = $_POST['address'] ?? '';

$product_names = $_POST['product_names'] ?? '';
$subtotal = $_POST['subtotal'] ?? 0;
$sgst = $_POST['sgst'] ?? 0;
$cgst = $_POST['cgst'] ?? 0;
$grand_total = $_POST['grand_total'] ?? 0;
$payment_method = $_POST['payment_method'] ?? '';

// --- Validate required fields ---
if (!$fullname || !$email || !$mobile || !$state || !$city || !$pincode || !$address || !$payment_method) {
    echo "<script>alert('⚠️ All fields are required!'); window.location.href='checkout.php';</script>";
    exit;
}

// --- Insert into product_shopping ---
$sql = "INSERT INTO product_shopping 
(user_id, fullname, email, mobile, state, city, pincode, address, product_names, subtotal, sgst, cgst, grand_total, payment_method) 
VALUES 
('$user_id', '$fullname', '$email', '$mobile', '$state', '$city', '$pincode', '$address', '$product_names', '$subtotal', '$sgst', '$cgst', '$grand_total', '$payment_method')";

if (mysqli_query($conn, $sql)) {
    $order_id = mysqli_insert_id($conn);

    // Card
    if ($payment_method === "card") {
        $cardnumber = $_POST['cardnumber'];
        $cardholdername = $_POST['cardholdername'];
        $expiry = $_POST['expiry'];
        $cvv = $_POST['cvv'];

        $sqlCard = "INSERT INTO product_card_data 
        (user_id, username, cardholdername, cardnumber, expiry, cvv, product) 
        VALUES 
        ('$user_id', '$username', '$cardholdername', '$cardnumber', '$expiry', '$cvv', '$product_names')";
        mysqli_query($conn, $sqlCard);
    }

    // UPI
    if ($payment_method === "upi") {
        $upiid = $_POST['upi'];
        $sqlUpi = "INSERT INTO product_upi_data 
        (user_id, username, upiid, product) 
        VALUES 
        ('$user_id', '$username', '$upiid', '$product_names')";
        mysqli_query($conn, $sqlUpi);
    }

    echo "<script>
        alert('✅ Order Placed Successfully! Order ID: $order_id');
    </script>";
} else {
    echo "Error: " . mysqli_error($conn);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PRODUCT INVOICE | TURFBOOKING SYSTEM</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <link rel="shortcut icon" href="./gallery/favicon.png" type="image/x-icon">
  <style>
    .no-print { display: block; }
    @media print { .no-print { display: none; } }
  </style>
</head>
<body class="bg-gray-100 p-6">

<div id="ticket" class="max-w-3xl mx-auto bg-white rounded-lg p-6 shadow">
  <div class="flex items-center justify-between mb-4">
    <img src="./header-image-black.png" alt="Logo" class="h-12">
    <div class="text-right text-xs text-gray-600">
      <p><strong>Administrator:</strong></p>
      <p>SV Campus, Ayodhya Nagar</p>
      <p>Kadi – 382715</p>
    </div>
  </div>

  <h2 class="text-2xl font-bold text-center text-blue-700 mb-1">🛒 Product Invoice</h2>
  <p class="text-center text-sm text-gray-500 mb-6">Generated by TurfBookingSystem</p>

  <div class="grid grid-cols-2 gap-4 text-sm mb-4">
    <div>
      <p><strong>Invoice No:</strong> <?= $ref ?></p>
      <p><strong>Date:</strong> <?= date("d-m-Y") ?></p>
      <p><strong>User:</strong> <?= $username ?></p>
      <p><strong>Email:</strong> <?= $email ?></p>
    </div>
    <div>
      <p><strong>Billing Address:</strong></p>
      <p><?= $fullname ?></p>
      <p><?= $address ?>, <?= $city ?>, <?= $state ?> - <?= $pincode ?></p>
      <p><strong>Mobile:</strong> <?= $mobile ?></p>
    </div>
  </div>

  <table class="w-full border text-sm mb-4">
    <thead class="bg-gray-100">
      <tr>
        <th class="border px-2 py-1">Product</th>
        <th class="border px-2 py-1">Qty</th>
        <th class="border px-2 py-1">Price</th>
        <th class="border px-2 py-1">Total</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $p): ?>
      <tr>
        <td class="border px-2 py-1"><?= $p['name'] ?></td>
        <td class="border px-2 py-1"><?= $p['qty'] ?></td>
        <td class="border px-2 py-1">₹<?= number_format($p['price'], 2) ?></td>
        <td class="border px-2 py-1">₹<?= number_format($p['qty'] * $p['price'], 2) ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <div class="text-right text-sm">
    <p>Subtotal: ₹<?= number_format($total, 2) ?></p>
    <p>SGST (9%): ₹<?= number_format($sgst, 2) ?></p>
    <p>CGST (9%): ₹<?= number_format($cgst, 2) ?></p>
    <p class="font-bold text-lg text-green-700">Total: ₹<?= number_format($grand_total, 2) ?></p>
  </div>

  <div class="flex justify-between items-center mt-4 text-sm">
    <p><strong>In Words:</strong> <i><?= convertNumberToWords($grand_total) ?> Rupees Only</i></p>
    <img src="<?= $qrUrl ?>" alt="QR Code" class="w-24 h-24 border rounded shadow">
  </div>

  <div class="no-print text-center mt-6">
    <button onclick="downloadPDF()" class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700">⬇️ Download Invoice</button>
    <a href="index.php" class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 ml-4">🏠 Home</a>
  </div>
</div>

<script>
async function downloadPDF() {
  const { jsPDF } = window.jspdf;
  const ticket = document.getElementById("ticket");
  const noPrint = document.querySelector('.no-print');
  if (noPrint) noPrint.style.display = 'none';

  const canvas = await html2canvas(ticket, { useCORS: true });
  const imgData = canvas.toDataURL("image/png");
  const pdf = new jsPDF("p", "mm", "a4");
  const width = pdf.internal.pageSize.getWidth();
  const height = (canvas.height * width) / canvas.width;
  pdf.addImage(imgData, "PNG", 10, 10, width - 20, height);
  pdf.save("invoice-<?= $ref ?>.pdf");

  if (noPrint) noPrint.style.display = 'block';
}

window.onload = function () {
  setTimeout(downloadPDF, 1000); // Delay to ensure full rendering
};
</script>

</body>
</html>
