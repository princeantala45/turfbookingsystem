<?php
session_start();
$alertScript = "";

if (!isset($_SESSION['username'])) {

  $alertScript = "
  Swal.fire({
    icon: 'warning',
    title: 'Login Required',
    text: 'Please login first.'
  }).then(() => {
    window.location.href='login.php';
  });
  ";

}




include "db.php";



$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$total = 0;
$products = [];
$product_names = [];

if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
  $ids = implode(",", array_map(fn($item) => (int)$item['product_id'], $_SESSION['cart']));
  $qty_map = array_column($_SESSION['cart'], 'qty', 'product_id');
  $result = mysqli_query($conn, "SELECT * FROM product WHERE product_id IN ($ids)");
  while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['product_id'];
    $qty = $qty_map[$id] ?? 1;

    $row['qty'] = $qty;
    $row['total_price'] = $row['product_price'] * $qty;

    $products[] = $row;
    $product_names[] = $row['product_name'] . " (x" . $qty . ")";
    $total += $row['total_price'];
  }
} else {
$alertScript = " 
Swal.fire({
  icon: 'warning',
  title: 'Cart Empty',
  text: 'Your cart is empty!'
}).then(() => {
  window.location.href='product.php';
});
";

}

$sgst = $total * 0.09;
$cgst = $total * 0.09;
$grand_total = $total + $sgst + $cgst;
$all_product_names = implode(", ", $product_names);

// --------- Order process ---------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fullname = $_POST['fullname'];
  $email    = $_POST['email'];
  $mobile   = $_POST['mobile'];
  $state    = $_POST['state'];
  $city     = $_POST['city'];
  $pincode  = $_POST['pincode'];
  $address  = $_POST['address'];
  $payment_method = $_POST['payment_method'];
  $payment_ref = "Product-". rand(1000, 9999);

  // Hidden fields માંથી values
  $subtotal = $_POST['subtotal'];
  $sgst     = $_POST['sgst'];
  $cgst     = $_POST['cgst'];
  $grand_total = $_POST['grand_total'];
  $product_names = $_POST['product_names'];

  $sql = "INSERT INTO product_shopping 
    (user_id, fullname, email, mobile, state, city, pincode, address, product_names, subtotal, sgst, cgst, grand_total, payment_method, payment_ref) 
    VALUES 
    ('$user_id','$fullname','$email','$mobile','$state','$city','$pincode','$address','$product_names','$subtotal','$sgst','$cgst','$grand_total','$payment_method','$payment_ref')";

