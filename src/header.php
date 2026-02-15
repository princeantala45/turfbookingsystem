<style>
    *{
      font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
    }
.typewriter {
  color: #FF7518;
  overflow: hidden;
  white-space: nowrap;
  border-right: 2px solid #FF7518;
  width: 0;
  animation: typing 1.4s steps(20) forwards, blink 0.6s step-end infinite;
}
#loader {
  position: fixed;
  inset: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  background: rgba(255, 255, 255, 0.4); /* semi-transparent */
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px); /* for Safari */
  z-index: 9999;
}

#loader img {
  width: 120px;
}


@keyframes typing {
  from { width: 0; }
  to { width: 18.2ch; }
}

@keyframes blink {
  50% { border-color: transparent; }
}
  </style>
    <!-- Loader -->
<div id="loader">
  <img src="leaf-loader-CVgu4tmg.gif" alt="Loading...">
  <p style="color:green;">Loading...</p>
</div>

<section>

   <!-- Header Section -->
    <div class="up-errow">
        <i class="fa-solid fa-angles-up" style="font-size: 20px;"></i>
  </div>

  <div class="menu">
        <i class="fa-solid fa-bars"></i>
    </div>
  <div class="container">
    <div class="nav-box-1">
      <a href="index.php">
      <img class="w-30 pl-4 pt-2" src="./header-image-black.png" alt="">
      </a>
      <a href="index.php">
        <h1 class="typewriter text-2xl font-bold" style="color:#FF7518">TURFBOOKING SYSTEM</h1>
      </a>
    </div>

    <div id="navlinks" class="nav-box-2" style="padding-right: 10px;">
      <a href="index.php" class="menu-item">
        <span>Home</span>
        <span class="corner tl"></span>
        <span class="corner br"></span>
      </a>

      <div class="drop-down" style="padding-top: 10px; padding-bottom: 10px;">
        <a href="#" id="pages" class="menu-item">
          <span>Pages <i class="fa-solid fa-chevron-down" id="errow"></i></span>
          <span class="corner tl"></span>
          <span class="corner br"></span>
        </a>
        <div class="hover-box">
          <a href="turf.php"><i class="fas fa-baseball-ball"></i> Our Turfs</a>
          <a href="product.php"><i class="fas fa-box"></i> Our Products</a>
          <a href="review.php"><i class="fa-solid fa-users"></i>  Customer Review</a>
          <a href="feauter.php"><i class="fas fa-calendar-check"></i> Feauters</a>
        </div>
      </div>

      <a href="contact.php" class="menu-item">
        <span>Contact</span>
        <span class="corner tl"></span>
        <span class="corner br"></span>
      </a>

      <div class="drop-down py-2">
  <a href="#" class="menu-item flex items-center gap-1">
    <?php
$username = $_SESSION['username'] ?? 'Guest';
?>

<span class="text-red-600 capitalize"><?php echo htmlspecialchars($username); ?></span></span>
<i class="fa-solid fa-chevron-down text-red-600" id="errow"></i>
    <span class="corner tl"></span>
    <span class="corner br"></span>
  </a>
  <div class="hover-box">
    <a href="profile.php"><i class="fa-solid fa-user"></i> Profile</a>
    <a href="history.php"><i class="fa-solid fa-clock-rotate-left"></i> Booking History</a>
    <a href="product_history.php"><i class="fas fa-truck"></i> My Orders</a>
    <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i> Cart</a>
    <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
  </div>
</div>
    </div>
</section>

<script>
  window.addEventListener("load", function () {
    const loader = document.getElementById("loader");

    const minimumTime = 500; // 2 seconds

    setTimeout(function () {
      loader.style.opacity = "0";
      loader.style.transition = "opacity 0.5s ease";

      setTimeout(function () {
        loader.style.display = "none";
      }, 500);

    }, minimumTime);
  });
</script>

