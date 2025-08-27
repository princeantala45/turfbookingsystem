<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "turfbookingsystem";

if (!isset($_SESSION['username'])) {
    echo "<script>
        alert('Please login first to access this page.');
        window.location.href = 'login.php';
    </script>";
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "turfbookingsystem");

if (!$conn) {
    die("<script>alert('Database connection failed');</script>");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $username = $_SESSION['username']; // username from login session
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $mobile   = $_POST['mobile'];
    $message  = $_POST['message'];
    $date     = date('Y-m-d H:i:s'); // current datetime

    // Get user_id from signup table
    $user_result = mysqli_query($conn, "SELECT user_id FROM signup WHERE username = '$username'");
    if (mysqli_num_rows($user_result) == 1) {
        $row = mysqli_fetch_assoc($user_result);
        $user_id = $row['user_id'];

        // Insert into contact table with foreign key
        $sql = "INSERT INTO contact (user_id, name, email, mobile, message, message_date) 
                VALUES ('$user_id', '$name', '$email', '$mobile', '$message', '$date')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Message sent successfully!'); window.location.href='contact.php';</script>";
        } else {
            echo "<script>alert('Message sending failed.');</script>";
        }
    } else {
        echo "<script>alert('User not found.');</script>";
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
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="contact.css">
  <link rel="shortcut icon" href="./gallery/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="turf.css">
  <title>CONTACT US | TURFBOOKING SYSTEM</title>
</head>
<body>
    <?php include"header.php" ?> 

  <section>
        <div class="line-turf">
            <p>Home /</p>
            <p style="margin-left: 5px;"> Contact</p>
        </div>
     </section>

     <section class="turf-header">
        <h2 class="text-2xl sm:text-3xl font-bold text-center tracking-wide" style="color: rgb(212, 120, 1);">
  Contact Us
</h2>
     </section>


<section class="py-12 text-center">
  <div class="flex flex-col sm:flex-row flex-wrap justify-center gap-10 sm:gap-40 px-4">


    <!-- Address -->
    <div class="flex flex-col items-center">
      <div class="w-20 h-20 flex items-center justify-center bg-gray-200 rounded-full border-2 border-gray-500 mb-4">
        <i class="fas fa-map-marker-alt text-3xl text-gray-700"></i>
      </div>
      <h3 class="text-xl font-medium mb-1">Our Address</h3>
      <p class="text-gray-500">SV Campus, Kadi</p>
    </div>

    <!-- Contact -->
    <div class="flex flex-col items-center">
      <div class="w-20 h-20 flex items-center justify-center bg-gray-200 rounded-full border-2 border-gray-500 mb-4">
        <i class="fas fa-phone text-2xl text-gray-700"></i>
      </div>
      <h3 class="text-xl font-medium mb-1">Contact</h3>
      <p class="text-gray-500">9876543210</p>
    </div>

    <!-- Email -->
    <div class="flex flex-col items-center">
      <div class="w-20 h-20 flex items-center justify-center bg-gray-200 rounded-full border-2 border-gray-500 mb-4">
        <i class="fas fa-envelope text-2xl text-gray-700"></i>
      </div>
      <h3 class="text-xl font-medium mb-1">Email</h3>
      <p class="text-gray-500">Turfbooking@Gmail.Com</p>
    </div>

    <!-- Hours -->
    <div class="flex flex-col items-center">
      <div class="w-20 h-20 flex items-center justify-center bg-gray-200 rounded-full border-2 border-gray-500 mb-4">
        <i class="fas fa-clock text-2xl text-gray-700"></i>
      </div>
      <h3 class="text-xl font-medium mb-1">Hours Of Open</h3>
      <p class="text-gray-500">24*7</p>
    </div>

  </div>
</section>


    <form action="contact.php" method="post">
        <div class="second">

        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d460305.28002212517!2d72.60331048165922!3d23.034884205349478!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395c19aef2bb365d%3A0x27fe4fde3925ec5c!2sS%20V%20Campus!5e0!3m2!1sen!2sin!4v1745494287651!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
            <div class="info-contact">
                <div class="name">
                    Your name (required)
                    <input type="text" name="name" required>
                </div>
                <div class="email">
                    Email address (required)
                    <input type="email" name="email" required>
                </div>
                <div class="mobile-contact">
                    Mobile number (required)
                    <input type="text" name="mobile" required>
                </div>
                <div class="message">
                    Message (required)
                    <textarea name="message" rows="10" required></textarea>
                </div>
                    <button type="submit" name="submit">Send</button>
            </div>
        </div>
    </form>
</section>

<!-- Footer Section -->
      <?php include"footer.php" ?> 

  <script src="main.js"></script>
</body>
</html>

