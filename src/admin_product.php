<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "turfbookingsystem";

$conn = mysqli_connect($host, $user, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function uploadImage($file) {
    $targetDir = "../product-img/";
    $fileName = time() . "_" . basename($file["name"]);
    $targetFile = $targetDir . $fileName;
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return "product-img/" . $fileName; // store relative path
    }
    return null;
}


// Flags for JS alerts
$successMessage = "";

// Insert
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $product_availability = $_POST['product_availability'] ?? ''; 
    $image = uploadImage($_FILES['image']);

    $query = "INSERT INTO product (product_name, product_price, product_image, product_availability) 
              VALUES ('$name', '$price', '$image', '$product_availability')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Product added successfully!'); window.location.href='admin_product.php';</script>";
        exit;
    } else {
        echo "Insert Error: " . mysqli_error($conn);
    }
}

// Update
if (isset($_POST['update_product'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $product_availability = $_POST['product_availability'];

    $updateQuery = "UPDATE product 
                    SET product_name='$name', 
                        product_price='$price', 
                        product_availability='$product_availability'";

    if (!empty($_FILES['image']['name'])) {
        $image = uploadImage($_FILES['image']);
        if ($image) {
            $updateQuery .= ", product_image='$image'";
        }
    }

    $updateQuery .= " WHERE product_id=$id";

    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Product updated successfully!'); window.location.href='admin_product.php';</script>";
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}


// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM product WHERE product_id=$id");
    echo "<script>alert('Product deleted successfully!'); window.location.href='admin_product.php';</script>";
    exit;
}

// Fetch data
$products = mysqli_query($conn, "SELECT * FROM product");
$edit_id = $_GET['edit'] ?? null;
$edit_data = null;

if ($edit_id) {
    $edit_query = mysqli_query($conn, "SELECT * FROM product WHERE product_id=$edit_id");
    $edit_data = mysqli_fetch_assoc($edit_query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>MANAGE PRODUCTS | ADMIN</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <link rel="shortcut icon" href="./gallery/favicon.png" type="image/x-icon">
</head>
<body class="bg-gray-100 text-gray-800">

<div class="max-w-6xl mx-auto py-10 px-4">
  <div class="bg-white p-6 rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-6 text-center">🛒 Manage Products</h1>

    <!-- Product Form -->
    <form method="post" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-10">
  <input type="hidden" name="id" value="<?= $edit_data['product_id'] ?? '' ?>">
  
  <input type="text" name="name" placeholder="Product Name" required 
         value="<?= $edit_data['product_name'] ?? '' ?>" 
         class="border px-3 py-2 rounded">
         
  <input type="number" name="price" placeholder="Price" required 
         value="<?= $edit_data['product_price'] ?? '' ?>" 
         class="border px-3 py-2 rounded">
         
  <input type="file" name="image" accept="image/*" 
         class="border px-3 py-2 rounded">

  <!-- Availability input box --><!-- Availability input box -->
<input type="text" name="product_availability" placeholder="Availability (e.g. In Stock)" 
       value="<?= $edit_data['product_availability'] ?? '' ?>" 
       class="border px-3 py-2 rounded">


  <?php if ($edit_data): ?>
    <button name="update_product" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-4 py-2 rounded">
      Update
    </button>
  <?php else: ?>
    <button type="submit" name="add_product" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded">
      Add
    </button>
  <?php endif; ?>
</form>


    <!-- Product Table -->
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm text-left bg-white border border-gray-200 rounded">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="py-2 px-4 border">Product Image</th>
            <th class="py-2 px-4 border">Product Name</th>
            <th class="py-2 px-4 border">Product Price</th>
            <th class="py-2 px-4 border text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($products)) : ?>
            <tr class="hover:bg-gray-50">
              <td class="py-2 px-4 border text-center">
                <?php if (!empty($row['product_image'])): ?>
                  <img src="../<?= $row['product_image'] ?>" alt="Product Image" class="h-14 mx-auto object-contain">
                <?php else: ?>
                  <span class="text-gray-400 italic">No image</span>
                <?php endif; ?>
              </td>
              <td class="py-2 px-4 border"><?= htmlspecialchars($row['product_name']) ?></td>
              <td class="py-2 px-4 border font-semibold">₹<?= htmlspecialchars($row['product_price']) ?>/-</td>
              <td class="py-2 px-4 border text-center">
                <a href="?edit=<?= $row['product_id'] ?>" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs mr-1 inline-flex items-center">
                  <i class="fas fa-pen mr-1"></i> Edit
                </a>
                <a href="?delete=<?= $row['product_id'] ?>" onclick="return confirm('Delete this product?')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs inline-flex items-center">
                  <i class="fas fa-trash mr-1"></i> Delete
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <div class="text-center mt-6">
      <a href="admin_dashboard.php" class="text-indigo-600 hover:underline">← Back to Dashboard</a>
    </div>
  </div>
</div>

</body>
</html>
