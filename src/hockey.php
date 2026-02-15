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
  <title>HOCKEY TURF | TURFBOOKING SYSTEM</title>
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
            <p style="margin-left: 5px;"> Hockey</p>
        </div>
     </section>

<section>
  <div class="flex flex-col md:flex-row items-start md:items-center gap-6 p-6 md:p-10">
    
    <!-- Image Section -->
    <div class="w-full md:w-1/3 flex justify-center">
      <img src="./turf-img/hockey.jpg" alt="Archery" class="" style="width: 340px;">
    </div>

    <!-- Info Section -->
    <div class="w-full md:w-3/5 space-y-4">
      <h2 class="text-3xl font-bold">Hockey Turf</h2>
      <div class="flex items-center space-x-1 text-lg">
        <i class="fa-solid fa-star text-yellow-400"></i>
        <i class="fa-solid fa-star text-yellow-400"></i>
        <i class="fa-solid fa-star text-yellow-400"></i>
        <i class="fa-solid fa-star text-yellow-400"></i>
        <i class="fa-solid fa-star"></i>
        <span>(203)</span>
      </div>
      <p class="text-green-600" style="font-size: 19px;">Avalible</p>
      <p>₹300(per hour)</p>
      <hr class="border-gray-300">
      <div class="space-y-2">
        <p class="text-xl font-semibold">Description</p>
        <p>Ground Width (In Feet):20</p>
        <p>Ground Length (In Feet):44</p>
        <p class="text-justify">Hockey is a fast-paced, exciting game full of skill, teamwork, and action! Played between two teams, the goal is to hit the ball into the opponent’s net using a hockey stick. It’s a game of speed, strategy, and sharp reflexes. Whether you're playing casually or training seriously, hockey is a great way to stay active and enjoy the thrill of the sport. Our turf provides a smooth and safe surface perfect for both beginners and experienced players. So grab your stick, gather your team, and let the match begin!</p>
    <!-- ------------------------------------------------book-button------------------------------- -->
<div class="pt-4 flex justify-start">
    <a href="booking.php">
      <button type="submit" name="add_to_cart"  class="cssbuttons-io-button">
        BOOK NOW
        <div class="icon1">
            <svg height="24" width="24" viewBox="0 0 24 24">
                <path d="M0 0h24v24H0z" fill="none"></path>
                <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                      fill="currentColor"></path>
            </svg>
        </div>
    </button>
    </a>
</div>

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

