<?php
session_start();
if (!isset($_SESSION['username'])) {
  echo "
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Login Required',
            text: 'Please login first',
            confirmButtonText: 'OK'
        }).then(function() {
            window.location.href = 'login.php';
        });
    </script>
    ";
  exit();
}


include "db.php";


if (!isset($_SESSION['cart']))
  $_SESSION['cart'] = [];

// Quantity update
if (isset($_GET['update'])) {
  $id = (int) $_GET['id'];
  foreach ($_SESSION['cart'] as &$item) {
    if ($item['product_id'] == $id) {
      if ($_GET['update'] === 'inc' && $item['qty'] < 100)
        $item['qty']++;
      if ($_GET['update'] === 'dec' && $item['qty'] > 1)
        $item['qty']--;
    }
  }
  unset($item);
  header("Location: cart.php");
  exit();
}

// Remove item
if (isset($_GET['remove'])) {
  $remove_id = (int) $_GET['remove'];
  $_SESSION['cart'] = array_filter($_SESSION['cart'], fn($i) => $i['product_id'] != $remove_id);
  $_SESSION['cart'] = array_values($_SESSION['cart']);
  echo "<script>alert('Item removed'); window.location.href='cart.php';</script>";
  exit();
}

// Fetch product details
$cart_products = [];
$total = $sgst = $cgst = $grand_total = 0;

if (!empty($_SESSION['cart'])) {
  $ids_array = array_column($_SESSION['cart'], 'product_id');
  if (!empty($ids_array)) {
    $ids = implode(',', $ids_array);
    $quantities = array_column($_SESSION['cart'], 'qty', 'product_id');

    $result = mysqli_query($conn, "SELECT * FROM product WHERE product_id IN ($ids)");
    while ($row = mysqli_fetch_assoc($result)) {
      $qty = $quantities[$row['product_id']];
      $row['qty'] = $qty;
      $row['total'] = $row['product_price'] * $qty;
      $cart_products[] = $row;
      $total += $row['total'];
    }

    $sgst = round($total * 0.09, 2);
    $cgst = round($total * 0.09, 2);
    $grand_total = $total + $sgst + $cgst;
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>CART | TURFBOOKING SYSTEM</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="input.css">
  <link rel="stylesheet" href="output.css">
  <link rel="stylesheet" href="turf.css">
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="shortcut icon" href="./gallery/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body class="bg-gray-50">
  <?php include "header.php"; ?>

  <section>
    <div class="line-turf">
      <p>Home /</p>
      <p style="margin-left: 5px;"> Cart</p>
    </div>
  </section>
  <div class="max-w-7xl mx-auto py-10 px-4">
    <h2 class="text-3xl font-bold text-center text-green-700 mb-8">🛒 Your Cart</h2>

    <?php if (empty($cart_products)): ?>
      <div class="text-center bg-white p-10 shadow rounded">
        <p class="text-gray-600">Cart is empty</p>
        <div class="pt-4 flex justify-center">
          <a href="product.php">
            <button type="submit" name="submit" class="cssbuttons-io-button">
              Browse Product
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
    <?php else: ?>
      <div class="grid md:grid-cols-3 gap-6">
        <div class="md:col-span-2 space-y-4">
          <?php foreach ($cart_products as $item): ?>
            <div class="flex items-center gap-4 bg-white p-4 rounded shadow">
              <img src="../<?= htmlspecialchars($item['product_image']) ?>"
                class="h-20 w-20 object-contain border rounded" />
              <div class="flex-1">
                <h3 class="text-lg font-semibold"><?= htmlspecialchars($item['product_name']) ?></h3>
                <p class="text-sm text-gray-500">₹<?= number_format($item['product_price']) ?> each</p>
                <div class="mt-2 flex items-center gap-2">
                  <a href="?update=dec&id=<?= $item['product_id'] ?>" class="bg-gray-300 px-2 rounded">−</a>
                  <span class="px-3 font-bold"><?= $item['qty'] ?></span>
                  <a href="?update=inc&id=<?= $item['product_id'] ?>" class="bg-gray-300 px-2 rounded">+</a>
                </div>
              </div>
              <div class="text-right">
                <p class="text-green-600 font-bold">₹<?= number_format($item['total']) ?></p>
                <a href="?remove=<?= $item['product_id'] ?>" class="text-red-500 text-sm block mt-1"><i
                    class="fas fa-trash"></i> Remove</a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="bg-white p-6 rounded shadow h-fit">
          <h3 class="text-lg font-bold mb-4">Order Summary</h3>
          <div class="flex justify-between text-sm mb-1">
            <span>Subtotal</span><span>₹<?= number_format($total, 2) ?></span></div>
          <div class="flex justify-between text-sm mb-1"><span>SGST
              (9%)</span><span>₹<?= number_format($sgst, 2) ?></span></div>
          <div class="flex justify-between text-sm mb-2"><span>CGST
              (9%)</span><span>₹<?= number_format($cgst, 2) ?></span></div>
          <div class="flex justify-between font-bold text-lg border-t pt-2"><span>Total</span><span
              class="text-green-700">₹<?= number_format($grand_total, 2) ?></span></div>
          <div class="mt-6 flex flex-col gap-3">
            <div class="pt-4 flex justify-center">
              <a href="checkout.php">
                <button type="submit" name="add_to_cart" class="cssbuttons-io-button">
                  Checkout
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
            <div class="pt-4 flex justify-center">
              <a href="product.php">
                <button type="submit" name="add_to_cart" class="cssbuttons-io-button">
                  Continue Shopping
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
      </div>
    <?php endif; ?>
  </div>

  <?php include "footer.php"; ?>
  <script src="all-animation.js"></script>
  <script src="main.js"></script>
</body>

</html>