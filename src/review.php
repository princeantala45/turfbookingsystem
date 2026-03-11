<?php
session_start();

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
<section class="bg-gradient-to-b from-gray-50 to-gray-200 py-20 px-6">
  <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-16 gap-x-8">
    
    <div class="group bg-white rounded-3xl shadow-sm border border-gray-100 p-8 pt-12 text-center hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 relative">
      <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2">
        <img src="./review-img/rohit.jpg" class="w-24 h-24 rounded-full border-4 border-white shadow-lg object-cover group-hover:scale-110 transition-transform duration-500" alt="Rohit Sharma">
      </div>
      <div class="flex justify-center mb-2 text-yellow-400">
        ★★★★★
      </div>
      <h3 class="font-bold text-xl text-gray-800 tracking-tight">Rohit Sharma</h3>
      <p class="mt-4 text-gray-600 leading-relaxed italic">"The ability to view turf availability in real time is incredibly helpful. Everything is done online within minutes, and it works flawlessly."</p>
    </div>

    <div class="group bg-white rounded-3xl shadow-sm border border-gray-100 p-8 pt-12 text-center hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 relative">
      <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2">
        <img src="./review-img/harmanpreet singh.jpg" class="w-24 h-24 rounded-full border-4 border-white shadow-lg object-cover group-hover:scale-110 transition-transform duration-500" alt="Harmanpreet Singh">
      </div>
      <div class="flex justify-center mb-2 text-yellow-400">
        ★★★★★
      </div>
      <h3 class="font-bold text-xl text-gray-800 tracking-tight">Harmanpreet Singh</h3>
      <p class="mt-4 text-gray-600 leading-relaxed italic">"We organize regular corporate matches, and this system handles everything smoothly—from scheduling to payments."</p>
    </div>

    <div class="group bg-white rounded-3xl shadow-sm border border-gray-100 p-8 pt-12 text-center hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 relative">
      <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2">
        <img src="./review-img/manu bhaker.jpg" class="w-24 h-24 rounded-full border-4 border-white shadow-lg object-cover group-hover:scale-110 transition-transform duration-500" alt="Manu Bhaker">
      </div>
      <div class="flex justify-center mb-2 text-yellow-400">
        ★★★★★
      </div>
      <h3 class="font-bold text-xl text-gray-800 tracking-tight">Manu Bhaker</h3>
      <p class="mt-4 text-gray-600 leading-relaxed italic">"The platform is user-friendly and efficient. Booking a turf takes less than a minute. Ideal for casual players and serious teams."</p>
    </div>

    <div class="group bg-white rounded-3xl shadow-sm border border-gray-100 p-8 pt-12 text-center hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 relative">
      <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2">
        <img src="./review-img/neeraj.avif" class="w-24 h-24 rounded-full border-4 border-white shadow-lg object-cover group-hover:scale-110 transition-transform duration-500" alt="Neeraj Chopra">
      </div>
      <div class="flex justify-center mb-2 text-yellow-400">
        ★★★★★
      </div>
      <h3 class="font-bold text-xl text-gray-800 tracking-tight">Neeraj Chopra</h3>
      <p class="mt-4 text-gray-600 leading-relaxed italic">"This website has simplified our weekend football plans. No more calls or confusion—just select, book, and play."</p>
    </div>

    <div class="group bg-white rounded-3xl shadow-sm border border-gray-100 p-8 pt-12 text-center hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 relative">
      <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2">
        <img src="./review-img/sun.jpg" class="w-24 h-24 rounded-full border-4 border-white shadow-lg object-cover group-hover:scale-110 transition-transform duration-500" alt="Sunil Chhetri">
      </div>
      <div class="flex justify-center mb-2 text-yellow-400">
        ★★★★★
      </div>
      <h3 class="font-bold text-xl text-gray-800 tracking-tight">Sunil Chhetri</h3>
      <p class="mt-4 text-gray-600 leading-relaxed italic">"Real-time turf availability is a game changer. Booking is fast, simple, and reliable every time."</p>
    </div>

    <div class="group bg-white rounded-3xl shadow-sm border border-gray-100 p-8 pt-12 text-center hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 relative">
      <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2">
        <img src="./review-img/sachin.jpeg" class="w-24 h-24 rounded-full border-4 border-white shadow-lg object-cover group-hover:scale-110 transition-transform duration-500" alt="Sachin Tendulkar">
      </div>
      <div class="flex justify-center mb-2 text-yellow-400">
        ★★★★★
      </div>
      <h3 class="font-bold text-xl text-gray-800 tracking-tight">Sachin Tendulkar</h3>
      <p class="mt-4 text-gray-600 leading-relaxed italic">"Booking a turf has never been easier! I can check availability and book within minutes. Great experience every time."</p>
    </div>

  </div>
</section>

  <?php include "footer.php"; ?>

  <script src="all-animation.js"></script>
  <script src="main.js"></script>
</body>
</html>