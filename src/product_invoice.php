<?php
session_start();


$host = $_ENV['DB_HOST'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$db   = $_ENV['DB_NAME'];
$port = $_ENV['DB_PORT'];

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) die("Invalid request.");

$order_id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM product_shopping WHERE id=? AND user_id=?");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) die("Order not found.");

$order = $result->fetch_assoc();
$stmt->close();
$conn->close();

/* QR */
$qrData = "Invoice: {$order['payment_ref']}\n";
$qrData .= "Date: {$order['created_at']}\n";
$qrData .= "Amount: ₹{$order['grand_total']}";

$qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($qrData);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Tax Invoice</title>
<link rel="stylesheet" href="style.css">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<style>
.no-print { display:block; }
@media print { .no-print { display:none; } }
</style>
</head>

<body class="bg-gray-100 py-10">

<div id="invoice" class="max-w-3xl mx-auto bg-white shadow p-8 rounded">

<!-- Header -->
<div class="flex justify-between items-start mb-6 border-b pb-4">

<div>
<h1 class="text-2xl font-bold">TurfBookingSystem</h1>
<p class="text-sm text-gray-600">
SV Campus, Ayodhya Nagar<br>
Kadi – 382715<br>
Gujarat, India
</p>
</div>
<img src="header-image-black.png" 
     alt="Company Logo" 
     style="width:150px; margin-bottom:10px;">

<div class="text-right text-sm">
<p><strong>GSTIN:</strong> 24ABCDE1234F1Z5</p>
<p><strong>State Code:</strong> 24</p>
<p class="mt-3"><strong>Invoice No:</strong> <?= htmlspecialchars($order['payment_ref']) ?></p>
<p><strong>Date:</strong> <?= date("d M Y", strtotime($order['created_at'])) ?></p>
</div>

</div>

<h2 class="text-xl font-semibold text-center mb-6">Tax Invoice</h2>

<!-- Billing Details -->
<h2 class="font-semibold mb-2">Billing Details</h2>
<div class="text-sm mb-6 border p-4 rounded bg-gray-50">
<p><strong>Name:</strong> <?= htmlspecialchars($order['fullname']) ?></p>
<p><strong>Mobile:</strong> <?= htmlspecialchars($order['mobile']) ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></p>
<p><strong>Address:</strong>
<?= htmlspecialchars($order['address']) ?>,
<?= htmlspecialchars($order['city']) ?>,
<?= htmlspecialchars($order['state']) ?> -
<?= htmlspecialchars($order['pincode']) ?>
</p>
</div>

<!-- Order Summary -->
<h2 class="font-semibold mb-2">Order Summary</h2>

<table class="w-full border text-sm mb-6">
<thead class="bg-gray-100">
<tr>
<th class="border px-3 py-2 text-left">Description</th>
<th class="border px-3 py-2 text-right">Amount (₹)</th>
</tr>
</thead>
<tbody>
<tr>
<td class="border px-3 py-2"><?= htmlspecialchars($order['product_names']) ?></td>
<td class="border px-3 py-2 text-right"><?= number_format($order['subtotal'],2) ?></td>
</tr>
<tr>
<td class="border px-3 py-2">GST (18%)</td>
<td class="border px-3 py-2 text-right">
<?= number_format($order['sgst'] + $order['cgst'],2) ?>
</td>
</tr>
<tr class="font-bold">
<td class="border px-3 py-2">Total</td>
<td class="border px-3 py-2 text-right">
<?= number_format($order['grand_total'],2) ?>
</td>
</tr>
</tbody>
</table>

<!-- QR + Signature -->
<div class="flex justify-between items-center mt-8">
<img src="<?= $qrUrl ?>" class="w-24 h-24 border rounded">

<div class="text-right text-sm">
    <img src="sign.png" width="120px" alt="">
<p class="font-semibold">Prince Antala</p>
<p>Authorized Signatory</p>
</div>
</div>

<div class="flex justify-between">
<!-- Buttons -->
<div class="pt-4 flex justify-start">
      <button type="submit" onclick="downloadPDF()" name="add_to_cart"  class="cssbuttons-io-button">
        Download Invoice
        <div class="icon1">
            <svg height="24" width="24" viewBox="0 0 24 24">
                <path d="M0 0h24v24H0z" fill="none"></path>
                <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                      fill="currentColor"></path>
            </svg>
        </div>
    </button>
</div>


<div class="pt-4 flex justify-start">
    <a href="booking.php">
      <button type="submit" name="add_to_cart"  class="cssbuttons-io-button">
        BACK
        <div class="icon1">
            <svg height="24" width="24" viewBox="0 0 24 24">
                <path d="M0 0h24v24H0z" fill="none"></path>
                <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                      fill="currentColor"></path>
            </svg>
        </div>
    </button>
    </a>
</div>

</div>

</div>

<script>
async function downloadPDF() {
    const { jsPDF } = window.jspdf;
    const element = document.getElementById("invoice");
    const noPrint = document.querySelector('.no-print');
    if(noPrint) noPrint.style.display = 'none';

    const canvas = await html2canvas(element, {useCORS:true});
    const imgData = canvas.toDataURL("image/png");

    const pdf = new jsPDF("p","mm","a4");
    const width = pdf.internal.pageSize.getWidth();
    const height = (canvas.height * width) / canvas.width;

    pdf.addImage(imgData,"PNG",10,10,width-20,height);
    pdf.save("invoice-<?= htmlspecialchars($order['payment_ref']) ?>.pdf");

    if(noPrint) noPrint.style.display = 'block';
}
</script>

</body>
</html>
