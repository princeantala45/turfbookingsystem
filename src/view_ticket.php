<?php
session_start();


$host = $_ENV['DB_HOST'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$db   = $_ENV['DB_NAME'];

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['booking_id'])) {
    die("Invalid Request");
}

$booking_id = intval($_GET['booking_id']);
$username = $_SESSION['username'];

$stmt = $conn->prepare("
    SELECT t.* 
    FROM ticket t
    JOIN signup s ON t.user_id = s.user_id
    WHERE t.booking_id = ? 
    AND s.username = ?
");
$stmt->bind_param("is", $booking_id, $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Booking not found.");
}

$row = $result->fetch_assoc();

$price = 1000;
$gst = $price * 0.18;
$total = $price + $gst;

$qrData =
"Invoice No: INV" . $row['booking_id'] . "\n" .
"Turf: " . $row['turfs'] . "\n" .
"Date: " . $row['date'] . "\n" .
"Time Slot: " . $row['time_slot'] . "\n" .
"Customer: " . $row['fullname'] . "\n" .
"Total: ₹" . number_format($total,2);

$qrURL = "https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=" . urlencode($qrData);
?>

<!DOCTYPE html>
<html>
<head>
<title>Invoice - INV<?= $row['booking_id']; ?></title>
<link rel="stylesheet" href="style.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f6f8;
    padding: 20px;
}

.invoice {
    width: 800px;
    margin: auto;
    background: #ffffff;
    padding: 40px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

.header {
    display: flex;
    justify-content: space-between;
    border-bottom: 2px solid #2c3e50;
    padding-bottom: 15px;
}

.company-info h2 {
    margin: 0;
    font-size: 22px;
    color: #2c3e50;
}

.invoice-info {
    text-align: right;
}

.invoice-info h3 {
    margin: 0;
    font-weight: 600;
}

.section-title {
    margin-top: 30px;
    font-size: 15px;
    font-weight: bold;
    color: #2c3e50;
    border-bottom: 1px solid #ddd;
    padding-bottom: 6px;
}

p {
    margin: 6px 0;
    font-size: 14px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

th {
    background: #f0f2f5;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ddd;
    text-align: left;
}

td {
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ddd;
}

.right {
    text-align: right;
}

.total-row td {
    font-weight: bold;
    font-size: 15px;
}

.footer-row {
    display: flex;
    justify-content: space-between;
    margin-top: 40px;
    align-items: center;
}

.qr img {
    width: 110px;
}

.signature {
    text-align: right;
}

.signature img {
    width: 120px;
}
.actions {
    width: 800px;
    margin: 20px auto;
    display: flex;
    justify-content: center; 
    align-items: center;         
    gap: 15px;                   
}

.actions > div {
    display: flex;
    gap: 15px;
    /* align-items: ; */
}
@media print {
    .actions {
        display: none !important;
    }
}

@media print {
    body { background: white; }
    .actions { display: none; }
}
</style>
</head>

<body>

<div class="invoice" id="invoiceContent">

    <div class="header">
    
    <div style="display:flex; align-items:center; gap:15px;">        
        <div class="company-info">
            <h2>TurfBookingSystem</h2>
            <p>SV Campus, Ayodhya Nagar</p>
            <p>Kadi – 382715, Gujarat</p>
            <p><strong>GSTIN:</strong> 24ABCDE1234F1Z5</p>
        </div>
    </div>
        <img src="header-image-black.png" 
     alt="Company Logo" 
     style="width:150px; margin-bottom:10px;">


    <div class="invoice-info">
        <h3>TAX INVOICE</h3>
        <p><strong>Invoice No:</strong> INV<?= $row['booking_id']; ?></p>
        <p><strong>Date:</strong> <?= date("d M Y"); ?></p>
        <p><strong>Payment Ref:</strong> <?= htmlspecialchars($row['payment_reference']); ?></p>
    </div>

</div>

    <div class="section-title">Billing Details</div>
    <p><strong>Name:</strong> <?= htmlspecialchars($row['fullname']); ?></p>
    <p><strong>Mobile:</strong> <?= htmlspecialchars($row['mobile']); ?></p>
    <p>
        <?= htmlspecialchars($row['address']); ?>,
        <?= htmlspecialchars($row['city']); ?>,
        <?= htmlspecialchars($row['state']); ?> -
        <?= htmlspecialchars($row['pincode']); ?>
    </p>

    <div class="section-title">Order Summary</div>

    <table>
        <tr>
            <th>Description</th>
            <th>Date & Time</th>
            <th>Status</th>
            <th class="right">Amount (₹)</th>
        </tr>
        <tr>
            <td><?= htmlspecialchars($row['turfs']); ?></td>
            <td><?= htmlspecialchars($row['date']); ?><br><?= htmlspecialchars($row['time_slot']); ?></td>
            <td><?= ucfirst($row['status']); ?></td>
            <td class="right"><?= number_format($price, 2); ?></td>
        </tr>
        <tr>
            <td colspan="3" class="right">GST (18%)</td>
            <td class="right"><?= number_format($gst, 2); ?></td>
        </tr>
        <tr class="total-row">
            <td colspan="3" class="right">Total</td>
            <td class="right"><?= number_format($total, 2); ?></td>
        </tr>
    </table>

    <div class="footer-row">
        <div class="qr">
            <img src="<?= $qrURL; ?>" alt="QR Code">
        </div>

        <div class="signature">
            <img src="sign.png" alt="Signature">
            <p><strong>Prince Antala</strong></p>
            <p>Authorized Signatory</p>
        </div>
    </div>

</div>

<div class="actions">
  <div class="pt-4 flex justify-center gap-3">

    <!-- Download PDF -->
    <button type="submit" onclick="downloadPDF()" class="cssbuttons-io-button">
      Download PDF
      <div class="icon1">
        <svg height="24" width="24" viewBox="0 0 24 24">
          <path d="M0 0h24v24H0z" fill="none"></path>
          <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                fill="currentColor"></path>
        </svg>
      </div>
    </button>

<div class="pt-4 flex justify-start">
    <a href="index.php" style="text-decoration:none;">
      <button type="submit" name="add_to_cart"  class="cssbuttons-io-button">
        HOME
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

<div class="pt-4 flex justify-start">
    <a style="text-decoration:none;" href="booking.php">
      <button type="submit" name="add_to_cart"  class="cssbuttons-io-button">
        HISTORY
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
    const element = document.getElementById("invoiceContent");

    const canvas = await html2canvas(element, { scale: 2 });
    const imgData = canvas.toDataURL("image/png");

    const pdf = new jsPDF("p", "mm", "a4");
    const pageWidth = pdf.internal.pageSize.getWidth();
    const pageHeight = pdf.internal.pageSize.getHeight();

    const imgWidth = pageWidth;
    const imgHeight = (canvas.height * imgWidth) / canvas.width;

    let heightLeft = imgHeight;
    let position = 0;

    pdf.addImage(imgData, "PNG", 0, position, imgWidth, imgHeight);
    heightLeft -= pageHeight;

    while (heightLeft > 0) {
        position = heightLeft - imgHeight;
        pdf.addPage();
        pdf.addImage(imgData, "PNG", 0, position, imgWidth, imgHeight);
        heightLeft -= pageHeight;
    }

    pdf.save("Invoice_INV<?= $row['booking_id']; ?>.pdf");
}
</script>

</body>
</html>
