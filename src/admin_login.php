<?php
session_start();

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "turfbookingsystem");

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Redirect if already logged in
if (isset($_SESSION['user'])) {
  header("Location: admin_dashboard.php");
  exit;
}

$error = "";

// Handle login form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) == 1) {
    $_SESSION['user'] = $username;
    header("Location: admin_dashboard.php");
    exit;
  } else {
    $error = "Invalid username or password.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>ADMIN LOGIN</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="shortcut icon" href="./gallery/favicon.png" type="image/x-icon">
</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-br from-blue-100 to-indigo-200">

  <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-sm transition-transform transform hover:scale-105 duration-300">
    <h2 class="text-3xl font-extrabold text-center text-blue-700 mb-6">Admin Login</h2>

    <?php if ($error): ?>
      <div class="bg-red-100 text-red-700 border border-red-300 p-3 rounded mb-4 text-sm">
        <?php echo $error; ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="space-y-5">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
        <input type="text" name="username" required class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none" />
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input type="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none" />
      </div>
      <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold transition duration-200">Login</button>
    </form>

    <div class="mt-6 text-center">
      <a href="index.php" class="text-sm text-blue-600 hover:text-blue-800 transition duration-150">← Back to Home</a>
    </div>
  </div>

</body>
</html>
