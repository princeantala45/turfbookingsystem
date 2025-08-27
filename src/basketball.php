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
  <title>BASKETBALL TURF | TURFBOOKING SYSTEM</title>
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
            <p style="margin-left: 5px;"> Basketball</p>
        </div>
     </section>

<section>
  <div class="flex flex-col md:flex-row items-start md:items-center gap-6 p-6 md:p-10">
    
    <!-- Image Section -->
    <div class="w-full md:w-1/3 flex justify-center">
      <img src="./turf-img/basketball-new.jpg" alt="Archery" class="" style="width: 340px;">
    </div>

    <!-- Info Section -->
    <div class="w-full md:w-3/5 space-y-4">
      <h2 class="text-3xl font-bold">Basketball Turf</h2>
      <div class="flex items-center space-x-1 text-lg">
        <i class="fa-solid fa-star text-yellow-400"></i>
        <i class="fa-solid fa-star text-yellow-400"></i>
        <i class="fa-solid fa-star text-yellow-400"></i>
        <i class="fa-solid fa-star text-yellow-400"></i>
        <i class="fa-solid fa-star"></i>
        <span>(209)</span>
      </div>
      <p class="text-green-600" style="font-size: 19px;">Avalible</p>
      <p>₹4500(per day)</p>
      <hr class="border-gray-300">
      <div class="space-y-2">
        <p class="text-xl font-semibold">Description</p>
        <p>Ground Width (In Feet):90</p>
        <p>Ground Length (In Feet):60</p>
        <p class="text-justify">Basketball is a fun and exciting game where two teams compete to throw the ball into the hoop. It’s all about running, bouncing the ball, and taking your best shot! Whether you're just playing for fun with friends or looking to stay active, basketball is a great way to enjoy some energy-packed time. Our turf offers a safe and comfortable space to play-perfect for beginners and regular players alike. So grab a ball, call your team, and get ready to shoot some hoops!</p>
    <!-- ------------------------------------------------book-button------------------------------- -->
<a href="booking.php">
<button class="px-6 mt-5 py-2 bg-gradient-to-r from-blue-500 to-blue-700 text-white font-semibold rounded-full shadow-md hover:from-blue-600 hover:to-blue-800 hover:shadow-lg transition duration-300">BOOK NOW</button>
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

