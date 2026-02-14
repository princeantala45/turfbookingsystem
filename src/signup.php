<?php
$conn = mysqli_connect("localhost", "root", "", "turfbookingsystem",3307);

$swal = "";

if (!$conn) {
    $swal = "Swal.fire({icon:'error',title:'Database connection failed.'});";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username   = $_POST["username"];
    $email      = $_POST["email"];
    $mobile     = $_POST["mobile"];
    $password   = $_POST["password"];
    $repassword = $_POST["repassword"];

    $checkUserQuery = "SELECT * FROM signup WHERE username = '$username'";
    $result = mysqli_query($conn, $checkUserQuery);

    if (mysqli_num_rows($result) > 0) {

        $swal = "Swal.fire({
            icon:'warning',
            title:'Username already exists',
            text:'$username is already taken.'
        });";

    } elseif ($password === $repassword) {

        $sql = "INSERT INTO signup (username, email, mobile, password) 
                VALUES ('$username', '$email', '$mobile', '$password')";
        
        if (mysqli_query($conn, $sql)) {

            $swal = "Swal.fire({
                icon:'success',
                title:'Signup Successful!'
            }).then(function(){
                window.location.href='login.php';
            });";

        } else {

            $error = mysqli_error($conn);
            $swal = "Swal.fire({
                icon:'error',
                title:'Signup Failed',
                text:'$error'
            });";
        }

    } else {

        $swal = "Swal.fire({
            icon:'error',
            title:'Passwords do not match.'
        });";
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
  <title>SIGNUP | TURFBOOKING SYSTEM</title>
  <style>
  * {
    text-transform: none;
    box-sizing: border-box;
      font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
  }

  .center {
    display: flex;
    justify-content: center;
  }

  .login {
    display: flex;
    flex-direction: column;
    gap: 20px;
    padding: 50px;
    margin: 50px;
     box-shadow: 0.1px 0.1px 10px;
    border-radius: 5px;
    width: 100%;
    max-width: 400px;
  }

  .input-bx {
    position: relative;
  }

  .input-bx input {
    padding: 10px;
    padding-right: 100px;
    width: 100%;
    border: 2px solid rgb(146, 146, 152);
    border-radius: 5px;
    outline: none;
    font-size: 1rem;
    transition: 0.6s;
  }

  .input-bx span {
    position: absolute;
    left: 10px;
    padding: 10px;
    bottom: 4.5px;
    font-size: 0.9rem;
    color: rgb(143, 146, 150);
    text-transform: uppercase;
    pointer-events: none;
    transition: 0.6s;
  }
  .input-bx input {
    padding: 10px 45px 10px 10px; /* right space for eye */
    width: 100%;
}
.togglePassword {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #666;
    z-index: 10; /* VERY IMPORTANT */
}
  .input-bx input:focus ~ span,