if (mysqli_query($conn, $sql)) {
    $order_id = mysqli_insert_id($conn);

    // Save Card
    if ($payment_method === 'card') {
      $cardnumber = $_POST['cardnumber'];
      $cardholdername = $_POST['cardholdername'];
      $expiry = $_POST['expiry'];
      $cvv = $_POST['cvv'];

      mysqli_query($conn, "INSERT INTO product_card_data 
        (user_id, username, cardholdername, cardnumber, expiry, cvv, product, payment_ref) 
        VALUES 
        ('$user_id','$username','$cardholdername','$cardnumber','$expiry','$cvv','$product_names','$payment_ref')");
    }

    // Save UPI
    if ($payment_method === 'upi') {
      $upiid = $_POST['upi'];
      mysqli_query($conn, "INSERT INTO product_upi_data 
        (user_id, username, product,upiid, payment_ref) 
        VALUES ('$user_id','$username','$product_names','$upiid' ,'$payment_ref')");
    }
unset($_SESSION['cart']);
$alertScript = "
Swal.fire({
  icon: 'success',
  title: 'Order Placed!',
  html: 'Products : <b>$product_names</b><br>Payment Ref: <b>$payment_ref</b>'
}).then(() => {
  window.location.href='product_history.php';
});
";

  } else {
    echo "Error: " . mysqli_error($conn);
    exit;
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>CHECKOUT | TURFBOOKING SYSTEM</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="input.css">
  <link rel="stylesheet" href="output.css">
  <link rel="stylesheet" href="turf.css">
  <link rel="stylesheet" href="style.css">
  <link rel="shortcut icon" href="./gallery/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: scale(0.95);
      }

      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    .animate-fadeIn {
      animation: fadeIn 0.3s ease-out;
    }
  </style>
</head>

<body class="bg-gray-100">
  <?php include "header.php"; ?>
<section>
        <div class="line-turf">
            <p>Home /</p>
            <p style="margin-left: 5px;"> Checkout</p>
        </div>
     </section>
  <div class="max-w-4xl mx-auto mt-10 mb-20 p-6 rounded-2xl bg-white shadow-xl animate-fadeIn">
    <h2 class="text-3xl font-bold text-center text-indigo-700 mb-6">🧾 Checkout Summary</h2>

    <!-- Cart Summary -->
    <div class="space-y-4 mb-8 border-b pb-6">
      <?php foreach ($products as $product): ?>
        <div class="flex justify-between items-center text-sm md:text-base">
          <span><?= htmlspecialchars($product['product_name']) ?> (x<?= $product['qty'] ?>)</span>
          <span class="font-semibold text-green-700">₹<?= number_format($product['total_price'], 2) ?></span>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Price Breakdown -->
    <div class="mb-6 text-right space-y-1">
      <p>Subtotal: ₹<?= number_format($total, 2) ?></p>
      <p>SGST (9%): ₹<?= number_format($sgst, 2) ?></p>
      <p>CGST (9%): ₹<?= number_format($cgst, 2) ?></p>
      <p class="font-bold text-lg text-green-800 border-t pt-2">Grand Total: ₹<?= number_format($grand_total, 2) ?></p>
    </div>

    <!-- Checkout Form -->
    <form id="checkoutForm" action="" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4" novalidate>
      <input type="text" name="fullname" id="fullname"
        placeholder="Full Name"
        required
        class="border p-3 rounded focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
"
        title="Full name must contain only alphabets" />

      <input type="email" name="email" style="text-transform:lowercase;" placeholder="Email" id="email" required class="border p-3 rounded focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
">
      <input type="tel" name="mobile" id="mobile" placeholder="Mobile Number" required maxlength="10" class="border p-3 rounded focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
">
      <input type="text" name="state" id="state" placeholder="State" required class="border p-3 rounded focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
">
      <input type="text" name="city" id="city" placeholder="City" required class="border p-3 rounded focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
">
      <input type="text" name="pincode" id="pincode" placeholder="Pincode" required maxlength="6" class="border p-3 rounded focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
">
      <textarea name="address" placeholder="Address" id="address" required class="border p-3 rounded md:col-span-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
"></textarea>

      <select name="payment_method" id="payment_method" required class="border p-3 rounded md:col-span-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
">
        <option value="">Select Payment Method</option>
        <option value="card">Card</option>
        <option value="upi">UPI</option>
        <option value="cod">Cash on Delivery</option>
      </select>

      <!-- Card Fields -->
      <div id="card_fields" class="hidden md:col-span-2 space-y-3">
        <input type="text" name="cardnumber" id="cardnumber" required placeholder="Card Number" maxlength="12" class="w-full px-4 py-3 border rounded focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
" />
        <input type="text" name="cardholdername" id="cardholdername" required placeholder="Cardholder Name" class="w-full px-4 py-3 border rounded focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
" />
        <input type="text" name="expiry" id="expiry" placeholder="Expiry (MM/YY)" required maxlength="5" class="w-full px-4 py-3 border rounded focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
" />
        <input type="text" name="cvv" id="cvv" placeholder="CVV" required maxlength="3" class="w-full px-4 py-3 border rounded focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
" />
      </div>

      <!-- UPI Fields -->
      <div id="upi_fields" class="hidden md:col-span-2">
        <input type="text" name="upi" required id="upi" placeholder="UPI ID" class="w-full px-4 py-3 border rounded focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500
" />
      </div>

      <!-- Hidden -->
      <input type="hidden" name="subtotal" value="<?= $total ?>">
      <input type="hidden" name="sgst" value="<?= $sgst ?>">
      <input type="hidden" name="cgst" value="<?= $cgst ?>">
      <input type="hidden" name="grand_total" value="<?= $grand_total ?>">
      <input type="hidden" name="product_names" value="<?= htmlspecialchars($all_product_names) ?>">

      <div class="md:col-span-2 text-center mt-4">
<div class="pt-4 flex justify-center">
      <button type="submit" name="add_to_cart"  class="cssbuttons-io-button">
        Checkout
        <div class="icon1">
            <svg height="24" width="24" viewBox="0 0 24 24">
                <path d="M0 0h24v24H0z" fill="none"></path>
                <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                      fill="currentColor"></path>
            </svg>
        </div>
    </button>
</div>
      </div>
    </form>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const form = document.getElementById('checkoutForm');
      const paymentMethod = document.getElementById('payment_method');
      const cardFields = document.getElementById('card_fields');
      const upiFields = document.getElementById('upi_fields');

      const fullname = document.getElementById('fullname');
      const state = document.getElementById('state');
      const city = document.getElementById('city');
      const mobile = document.getElementById('mobile');
      const pincode = document.getElementById('pincode');
      const cardnumber = document.getElementById('cardnumber');
      const cardholdername = document.getElementById('cardholdername');
      const expiry = document.getElementById('expiry');
      const cvv = document.getElementById('cvv');
      const upi = document.getElementById('upi');

      // --- Input restrictions ---
      const onlyLetters = el => el.addEventListener('input', () => el.value = el.value.replace(/[^a-zA-Z\s]/g, ''));
      const onlyDigits = (el, max) => el.addEventListener('input', () => {
        el.value = el.value.replace(/[^0-9]/g, '');
        if (max && el.value.length > max) el.value = el.value.slice(0, max);
      });

      onlyLetters(fullname);
      onlyLetters(state);
      onlyLetters(city);
      onlyLetters(cardholdername);
      onlyDigits(mobile, 10);
      onlyDigits(pincode, 6);
      onlyDigits(cardnumber, 12);
      onlyDigits(cvv, 3);

      if (expiry) {
        expiry.addEventListener('input', () => {
          let val = expiry.value.replace(/[^\d]/g, '');
          if (val.length > 2) val = val.slice(0, 2) + '/' + val.slice(2, 4);
          expiry.value = val.slice(0, 5);
        });
      }

      // Show/Hide payment fields
      paymentMethod.addEventListener('change', () => {
        [cardFields, upiFields].forEach(f => {
          f.classList.add('hidden');
          f.querySelectorAll('input').forEach(i => i.removeAttribute('required'));
        });
        if (paymentMethod.value === 'card') {
          cardFields.classList.remove('hidden');
          cardFields.querySelectorAll('input').forEach(i => i.setAttribute('required', ''));
        }
        if (paymentMethod.value === 'upi') {
          upiFields.classList.remove('hidden');
          upiFields.querySelectorAll('input').forEach(i => i.setAttribute('required', ''));
        }
      });

      // --- Form Validation ---
      form.addEventListener('submit', e => {
        const required = ['fullname', 'email', 'mobile', 'state', 'city', 'pincode', 'address', 'payment_method'];
        for (let name of required) {
          const el = form.elements[name];
          if (!el?.value.trim()) {
            Swal.fire({
  icon: 'warning',
  title: 'Incomplete Form',
  text: 'Please fill all the fields!'
});
            el?.focus();
            e.preventDefault();
            return;
          }
        }

        if (mobile.value.length !== 10) {
          Swal.fire({
  icon: 'warning',
  title: 'Invalid Mobile',
  text: 'Mobile must be 10 digits!'
});

          mobile.focus();
          e.preventDefault();
          return;
        }

        if (!/^[A-Za-z\s]+$/.test(city.value)) {
          Swal.fire({
  icon: 'warning',
  title: 'Invalid City',
  text: 'City must contain only alphabets!'
});

          city.focus();
          e.preventDefault();
          return;
        }

        if (paymentMethod.value === 'card') {
          const [m, y] = expiry.value.split('/');
          if (!m || !y || +m < 1 || +m > 12) {
            Swal.fire({
  icon: 'warning',
  title: 'Invalid Expiry Date',
  text: 'Enter valid expiry in MM/YY format.'
});

            expiry.focus();
            e.preventDefault();
            return;
          }
          const expDate = new Date(`20${y}`, m - 1, 1);
          const today = new Date();
          today.setDate(1);
          if (expDate < today) {
            Swal.fire({
  icon: 'error',
  title: 'Expired Card',
  text: 'Card expiry cannot be in the past!'
});

            expiry.focus();
            e.preventDefault();
            return;
          }
        }

        if (paymentMethod.value === 'upi') {
          const upiRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z]+$/;
          if (!upi.value.trim() || !upiRegex.test(upi.value)) {
            Swal.fire({
  icon: 'error',
  title: 'Invalid UPI',
  text: 'Enter valid UPI ID (e.g., prince@upi)'
});

            upi.focus();
            e.preventDefault();
            return;
          }
        }
      });
    });
  </script>
  <script src="all-animation.js"></script>
  <script src="main.js"></script>
  <?php include "footer.php"; ?>
  <?php if (!empty($alertScript)) : ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
  <?php echo $alertScript; ?>
});
</script>
<?php endif; ?>

</body>

</html>