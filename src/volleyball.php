<?php 
  session_start();
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
  <link rel="shortcut icon" href="./gallery/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="turf.css">
  <title>VOLLEYBALL TURF | TURFBOOKING SYSTEM</title>
  <style>
    .book-button{
      border: 1px solid;
      padding: 10px 25px;
      transform: translateY(10px);
    }
    .book-button:hover{
      background-color: #9bc96d;
      border: 1px solid transparent;
      transition: .6s;
    }
  </style>
</head>
<body>
   <?php include"header.php" ?> 

  <section>
        <div class="line-turf">
            <p>Home /</p>
            <p style="margin-left: 5px;"> Volleyball</p>
        </div>
     </section>

<section>
  <div class="flex flex-col md:flex-row items-start md:items-center gap-6 p-6 md:p-10">
    
    <!-- Image Section -->
    <div class="w-full md:w-1/3 flex justify-center">
      <img src="./turf-img/volleyball.webp" alt="Archery" class="" style="width: 340px;">
    </div>

    <!-- Info Section -->
    <div class="w-full md:w-3/5 space-y-4">
      <h2 class="text-3xl font-bold">Volleyball Turf</h2>
      <div class="flex items-center space-x-1 text-lg">
        <i class="fa-solid fa-star text-yellow-400"></i>
        <i class="fa-solid fa-star text-yellow-400"></i>
        <i class="fa-solid fa-star text-yellow-400"></i>
        <i class="fa-solid fa-star text-yellow-400"></i>
        <i class="fa-solid fa-star"></i>
        <span>(93)</span>
      </div>
      <p class="text-green-600" style="font-size: 19px;">Avalible</p>
      <p>₹2000(per day)</p>
      <hr class="border-gray-300">
      <div class="space-y-2">
        <p class="text-xl font-semibold">Description</p>
        <p>Ground Width (In Feet):26</p>
        <p>Ground Length (In Feet):10</p>
        <p class="text-justify">Volleyball is a dynamic, fast-paced sport that’s all about teamwork, coordination, and fun! Played between two teams, the goal is to send the ball over the net and score points by making it land on the opposing team's side. Whether you're playing for fun or competing seriously, volleyball is a fantastic way to stay active, improve your skills, and enjoy the company of friends. Our turf provides a safe and smooth surface perfect for playing a casual match or hosting a tournament. So grab a ball, set your team, and get ready for some high-flying action!</p>
    <!-- ------------------------------------------------book-button------------------------------- -->
<a href="booking.php" class="inline-block">
  <button class="px-6 mt-5 py-2 bg-gradient-to-r from-blue-500 to-blue-700 text-white font-semibold rounded-full shadow-md hover:from-blue-600 hover:to-blue-800 hover:shadow-lg transition duration-300">
    BOOK NOW
  </button>
</a>


 </div>
    </div>

  </div>
</section>

<!-- Footer Section -->
      <?php include"footer.php" ?> 

  <script src="main.js"></script>
  <script src="all-animation.js"></script>
</body>
</html>

