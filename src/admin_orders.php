<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// DB connect
$conn = mysqli_connect("localhost", "root", "", "turfbookingsystem");
if (!$conn) {
    die("DB Connection failed: " . mysqli_connect_error());
}

// LEFT JOIN rakhi che ke username na male to pan order dekhay
$sql = "
  SELECT ps.id,
         COALESCE(s.username,'-') AS username,
         ps.product_names,
         ps.grand_total,
         ps.payment_method,
         ps.payment_ref,
         ps.created_at
  FROM product_shopping ps
  LEFT JOIN signup s ON ps.user_id = s.user_id
  ORDER BY ps.id DESC
";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die('Query error: ' . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ADMIN | Orders</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;background:#f6f7fb;color:#1f2937;margin:0}
    .wrap{max-width:1100px;margin:24px auto;padding:0 16px}
    h1{font-size:22px;margin:0 0 14px;color:#1d4ed8}
    .card{background:#fff;border:1px solid #e5e7eb;border-radius:14px;padding:18px;box-shadow:0 1px 2px rgba(0,0,0,0.04)}
    table{width:100%;border-collapse:collapse}
    th,td{border:1px solid #e5e7eb;padding:10px;text-align:left;font-size:14px;vertical-align:top}
    th{background:#f3f4f6}
    .back{display:inline-block;margin-bottom:10px;padding:8px 12px;border:1px solid #1d4ed8;color:#1d4ed8;border-radius:10px;text-decoration:none}
    .back:hover{background:#eef2ff}
    .mono{font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,monospace}
  </style>
</head>
<body>
  <div class="wrap">
    <a class="back" href="admin_dashboard.php">⬅ Back to Dashboard</a>
    <div class="card">
      <h1>📦 All Orders</h1>

      <?php if(mysqli_num_rows($result) > 0): ?>
        <div style="overflow:auto">
          <table>
            <thead>
              <tr>
                <th>#</th>
                <th>Username</th>
                <th>Products</th>
                <th>Amount</th>
                <th>Payment</th>
                <th>Reference</th>
                <th>Date</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                  <td><?= (int)$row['id'] ?></td>
                  <td><?= htmlspecialchars($row['username']) ?></td>
                  <td><?= nl2br(htmlspecialchars($row['product_names'])) ?></td>
                  <td>₹<?= number_format((float)$row['grand_total'], 2) ?></td>
                  <td><?= strtoupper(htmlspecialchars($row['payment_method'])) ?></td>
                  <td class="mono"><?= htmlspecialchars($row['payment_ref']) ?></td>
                  <td><?= htmlspecialchars($row['created_at']) ?></td>
                  <td>
                    <?php
                      $createdAt = strtotime($row['created_at']);
                      $daysPassed = $createdAt ? floor((time() - $createdAt) / 86400) : 0;
                      $remaining = max(10 - $daysPassed, 0);
                      echo $remaining > 0
                        ? "🚚 {$remaining} days left"
                        : "✅ Delivered";
                    ?>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <p>No orders found.</p>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
