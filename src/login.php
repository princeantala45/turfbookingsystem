<?php
session_start();

$conn = mysqli_connect("localhost","root","","turfbookingsystem",3307);
if (!$conn) die("Database connection failed.");

$swal = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn,"SELECT user_id, username, password FROM signup WHERE username=?");
    mysqli_stmt_bind_param($stmt,"s",$username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password']) || $password === $row['password']) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];

            $swal = "
            Swal.fire({
                icon: 'success',
                title: 'Login Successful!',
                text: '$username'
            }).then(() => {
                window.location.href='index.php';
            });
            ";
        } else {
            $swal = "
            Swal.fire({
                icon: 'error',
                title: 'Invalid password!'
            }).then(() => {
                window.location.href='login.php';
            });
            ";
        }
    } else {
        $swal = "
        Swal.fire({
            icon: 'warning',
            title: 'User not found!'
        }).then(() => {
            window.location.href='login.php';
        });
        ";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./output.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <link rel="shortcut icon" href="./gallery/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="turf.css">
  <title>LOGIN | TURFBOOKING SYSTEM</title>
   <style>
        *{
            text-transform: none;
      font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }
        .center{
            display: flex;
            justify-content: center;
        }
        .login{
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 50px;
            margin: 50px;
            text-align: center;
            box-shadow: .1px .1px 10px;
            border-radius: 5px;
        }
        .input-bx{
    position: relative;
    }
.input-bx input{
    padding: 10px;
    padding-right: 100px;
    border: 2px solid rgb(146, 146, 152);
    border-radius: 5px;
    outline: none;
    font-size: 1rem;
    transition: 0.6s;
}

.input-bx span{
    position: absolute;
    left: 10px;
    padding: 10px;
    bottom: 4.5px;
    font-size: .9rem;
    color:rgb(143, 146, 150);
    text-transform: uppercase;
    pointer-events: none;
    transition: 0.6s;
}
.input-bx input:valid ~ span,
.input-bx input:focus ~ span{
    color: #3742fa;
    transform: translateX(10px) translateY(-30px);
    font-size: 0.65rem;
    font-weight: 600;
    padding: 0 10px;
    background: #fff;
    letter-spacing: 0.1rem;
}

.input-bx input:valid,
.input-bx input:focus{
    color: #3742fa;
    border: 2px ridge #3742fa;
}
.signup-last{
    display: flex;
    gap: 10px;
    justify-content: center;
}
.login-img{
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
        }
        .google,.facebook,.insta{
            border: 1px dotted;
            width: 80px;
            height: 60px;
            border-radius: 5px;
        }
        .google{
            background-image: url(./login-img/google-main.png);
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }
        .facebook{
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .facebook i{
            color: #0d6efd;
            font-size: 35px;
        }
        .insta{
            background-image: url(./login-img/insta.png);
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }
        .si-line{
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        .line{
            border-bottom: 1.5px solid rgb(224, 224, 224);
            width: 90px;
            padding-left: 5px;
        }
@media  (max-width:769px) {
    
}
@media (max-width: 426px) {
  .login {
    padding: 20px;
    margin: 30px auto;
    width: 90%;
    max-width: 280px;
  }

  .input-bx input {
    padding-right: 60px;
    font-size: 0.9rem;
  }

  .input-bx span {
    font-size: 0.75rem;
  }

  .login button {
    font-size: 14px;
    padding: 8px;
  }

  .google, .facebook, .insta {
    width: 60px;
    height: 55px;
    background-size: contain;
  }

  .facebook i {
    font-size: 26px;
  }

  .si-line p {
    font-size: 0.85rem;
  }

  .line {
    width: 60px;
  }

  .signup-last {
    flex-direction: column;
    text-align: center;
    gap: 4px;
    font-size: 0.85rem;
  }
}
    </style>
</head>
<body>
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
      <img class="w-30 pl-4 pt-2" src="./header-image-black.png" alt="">
        <h1 class="text-2xl font-bold" style="color:#FF7518">TURFBOOKING SYSTEM</h1>
    </div>

    <div id="navlinks" class="nav-box-2" style="padding-right: 20px;">
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
          <a href="review.php"><i class="fa-solid fa-users"></i> Customer Review</a>
          <a href="feauter.php"><i class="fas fa-calendar-check"></i> Features</a>
        </div>
      </div>

      <a href="contact.php" class="menu-item">
        <span>Contact</span>
        <span class="corner tl"></span>
        <span class="corner br"></span>
      </a>

      <a href="login.php" class="menu-item">
      <span>User Login</span>
        <span class="corner tl"></span>
        <span class="corner br"></span>
      </a>

      <a href="admin_login.php" class="menu-item">
      <span>Admin Login</span>
        <span class="corner tl"></span>
        <span class="corner br"></span>
      </a>
    </div>
</section>

  <section>
        <div class="line-turf">
            <p>Home /</p>
            <p style="margin-left: 5px;"> User Login</p>
        </div>
     </section>

     <section class="center">
            <form action="login.php" method="post" class="login">
     <h1 class="text-2xl md:text-3xl font-bold text-center mb-4" style="color: rgb(212, 120, 1);">
               Secure Login</h1>
                <div class="input-bx">
                    <input type="text" name="username" required="required" />
                    <span>enter username</span>
                </div>
<div class="input-bx">
    <input type="password" name="password" id="password" required="required" autocomplete="off"/>
    <span>enter password</span>
    <i class="fa-solid fa-eye" id="togglePassword"
       style="position:absolute; right:10px; top:50%; transform:translateY(-50%);
       cursor:pointer; color:#666;"></i>
</div>

   <button class="flex items-center justify-center px-5 py-2 bg-blue-200 text-blue-800 font-medium rounded-lg shadow hover:bg-blue-300 hover:scale-105 transition-transform duration-300 ease-in-out">
  <i class="fas fa-lock mr-2"></i>
  Log in
</button>



                 <div class="signup">
                    <div class="si-line">
                        <div class="line"></div>
                        <p>Register with</p>
                        <div class="line"></div>
                    </div>
                </div>
                   <div class="login-img">
                    <a href="https://myaccount.google.com/">
                        <div class="google"></div>
                    </a>
                    <a href="https://www.facebook.com/">
                        <div class="facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </div>
                    </a>
                    <a href="https://www.instagram.com/">
                        <div class="insta"></div>
                    </a>
                </div>
                <div class="signup-last">
                    <p>don't have an account? </p>
                    <a href="signup.php" style="color: #0d6efd;">sign up</a>
                </div>
            </form>
    </section>

    <!-- Footer Section -->
      <?php include"footer.php" ?> 

  <script src="main.js"></script>
  <script src="all-animation.js"></script>
<?php if(!empty($swal)) { ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    <?php echo $swal; ?>
});
</script>
<?php } ?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const password = document.getElementById("password");
    const toggle = document.getElementById("togglePassword");

    if (toggle) {
        toggle.addEventListener("click", function () {
            const type = password.type === "password" ? "text" : "password";
            password.type = type;

            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    }
});
</script>

</body>
</html>