.input-bx input.has-value ~ span {
    color: #3742fa;
    transform: translateX(10px) translateY(-30px);
    font-size: 0.65rem;
    font-weight: 600;
    padding: 0 10px;
    background: #fff;
    letter-spacing: 0.1rem;
}


  .input-bx input:valid,
  .input-bx input:focus {
    color: #3742fa;
    border: 2px solid #3742fa;
  }

  .signup-last {
    display: flex;
    gap: 6px;
    justify-content: center;
    font-size: 14px;
  }

  .login-img {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
  }

  .google,
  .facebook,
  .insta {
    border: 1px dotted;
    width: 80px;
    height: 60px;
    border-radius: 5px;
  }

  .google {
    background-image: url(./login-img/google-main.png);
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
  }

  .facebook {
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .facebook i {
    color: #0d6efd;
    font-size: 35px;
  }

  .insta {
    background-image: url(./login-img/insta.png);
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
  }

  .si-line {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin-top: 10px;
    margin-bottom: 10px;
  }

  .line {
    border-bottom: 1.5px solid rgb(224, 224, 224);
    width: 90px;
    padding-left: 5px;
  }

  /* Mobile responsiveness */
  @media (max-width: 426px) {
    .login {
      padding: 20px;
      margin: 30px 10px;
      width: 100%;
    }

    .input-bx input {
      padding-right: 10px;
    }

    .input-bx span {
      font-size: 0.8rem;
    }

    .login button {
      font-size: 15px;
    }

    .google,
    .facebook,
    .insta {
      width: 65px;
      height: 55px;
    }

    .signup-last {
      flex-direction: column;
      font-size: 13px;
      text-align: center;
    }

    .login-img {
      gap: 10px;
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
          <a href="turf.php">Our Turfs</a>
          <a href="product.php">Our Products</a>
          <a href="review.php">Customer Review</a>
          <a href="feauter.php">Features</a>
        </div>
      </div>

      <a href="contact.php" class="menu-item">
        <span>Contact</span>
        <span class="corner tl"></span>
        <span class="corner br"></span>
      </a>

      <div class="drop-down" style="padding-top: 10px; padding-bottom: 10px;">
      <a href="login.php" class="menu-item">
      <span>Login</span>
        <span class="corner tl"></span>
        <span class="corner br"></span>
      </a>
      </div>
    </div>
</section>

  <section>
    <section>
        <div class="line-turf">
            <p>Home /</p>
            <p style="margin-left: 5px;">Signup</p>
        </div>
     </section>

    <section class="center">
            <form action="signup.php" method="post" class="login">
    <h1 class="text-2xl md:text-3xl font-bold text-center mb-4" style="color: rgb(212, 120, 1);">
                Signup</h1>
                <div class="input-bx">
    <input type="text" name="username" id="username" required oninput="validateUsername(this)">
    <span>enter username</span>
</div>

<script>
function validateUsername(input) {
    input.value = input.value.replace(/[^a-zA-Z]/g, '');
}
</script>

    <div class="input-bx">
        <input type="email" name="email" required>
        <span>enter email</span>
    </div>
    <div class="input-bx">
    <input type="text" name="mobile" id="mobile" required maxlength="10" oninput="validateMobile(this)">
    <span>enter mobile number</span>
</div>

<script>
function validateMobile(input) {
    input.value = input.value.replace(/[^0-9]/g, '');
}
</script>

<div class="input-bx">
  <input 
    type="password" 
    name="password"
    id="password"
    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" 
    required autocomplete="off" />
  <span>ENTER PASSWORD</span>
  <i class="fa-solid fa-eye togglePassword"
     style="position:absolute; right:10px; top:50%; transform:translateY(-50%);
     cursor:pointer; color:#666;"></i>
</div>

<div class="input-bx">
  <input 
    type="password" 
    name="repassword"
    id="repassword"
    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" 
    required autocomplete="off" />
  <span>RE-ENTER PASSWORD</span>
  <i class="fa-solid fa-eye togglePassword"
     style="position:absolute; right:10px; top:50%; transform:translateY(-50%);
     cursor:pointer; color:#666;"></i>
</div>

 
 <ul id="passwordmsg" class="text-sm space-y-1">
  <li id="length" class="text-gray-500">• At least 8 characters</li>
  <li id="uppercase" class="text-gray-500">• One uppercase letter</li>
  <li id="lowercase" class="text-gray-500">• One lowercase letter</li>
  <li id="number" class="text-gray-500">• One number</li>
  <li id="special" class="text-gray-500">• One special character (@,#,$,&,...)</li>
</ul>
<script>
document.addEventListener("DOMContentLoaded", function () {
  let passwordInput  = document.getElementById("password");
  let length     = document.getElementById("length");
  let uppercase  = document.getElementById("uppercase");
  let lowercase  = document.getElementById("lowercase");
  let number     = document.getElementById("number");
  let special    = document.getElementById("special");


  passwordInput.addEventListener("input", function () {
    let value = passwordInput.value; //user password value store in value variable

    length.className    = value.length >= 8       ? "text-green-500" : "text-red-500";
    uppercase.className = /[A-Z]/.test(value)     ? "text-green-500" : "text-red-500";
    lowercase.className = /[a-z]/.test(value)     ? "text-green-500" : "text-red-500";
    number.className    = /\d/.test(value)        ? "text-green-500" : "text-red-500";
    special.className   = /[\W_]/.test(value)     ? "text-green-500" : "text-red-500";
  });
});
</script>

    <button class="flex items-center justify-center px-5 py-2 bg-blue-200 text-blue-800 font-medium rounded-lg shadow hover:bg-blue-300 hover:scale-105 transition-transform duration-300 ease-in-out">
  <i class="fas fa-user-plus mr-2"></i>
  Sign Up
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
                    <p>Already an account? </p>
                    <a href="login.php" style="color: #0d6efd;">login</a>
                </div>
    </form>
    </section>
<!-- Footer Section -->
     <?php include"footer.php" ?> 

  <script src="main.js"></script>
  <script src="./all-animation.js"></script>
  <?php if(!empty($swal)) { ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    <?php echo $swal; ?>
});
</script>
<?php } ?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const toggles = document.querySelectorAll(".togglePassword");

    toggles.forEach(function(toggle) {
        toggle.addEventListener("click", function () {
            const input = this.parentElement.querySelector("input");

            const type = input.type === "password" ? "text" : "password";
            input.type = type;

            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    });
});
</script>


</body>
</html>
