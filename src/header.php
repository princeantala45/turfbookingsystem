  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<section>

   <!-- Header Section -->
    <div class="up-errow">
        <i class="fa-solid fa-angles-up" style="font-size: 20px;"></i>
  </div>

  <div class="menu">
        <i class="fa-solid fa-bars"></i>
    </div>

</section>

    
    <style>
        /* --- Global & Mobile Scroll Fixes --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Trebuchet MS', sans-serif;
        }

        html, body {
            overflow-x: hidden; 
            /* background-color: #f8f9fa; */
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }

        /* --- Original Loader --- */
        #loader {
            position: fixed;
            inset: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            z-index: 9999;
        }
        #loader img { width: 120px; }

        /* --- Full Width Header Logic --- */
        .tbs-header {
            background-color: #ffffff !important; /* Solid color prevents content showing through */
            border-bottom: 1px solid #eee;
            z-index: 10000; /* Stays above everything */
            padding: 5px 20px; /* Side padding for fluid look */
        }

        .typewriter {
            color: #FF7518;
            overflow: hidden;
            white-space: nowrap;
            border-right: 2px solid #FF7518;
            width: 0;
            animation: typing 1.4s steps(20) forwards, blink 0.6s step-end infinite;
            font-size: 1.4rem;
            font-weight: bold;
            margin-left: 5px;
            padding-top: 10px;
        }

        @keyframes typing { from { width: 0; } to { width: 18.2ch; } }
        @keyframes blink { 50% { border-color: transparent; } }

        /* --- Attractive Menu Items (No Container Style) --- */
        .menu-item {
            position: relative;
            padding: 12px 20px !important;
            color: #333 !important;
            text-decoration: none;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            transition: 0.3s;
        }

        .corner {
            position: absolute;
            width: 8px;
            height: 8px;
            border: 2px solid transparent;
            transition: all 0.3s ease-in-out;
        }
        .tl { top: 0; left: 0; border-right: none; border-bottom: none; }
        .br { bottom: 0; right: 0; border-left: none; border-top: none; }

        .menu-item:hover { color: #4bd56b !important; }
        .menu-item:hover .tl { border-color: #4bd56b; width: 100%; height: 100%; }
        .menu-item:hover .br { border-color: #4bd56b; width: 100%; height: 100%; }

        /* --- Dropdown Styling --- */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-radius: 8px;
            margin-top: 5px !important;
        }

        .dropdown-item {
            padding: 10px 20px;
            transition: 0.2s;
        }
        .dropdown-item:hover {
            background-color: #f0fdf4;
            color: #4bd56b;
            padding-left: 25px;
        }

        /* --- Mobile Responsiveness Fixes --- */
        @media (max-width: 991px) {
            .tbs-header { padding: 5px 10px; }
            .navbar-collapse {
                background: #fff;
                margin-top: 10px;
                padding: 10px;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            }
            .typewriter { font-size: 1.1rem; width: auto; border: none; animation: none; }
            .menu-item { width: 100%; border-bottom: 1px solid #f8f8f8; }
            .corner { display: none; }
        }
    </style>


<div id="loader">
    <img src="leaf-loader-CVgu4tmg.gif" alt="Loading...">
    <p style="color:green; font-weight:bold;">Loading...</p>
</div>

<nav class="navbar navbar-expand-lg sticky-top tbs-header">
    <div class="container-fluid"> <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="./header-image-black.png" alt="Logo" style="width: 100px;" class="me-2">
            <h1 class="typewriter">TURFBOOKING SYSTEM</h1>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
            <i class="fa-solid fa-bars-staggered" style="color: #FF7518; font-size: 24px;"></i>
        </button>

        <div class="collapse navbar-collapse" id="navContent">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="index.php" class="menu-item">
                        <span>Home</span>
                        <span class="corner tl"></span>
                        <span class="corner br"></span>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a href="#" class="menu-item dropdown-toggle" data-bs-toggle="dropdown">
                        <span>Pages</span>
                        <span class="corner tl"></span>
                        <span class="corner br"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="turf.php"><i class="fas fa-baseball-ball me-2"></i>Our Turfs</a></li>
                        <li><a class="dropdown-item" href="product.php"><i class="fas fa-box me-2"></i>Our Products</a></li>
                        <li><a class="dropdown-item" href="review.php"><i class="fa-solid fa-users me-2"></i>Reviews</a></li>
                        <li><a class="dropdown-item" href="feauter.php"><i class="fas fa-calendar-check me-2"></i>Features</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="contact.php" class="menu-item">
                        <span>Contact</span>
                        <span class="corner tl"></span>
                        <span class="corner br"></span>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a href="#" class="menu-item dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                        <?php $username = $_SESSION['username'] ?? 'Guest'; ?>
                        <span class="text-danger text-capitalize me-2"><?php echo htmlspecialchars($username); ?></span>
                        <i class="fa-solid fa-circle-user text-danger fa-lg"></i>
                        <span class="corner tl"></span>
                        <span class="corner br"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="profile.php"><i class="fa-solid fa-user me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="history.php"><i class="fa-solid fa-clock-rotate-left me-2"></i>History</a></li>
                        <li><a class="dropdown-item" href="product_history.php"><i class="fas fa-truck"></i> My Orders</a></li>
                        <li><a class="dropdown-item" href="cart.php"><i class="fa-solid fa-cart-shopping me-2"></i>Cart</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="logout.php"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    window.addEventListener("load", function () {
        const loader = document.getElementById("loader");
        setTimeout(function () {
            loader.style.opacity = "0";
            loader.style.transition = "opacity 0.5s ease";
            setTimeout(function () { loader.style.display = "none"; }, 500);
        }, 500);
    });
</script>

