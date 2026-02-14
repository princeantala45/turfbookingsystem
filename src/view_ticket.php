<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "turfbookingsystem", 3307);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
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

/* Example price */
$price = 1000;
$gst = $price * 0.18;
$total = $price + $gst;

/* QR Data (Full Invoice Details) */
$qrData =
"INVOICE\n" .
"Invoice No: INV" . $row['booking_id'] . "\n" .
"Turf: " . $row['turfs'] . "\n" .
"Date: " . $row['date'] . "\n" .
"Customer: " . $row['fullname'] . "\n" .
"Mobile: " . $row['mobile'] . "\n" .
"Payment Ref: " . $row['payment_reference'] . "\n" .
"Total: ₹" . number_format($total,2) . "\n" .
"Authorized By: Prince Antala";

/* Free QR API */
$qrURL = "https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=" . urlencode($qrData);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice - INV<?= $row['booking_id']; ?></title>
    <style>
        body {
            font-family: Arial;
            background: #f3f3f3;
            font-size: 14px;
        }
        .invoice {
            width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 25px;
            box-shadow: 0 0 12px rgba(0,0,0,0.08);
        }
        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            width: 120px;
        }
        .invoice-info {
            text-align: right;
        }
        .section-title {
            margin-top: 15px;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
            padding-bottom: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
        }
        th {
            background: #f7f7f7;
        }
        .right {
            text-align: right;
        }
        .total-row td {
            font-weight: bold;
            background: #fafafa;
        }
        .qr img {
            width: 110px;
            height: 110px;
        }
        .footer-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        .signature {
            text-align: right;
        }
        .signature img {
            width: 120px;
        }
        .print-btn {
            text-align: center;
            margin-top: 15px;
        }
        button {
            padding: 8px 18px;
            background: #232f3e;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 13px;
        }
        .top-actions {
    text-align: right;
    margin-bottom: 10px;
}
.top-actions a {
    text-decoration: none;
    padding: 6px 12px;
    margin-left: 5px;
    font-size: 13px;
    border-radius: 4px;
    background: #232f3e;
    color: white;
}
.top-actions a.profile {
    background: #2563eb;
}
@media print {
    .top-actions {
        display: none;
    }
}

        @media print {
            .print-btn {
                display: none;
            }
            body {
                background: white;
            }
        }
    </style>
</head>
<body>

<div class="invoice">

    <!-- Logo + Invoice Info -->
    <div class="top-header">
        <img src="header-image-black.png" class="logo">

        <div class="invoice-info">
            <h3 style="margin:0;">Tax Invoice</h3>
            <p style="margin:2px 0;"><strong>Invoice No:</strong> INV<?= $row['booking_id']; ?></p>
            <p style="margin:2px 0;"><strong>Date:</strong> <?= date("d M Y"); ?></p>
        </div>
    </div>

    <div class="section-title">Billing Details</div>
    <p style="margin:3px 0;"><strong>Name:</strong> <?= htmlspecialchars($row['fullname']); ?></p>
    <p style="margin:3px 0;"><strong>Mobile:</strong> <?= htmlspecialchars($row['mobile']); ?></p>
    <p style="margin:3px 0;"><strong>Address:</strong>
        <?= htmlspecialchars($row['address']); ?>,
        <?= htmlspecialchars($row['city']); ?>,
        <?= htmlspecialchars($row['state']); ?> -
        <?= htmlspecialchars($row['pincode']); ?>
    </p>

    <div class="section-title">Order Summary</div>

    <table>
        <tr>
            <th>Description</th>
            <th>Time</th>
            <th>Status</th>
            <th class="right">Amount (₹)</th>
        </tr>
        <tr>
            <td><?= htmlspecialchars($row['turfs']); ?></td>
            <td><?= date("d M Y h:i A", strtotime($row['booking_time'])); ?></td>
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

    <!-- QR + Signature Row -->
    <div class="footer-row">

        <div class="qr">
            <img src="<?= $qrURL; ?>" alt="QR Code">
        </div>

        <div class="signature">
            <img src="sign.png">
            <p style="margin:2px 0;"><strong>Prince Antala</strong></p>
            <p style="margin:2px 0;">Authorized Signatory</p>
        </div>

    </div>

    <div class="print-btn">
        <button onclick="window.print()">Download / Print</button>
    </div>
  <div class="top-actions">
        <a href="index.php">Home</a>
        <a href="history.php" class="profile">History</a>
    </div>
</div>

</body>
</html>

