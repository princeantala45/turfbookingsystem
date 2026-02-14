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
  <link href="./output.css" rel="stylesheet">
  <link rel="stylesheet" href="turf.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="shortcut icon" href="./gallery/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="style.css">
  <title>ALL TURFS | TURFBOOKING SYSTEM</title>
</head>

<body>
  <?php include "header.php" ?>

  <section>
    <div class="line-turf">
      <p>Home /</p>
      <p style="margin-left: 5px;"> Our Turfs</p>
    </div>
  </section>

  <section class="turf-header">
    <h2 class="text-2xl sm:text-3xl font-bold text-center tracking-wide" style="color: rgb(212, 120, 1);">
      Book Your Turf
    </h2>
  </section>

  <section>
    <div class="turfs">
      <!-- Archery -->
      <div class="t1 relative 
            bg-white rounded-xl overflow-hidden
            border-2 border-transparent
            shadow-md
            transition-all duration-1000
            hover:border-green-500
            hover:-translate-y-2
            hover:shadow-2xl">

        <div style="position:absolute; top:8px; right:8px; z-index:999; background:#22c55e; color:white; font-size:12px; font-weight:bold; padding:2px 6px; border-radius:4px;">15% OFF</div>
        <a href="archery.php">
          <img src="./turf-img/archery.jpg" alt="">
        </a>
        <h5>Archery Turf</h5>
        <p>₹150 (per hours)</p>
        <a href="archery.php"><button class="button-89">See More...</button></a>
      </div>

      <!-- Badminton -->
      <div class="t1 relative 
            bg-white rounded-xl overflow-hidden
            border-2 border-transparent
            shadow-md
            transition-all duration-1000
            hover:border-green-500
            hover:-translate-y-2
            hover:shadow-2xl">

        <div style="position:absolute; top:8px; right:8px; z-index:999; background:#22c55e; color:white; font-size:12px; font-weight:bold; padding:2px 6px; border-radius:4px;">15% OFF</div>
        <a href="badminton.php">
          <img src="./turf-img/badminton.jpg" alt="">
        </a>
        <h5>Badminton Turf</h5>
        <p>₹800 (per hours)</p>
        <a href="badminton.php"><button class="button-89">See More...</button></a>
      </div>

      <!-- Baseball -->
      <div class="t1 relative 
            bg-white rounded-xl overflow-hidden
            border-2 border-transparent
            shadow-md
            transition-all duration-1000
            hover:border-green-500
            hover:-translate-y-2
            hover:shadow-2xl">

        <div style="position:absolute; top:8px; right:8px; z-index:999; background:#22c55e; color:white; font-size:12px; font-weight:bold; padding:2px 6px; border-radius:4px;">15% OFF</div>
        <a href="baseball.php">
          <img src="./turf-img/baseball.jpg" alt="">
        </a>
        <h5>Baseball Turf</h5>
        <p>₹500 (per hours)</p>
        <a href="baseball.php"><button class="button-89">See More...</button></a>
      </div>

      <!-- Basketball -->
      <div class="t1 relative 
            bg-white rounded-xl overflow-hidden
            border-2 border-transparent
            shadow-md
            transition-all duration-1000
            hover:border-green-500
            hover:-translate-y-2
            hover:shadow-2xl">

        <div style="position:absolute; top:8px; right:8px; z-index:999; background:#22c55e; color:white; font-size:12px; font-weight:bold; padding:2px 6px; border-radius:4px;">15% OFF</div>
        <a href="basketball.php">
          <img src="./turf-img/basketball-new.jpg" alt="">
        </a>
        <h5>Basketball Turf</h5>
        <p>₹450 (per hours)</p>
        <a href="basketball.php"><button class="button-89">See More...</button></a>
      </div>

      <!-- Cricket (HOT) -->
      <div class="t1 relative 
            bg-white rounded-xl overflow-hidden
            border-2 border-transparent
            shadow-md
            transition-all duration-1000
            hover:border-green-500
            hover:-translate-y-2
            hover:shadow-2xl">

        <!-- HOT on left -->
        <div style="position:absolute; top:8px; left:8px; z-index:999; background:#dc2626; color:white; font-size:12px; font-weight:bold; padding:2px 6px; border-radius:4px;">HOT</div>
        <!-- 15% OFF on right -->
        <div style="position:absolute; top:8px; right:8px; z-index:999; background:#22c55e; color:white; font-size:12px; font-weight:bold; padding:2px 6px; border-radius:4px;">15% OFF</div>
        <a href="cricket.php">
          <img src="./turf-img/cricke.jpg" alt="">
        </a>
        <h5>Cricket Turf</h5>
        <p>₹1000 (per hours)</p>
        <a href="cricket.php"><button class="button-89">See More...</button></a>
      </div>

      
      <!-- Football (HOT) -->
      <div class="t1 relative 
            bg-white rounded-xl overflow-hidden
            border-2 border-transparent
            shadow-md
            transition-all duration-1000
            hover:border-green-500
            hover:-translate-y-2
            hover:shadow-2xl">

        <!-- HOT on left -->
        <div style="position:absolute; top:8px; left:8px; z-index:999; background:#dc2626; color:white; font-size:12px; font-weight:bold; padding:2px 6px; border-radius:4px;">HOT</div>
        <!-- 15% OFF on right -->
        <div style="position:absolute; top:8px; right:8px; z-index:999; background:#22c55e; color:white; font-size:12px; font-weight:bold; padding:2px 6px; border-radius:4px;">15% OFF</div>
        <a href="football.php">
          <img src="./turf-img/football-new.png" alt="">

        </a>
        <h5>Football Turf</h5>
        <p>₹500 (per hours)</p>
        <a href="football.php"><button class="button-89">See More...</button></a>
      </div>

      <!-- Golf -->
      <div class="t1 relative 
            bg-white rounded-xl overflow-hidden
            border-2 border-transparent
            shadow-md
            transition-all duration-1000
            hover:border-green-500
            hover:-translate-y-2
            hover:shadow-2xl">

        <div style="position:absolute; top:8px; right:8px; z-index:999; background:#22c55e; color:white; font-size:12px; font-weight:bold; padding:2px 6px; border-radius:4px;">15% OFF</div>
        <a href="golf.php">
          <img src="./turf-img/golf.jpg" alt="">
        </a>
        <h5>Golf Turf</h5>
        <p>₹150 (per hours)</p>
        <a href="golf.php"><button class="button-89">See More...</button></a>
      </div>

      <!-- Hockey -->
      <div class="t1 relative 
            bg-white rounded-xl overflow-hidden
            border-2 border-transparent
            shadow-md
            transition-all duration-1000
            hover:border-green-500
            hover:-translate-y-2
            hover:shadow-2xl">

        <div style="position:absolute; top:8px; right:8px; z-index:999; background:#22c55e; color:white; font-size:12px; font-weight:bold; padding:2px 6px; border-radius:4px;">15% OFF</div>
        <a href="hockey.php">
          <img src="./turf-img/hockey.jpg" alt="">
        </a>
        <h5>Hockey Turf</h5>
        <p>₹300 (per hours)</p>
        <a href="hockey.php"><button class="button-89">See More...</button></a>
      </div>

      <!-- Tennis -->
      <div class="t1 relative 
            bg-white rounded-xl overflow-hidden
            border-2 border-transparent
            shadow-md
            transition-all duration-1000
            hover:border-green-500
            hover:-translate-y-2
            hover:shadow-2xl">

        <div style="position:absolute; top:8px; right:8px; z-index:999; background:#22c55e; color:white; font-size:12px; font-weight:bold; padding:2px 6px; border-radius:4px;">15% OFF</div>
        <a href="tennis.php">
          <img src="./turf-img/tennis.jpg" alt="">
        </a>
        <h5>Tennis Turf</h5>
        <p>₹250 (per hours)</p>
        <a href="tennis.php"><button class="button-89">See More...</button></a>
      </div>

      <!-- Volleyball -->
      <div class="t1 relative 
            bg-white rounded-xl overflow-hidden
            border-2 border-transparent
            shadow-md
            transition-all duration-1000
            hover:border-green-500
            hover:-translate-y-2
            hover:shadow-2xl">

        <div style="position:absolute; top:8px; right:8px; z-index:999; background:#22c55e; color:white; font-size:12px; font-weight:bold; padding:2px 6px; border-radius:4px;">15% OFF</div>
        <a href="volleyball.php">
          <img src="./turf-img/volleyball.webp" alt="">
        </a>
        <h5>Volleyball Turf</h5>
        <p>₹200 (per hours)</p>
        <a href="volleyball.php"><button class="button-89">See More...</button></a>
      </div>

      <!-- Javelin -->
      <div class="t1 relative 
            bg-white rounded-xl overflow-hidden
            border-2 border-transparent
            shadow-md
            transition-all duration-1000
            hover:border-green-500
            hover:-translate-y-2
            hover:shadow-2xl">

        <div style="position:absolute; top:8px; right:8px; z-index:999; background:#22c55e; color:white; font-size:12px; font-weight:bold; padding:2px 6px; border-radius:4px;">15% OFF</div>
        <a href="javelin.php">
          <img src="./turf-img/javelin.jpg" alt="">
        </a>
        <h5>Javelin Turf</h5>
        <p>₹100 (per hours)</p>
        <a href="javelin.php"><button class="button-89">See More...</button></a>
      </div>

      <!-- Kho-Kho -->
      <div class="t1 relative 
            bg-white rounded-xl overflow-hidden
            border-2 border-transparent
            shadow-md
            transition-all duration-1000
            hover:border-green-500
            hover:-translate-y-2
            hover:shadow-2xl">

        <div style="position:absolute; top:8px; right:8px; z-index:999; background:#22c55e; color:white; font-size:12px; font-weight:bold; padding:2px 6px; border-radius:4px;">15% OFF</div>
        <a href="kho-kho.php">
          <img src="./turf-img/kho-kho.jpg" alt="">
        </a>
        <h5>Kho-Kho Turf</h5>
        <p>₹110 (per hours)</p>
        <a href="kho-kho.php"><button class="button-89">See More...</button></a>
      </div>

    </div>
  </section>

  <?php include "footer.php" ?>


  <script src="main.js"></script>
  <script src="all-animation.js"></script>
</body>

</html>