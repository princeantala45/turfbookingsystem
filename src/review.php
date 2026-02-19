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
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CUSTOMER REVIEWS | TURFBOOKING SYSTEM</title>
  <link rel="shortcut icon" href="./gallery/favicon.png" type="image/x-icon">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="turf.css">
  <link rel="stylesheet" href="output.css">
</head>

<body>
   <?php include "header.php"; ?>

<section>
        <div class="line-turf">
            <p>Home /</p>
            <p style="margin-left: 5px;"> Customer review</p>
        </div>
     </section>

  <!-- Page Heading -->
  <section class="py-10 text-center">
    <h2 class="text-3xl sm:text-4xl font-bold text-orange-600">What Our Customers Are Saying</h2>
  </section>

  <!-- Review Section -->
<section class="bg-gray-100 py-16 px-6">

  <!-- Review Cards Grid -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
    <!-- Review Card 1 -->
    <div class="bg-white rounded-2xl shadow-md p-6 pt-10 text-center hover:shadow-xl transition-all duration-300">
      <img src="./review-img/rohit.jpg" class="w-24 h-24 mx-auto rounded-full border-4 border-white shadow -mt-16" alt="Rohit Sharma">
      <h3 class="mt-6 font-semibold text-xl text-gray-800">Rohit Sharma</h3>
      <p class="mt-3 text-gray-600 text-sm">"The ability to view turf availability in real time is incredibly helpful. Everything is done online within minutes, and it works flawlessly."</p>
    </div>

    <!-- Review Card 2 -->
    <div class="bg-white rounded-2xl shadow-md p-6 pt-10 text-center hover:shadow-xl transition-all duration-300">
      <img src="./review-img/harmanpreet singh.jpg" class="w-24 h-24 mx-auto rounded-full border-4 border-white shadow -mt-16" alt="Harmanpreet Singh">
      <h3 class="mt-6 font-semibold text-xl text-gray-800">Harmanpreet Singh</h3>
      <p class="mt-3 text-gray-600 text-sm">"We organize regular corporate matches, and this system handles everything smoothly—from scheduling to payments."</p>
    </div>

    <!-- Review Card 3 -->
    <div class="bg-white rounded-2xl shadow-md p-6 pt-10 text-center hover:shadow-xl transition-all duration-300">
      <img src="./review-img/manu bhaker.jpg" class="w-24 h-24 mx-auto rounded-full border-4 border-white shadow -mt-16" alt="Manu Bhaker">
      <h3 class="mt-6 font-semibold text-xl text-gray-800">Manu Bhaker</h3>
      <p class="mt-3 text-gray-600 text-sm">"The platform is user-friendly and efficient. Booking a turf takes less than a minute. Ideal for casual players and serious teams."</p>
    </div>

    <!-- Review Card 4 -->
    <div class="bg-white rounded-2xl shadow-md p-6 pt-10 text-center hover:shadow-xl transition-all duration-300">
      <img src="./review-img/neeraj.avif" class="w-24 h-24 mx-auto rounded-full border-4 border-white shadow -mt-16" alt="Neeraj Chopra">
      <h3 class="mt-6 font-semibold text-xl text-gray-800">Neeraj Chopra</h3>
      <p class="mt-3 text-gray-600 text-sm">"This website has simplified our weekend football plans. No more calls or confusion—just select, book, and play."</p>
    </div>

    <!-- Review Card 5 -->
    <div class="bg-white rounded-2xl shadow-md p-6 pt-10 text-center hover:shadow-xl transition-all duration-300">
      <img src="./review-img/sun.jpg" class="w-24 h-24 mx-auto rounded-full border-4 border-white shadow -mt-16" alt="Sunil Chhetri">
      <h3 class="mt-6 font-semibold text-xl text-gray-800">Sunil Chhetri</h3>
      <p class="mt-3 text-gray-600 text-sm">"Real-time turf availability is a game changer. Booking is fast, simple, and reliable every time."</p>
    </div>

    <!-- Review Card 6 -->
    <div class="bg-white rounded-2xl shadow-md p-6 pt-10 text-center hover:shadow-xl transition-all duration-300">
      <img src="./review-img/sachin.jpeg" class="w-24 h-24 mx-auto rounded-full border-4 border-white shadow -mt-16" alt="Sachin Tendulkar">
      <h3 class="mt-6 font-semibold text-xl text-gray-800">Sachin Tendulkar</h3>
      <p class="mt-3 text-gray-600 text-sm">"Booking a turf has never been easier! I can check availability and book within minutes. Great experience every time."</p>
    </div>
  </div>
</section>

  <?php include "footer.php"; ?>

  <script src="all-animation.js"></script>
  <script src="main.js"></script>
</body>
</html>