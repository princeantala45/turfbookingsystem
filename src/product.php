<?php
session_start();
$alertScript = "";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "turfbookingsystem";

if (!isset($_SESSION['username'])) {
    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: "warning",
                title: "Login Required",
                text: "Please login first to access this page.",
                confirmButtonText: "OK"
            }).then(function() {
                window.location.href = "login.php";
            });
        </script>
    </body>
    </html>
    ';
    exit();
}


// Validate and sanitize cart session
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
} else {
    foreach ($_SESSION['cart'] as $key => $item) {
        if (!is_array($item) || !isset($item['product_id'], $item['qty'])) {
            unset($_SESSION['cart'][$key]);
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex array
}

// Connect to database
$conn = mysqli_connect("localhost", "root", "", "turfbookingsystem");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['add_to_cart'])) {
$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;
$qty = max(1, min(100, $qty));


    $found = false;

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_id'] == $product_id) {

            if ($item['qty'] < 100) {
                $item['qty'] = min(100, $item['qty'] + $qty);


                $alertScript = "
                Swal.fire({
                    icon: 'success',
                    title: 'Product Added to Cart!'
                }).then(function() {
                    window.location.href='product.php';
                });
                ";

            } else {

                $alertScript = "
                Swal.fire({
                    icon: 'warning',
                    title: 'Maximum quantity of 100 reached!'
                }).then(function() {
                    window.location.href='product.php';
                });
                ";
            }

            $found = true;
            break;
        }
    }
    unset($item);

    if (!$found) {
        $_SESSION['cart'][] = ['product_id' => $product_id, 'qty' => $qty];


        $alertScript = "
        Swal.fire({
            icon: 'success',
            title: 'Product Added to Cart!'
        }).then(function() {
            window.location.href='product.php';
        });
        ";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>OUR PRODUCTS | TURFBOOKING SYSTEM</title>
    <!-- ✅ Best Tailwind CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="input.css">
    <link rel="stylesheet" href="output.css">
    <link rel="stylesheet" href="turf.css">
    <link rel="stylesheet" href="product.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>    
    <link rel="shortcut icon" href="./gallery/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</head>

<body class="bg-gray-50 text-gray-800">

    <?php include "header.php"; ?>

    <section>
        <div class="line-turf">
            <p>Home /</p>
            <p style="margin-left: 5px;">Our Products</p>
        </div>
    </section>
    <section class="py-10">
        <div class="product-container max-w-7xl mx-auto px-4">
            <?php
            $sql = "SELECT * FROM product";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['product_id'];
                $name = htmlspecialchars($row['product_name']);
                $price = number_format($row['product_price']);
                $image = htmlspecialchars($row['product_image']);
                $availability = htmlspecialchars($row['product_availability']); // 👈 new field
echo '
<div class="product-card bg-white border border-gray-200 
            hover:border-2 hover:border-green-500 
            hover:shadow-xl 
            transition-all duration-300 rounded-2xl 
            flex flex-col overflow-hidden">

    
    <!-- Product Image -->
    <div class="bg-gray-50 flex items-center justify-center p-6 h-56">
        <img src="../' . $image . '" 
             alt="' . $name . '" 
             class="max-h-40 object-contain transition-transform duration-300 hover:scale-105">
    </div>

    <!-- Product Details -->
    <div class="flex flex-col flex-grow p-5 text-center">

        <!-- Product Name -->
        <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-2 line-clamp-2">
            ' . $name . '
        </h3>

        <!-- Availability -->
        <p class="text-sm mb-2 ' . 
            ($availability == "In Stock" 
                ? "text-green-600 font-medium" 
                : "text-red-500 font-medium") . '">
            ' . $availability . '
        </p>

        <!-- Price -->
        <p class="text-xl font-bold text-gray-900 mb-4">
            ₹' . $price . '
        </p>

<form method="post" class="mt-auto">
    <input type="hidden" name="product_id" value="' . $id . '">

    <!-- Quantity Selector -->
    <div class="flex items-center justify-center gap-3 mb-3">

        <button type="button"
            onclick="decrementQty(' . $id . ')"
            class="w-9 h-9 flex items-center justify-center 
                   border border-gray-300 rounded-md 
                   hover:bg-gray-100 transition">
            −
        </button>

        <input type="number" 
            id="qty_' . $id . '" 
            name="qty"
            value="1" 
            min="1" 
            max="100"
            class="w-14 text-center border border-gray-300 
                   rounded-md py-1 focus:outline-none focus:ring-2 focus:ring-green-500">

        <button type="button"
            onclick="incrementQty(' . $id . ')"
            class="w-9 h-9 flex items-center justify-center 
                   border border-gray-300 rounded-md 
                   hover:bg-gray-100 transition">
            +
        </button>

    </div>

<div class="pt-4 flex justify-center">
    <button type="submit" name="add_to_cart"  class="cssbuttons-io-button">
        Add to Cart
        <div class="icon1">
            <svg height="24" width="24" viewBox="0 0 24 24">
                <path d="M0 0h24v24H0z" fill="none"></path>
                <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                      fill="currentColor"></path>
            </svg>
        </div>
    </button>
</div>


</form>

    </div>
</div>';
    
      }
            ?>
        </div>
    </section>


    <?php include "footer.php"; ?>
    <script>
        const cards = document.querySelectorAll('.product-card');

        function revealCards() {
            cards.forEach(card => {
                const rect = card.getBoundingClientRect();
                if (rect.top < window.innerHeight - 50) {
                    card.classList.add('show');
                }
            });
        }

        window.addEventListener('scroll', revealCards);
        window.addEventListener('load', revealCards);
    </script>
  <script src="main.js"></script>

<?php if (!empty($alertScript)) : ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    <?php echo $alertScript; ?>
});
</script>
<?php endif; ?>

<script>
// Quantity increment
function incrementQty(id) {
    const input = document.getElementById("qty_" + id);
    if (!input) return;

    let value = parseInt(input.value) || 1;

    if (value < 100) {
        input.value = value + 1;
    }
}

// Quantity decrement
function decrementQty(id) {
    const input = document.getElementById("qty_" + id);
    if (!input) return;

    let value = parseInt(input.value) || 1;

    if (value > 1) {
        input.value = value - 1;
    }
}
</script>

</body>

</html>