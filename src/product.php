<?php
session_start();

// Redirect if user not logged in
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Please login first.'); window.location.href='login.php';</script>";
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

// Add to cart logic
if (isset($_POST['add_to_cart'])) {
    $product_id = (int)$_POST['product_id'];
    $found = false;

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_id'] == $product_id) {
            if ($item['qty'] < 100) {
                $item['qty'] += 1;
                echo "<script>alert('Quantity updated!'); window.location.href='product.php';</script>";
            } else {
                echo "<script>alert('Maximum quantity of 100 reached!'); window.location.href='product.php';</script>";
            }
            $found = true;
            break;
        }
    }
    unset($item); // break reference

    if (!$found) {
        $_SESSION['cart'][] = ['product_id' => $product_id, 'qty' => 1];
        echo "<script>alert('Product added to cart!'); window.location.href='product.php';</script>";
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
<div class="product-card bg-white rounded-2xl shadow-md hover:shadow-lg transition p-5 text-center flex flex-col items-center">
    
    <!-- Product Image -->
    <div class="w-40 h-40 flex items-center justify-center mb-4">
        <img src="../' . $image . '" alt="' . $name . '" class="max-h-full object-contain rounded-lg">
    </div>

    <!-- Product Name -->
    <h3 class="font-semibold text-lg text-gray-800">' . $name . '</h3>

    <!-- Product Price -->
    <p class="text-blue-600 font-bold text-base mt-1">₹' . $price . '</p>

    <!-- Availability -->
    <p class="text-sm text-gray-500 mb-4">Availability: ' . $availability . '</p>

    <!-- Add to Cart Button -->
    <form method="post" class="w-full flex justify-center">
        <input type="hidden" name="product_id" value="' . $id . '">
        <button 
            type="submit" 
            name="add_to_cart" 
            class="inline-flex items-center gap-2 px-6 py-2.5 
                   rounded-xl bg-blue-600 hover:bg-blue-700 active:bg-blue-800
                   text-white font-medium text-sm sm:text-base
                   shadow-md hover:shadow-xl
                   focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2
                   transition-all duration-200 ease-in-out">
            <i class="fas fa-cart-plus"></i> Add to Cart
        </button>
    </form>
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
</body>

</html>