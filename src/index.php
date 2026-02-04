<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "turfbookingsystem";
if (!isset($_SESSION['username'])) {
  header("Location: login.php"); 
  exit();
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
  <link rel="shortcut icon" href="./gallery/favicon.png" type="image/x-icon">
  <title>TURFBOOKING SYSTEM</title>
  <style>
    * {
      font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
    }
  </style>
</head>

<body>
  <?php include "header.php" ?>
  <section>
    <div class="slider">
      <div class="slider1 slide">
        <div class="slider-box-info">
          <h1 class="slider-heading font-bold text-2xl sm:text-5xl md:text-5xl">Our All Turfs</h1>

          <p class="p" style="padding-top: 20px; padding-bottom: 20px; font-size: large;">Effortless booking for everyone</p>
          <a href="turf.php">
            <button class="button">BOOK NOW</button>
          </a>
        </div>
        <img src="./slider-1.png" alt="" class="image">
      </div>

      <div class="slider2 slide">
        <div class="slider-box-info">
          <h1 class="font-bold text-2xl sm:text-5xl md:text-5xl">Our All Products</h1>
          <p style="padding-top: 20px; padding-bottom: 20px; font-size: large;">Effortless shopping for everyone</p>
          <a href="product.php">
            <button class="button">BOOK NOW</button>
          </a>
        </div>
        <img src="./slider-2.png" alt="">
      </div>

      <!-- Circle buttons inside slider -->
      <div style="display: flex; gap: 10px; justify-content: center; margin-top: 20px;">
        <button class="circle-button"></button>
        <button class="circle-button"></button>
      </div>
    </div>
  </section>

  <section class="pt-10">
    <marquee behavior="scroll" direction="left" scrollamount="5">
      <span style="display: inline-flex; align-items: center; gap: 10px;">
        <img src="./play-boy.png" width="69px" alt="playlogo" />
        <strong>Book, Play, Win - Sports Life</strong>
        <img src="./play-boy.png" width="69px" alt="playlogo" />
      </span>
    </marquee>
  </section>

  <section class="flex justify-center" style="overflow: hidden;">
    <div class="flex flex-col justify-center items-center text-center w-1/1">
      <h1 id="welcome-h1" class="text-2xl pt-0 font-bold pt-20 sm:text-3xl" style="transform: translateY(70px); color: rgb(212, 120, 1);">Welcome to Turfbooking System</h1>
      <div class="flex flex-col pl-5 pr-5 gap-5 text-justify text-xs sm:pl-20 sm:pr-20 sm:text-lg md:text-lg">
        <p style="transform: translateX(200px);" id="welcome-text1">
          TufrBooking is a cutting-edge booking management system designed to streamline the reservation process for businesses in the hospitality and travel sectors. Established in 2020, TufrBooking aims to enhance customer experience by providing a seamless and efficient platform for booking accommodations, activities, and services.
        </p>
        <p style="transform: translateX(200px);" id="welcome-text2">At TufrBooking, we prioritize quality and reliability. Our team of experienced professionals conducts rigorous testing and quality assurance processes to ensure that the system operates flawlessly. Regular updates and maintenance are performed to keep the platform secure and up-to-date with the latest technology trends.</p>
        <p style="transform: translateX(200px);" id="welcome-text3">TufrBooking is committed to revolutionizing the booking experience for both businesses and customers. With a focus on quality, efficiency, and user satisfaction, TufrBooking stands out as a premier choice for booking management solutions in the hospitality and travel industries.</p>
      </div>
    </div>
    <div class="welcome-img"></div>
  </section>

  <section>
    <div class="map-section">
      <div class="map-image-div">
        <img src="./india-map/india-map.webp" width="666px">
      </div>
      <div class="map-text">
        <p class="text-3xl font-bold">TURFBOOKING SYSTEM HAS</p>
        <h1 class="text-5xl font-bold text-white" style="text-transform: uppercase;">Active Customer 160+ Cities Across India</h1>
        <p class="">JOIN WITH THE LARGEST SPORTS GROUND MANAGEMENT SOLUTION</p>
      </div>
    </div>
  </section>


  <div class="flex flex-wrap justify-center gap-6 p-6 pt-20 bg-white">
    <!-- Feature 1: Easy Booking -->
    <div class="bg-[#f0fcfd] w-64 h-48 flex flex-col items-center justify-center rounded-lg shadow" id="info-box1">
      <i class="fa-solid fa-calendar-check text-cyan-500 text-4xl mb-3" id="icon"></i>
      <h3 class="text-lg font-semibold text-[#0f172a]">Easy Booking</h3>
    </div>

    <!-- Feature 2: Multiple Turfs -->
    <div class="bg-[#f0fcfd] w-64 h-48 flex flex-col items-center justify-center rounded-lg shadow" id="info-box2">
      <i class="fa-solid fa-futbol text-cyan-500 text-4xl mb-3" id="icon"></i>
      <h3 class="text-lg font-semibold text-[#0f172a]">Multiple Turfs</h3>
    </div>

    <!-- Feature 3: Hourly Slots -->
    <div class="bg-[#f0fcfd] w-64 h-48 flex flex-col items-center justify-center rounded-lg shadow" id="info-box3">
      <i class="fa-solid fa-clock text-cyan-500 text-4xl mb-3" id="icon"></i>
      <h3 class="text-lg font-semibold text-[#0f172a]">24*7 Available</h3>
    </div>

    <!-- Feature 4: Secure Payment -->
    <div class="bg-[#f0fcfd] w-64 h-48 flex flex-col items-center justify-center rounded-lg shadow" id="info-box4">
      <i class="fa-solid fa-lock text-cyan-500 text-4xl mb-3" id="icon"></i>
      <h3 class="text-lg font-semibold text-[#0f172a]">Secure Payment</h3>
    </div>
  </div>
  <!-- ---------------------------------mission-vision-section-------------------------------------------->
  <section class="pt-12" style="overflow: hidden;">
    <div class="py-8 px-4 bg-amber-200" style="background-color: #EFE6DA;">
      <div class="max-w-7xl mx-auto flex flex-col md:flex-row gap-8 p-6 md:p-5 md:pl-20 md:pr-20">

        <!-- Mission -->
        <div class="flex flex-col justify-top items-center text-justify space-y-4 w-full md:w-1/2">
          <h2 class="mission-and-vision-h1-1 text-2xl font-bold text-orange-500">OUR MISSION</h2>
          <p class="mission-text text-gray-700 text-sm md:text-lg">
            Our mission is to revolutionize the way individuals and organizations book and manage turf facilities by providing a seamless, user-friendly platform that enhances accessibility, promotes community engagement, and fosters a love for sports. We aim to deliver an efficient and transparent booking experience while ensuring the highest standards of service, sustainability, and customer satisfaction.
          </p>
        </div>

        <!-- Vision -->
        <div class="flex flex-col justify-top items-center text-justify space-y-3  w-full md:w-1/2">
          <h2 class="mission-and-vision-h1-2 text-2xl font-bold text-orange-500">OUR VISION</h2>
          <p class="vision-text-1 text-gray-700 text-sm md:text-lg">
            "To revolutionize the turf booking industry by creating a sustainable and user-friendly platform that benefits all stakeholders, including customers, turf managers, and the environment, by:
          </p>
          <p class="vision-text-2 text-gray-700 text-sm md:text-lg">
            Implementing a robust verification system for turf facilities against a world-class sustainability code of conduct.
          </p>
          <p class="vision-text-3 text-gray-700 text-sm md:text-lg">
            Collaborating with turf managers and industry experts to tackle key challenges such as resource management, maintenance efficiency, fair pricing, customer satisfaction, and equitable access for all users."
          </p>
        </div>

      </div>
    </div>
  </section>

  <section class="p-10 sm:py-20">
    <div class="max-w-6xl rounded-3xl mx-auto px-2" style="background-color: #f5eed4ff;">
      <div class="flex flex-wrap justify-center gap-y-10 text-center text-black p-10">

        <!-- Row 1 -->
        <div class="w-full sm:w-1/3">
          <h1 class="count text-4xl font-bold" data-target="10">0+</h1>
          <p class="mt-2 text-lg">sports</p>
        </div>

        <div class="w-full sm:w-1/3">
          <h1 class="count text-4xl font-bold" data-target="345545">0+</h1>
          <p class="mt-2 text-lg">Sports sessions in the past 12 months</p>
        </div>

        <div class="w-full sm:w-1/3">
          <h1 class="count text-4xl font-bold" data-target="160">0+</h1>
          <p class="mt-2 text-lg">Cities</p>
        </div>

        <!-- Row 2 -->
        <div class="w-full sm:w-1/3">
          <h1 class="count text-4xl font-bold" data-target="15">0+</h1>
          <p class="mt-2 text-lg">local authorities</p>
        </div>

        <div class="w-full sm:w-1/3">
          <h1 class="count text-4xl font-bold" data-target="100">0+</h1>
          <p class="mt-2 text-lg">facilities</p>
        </div>

        <div class="w-full sm:w-1/3">
          <h1 class="count text-4xl font-bold" data-target="4500">0+</h1>
          <p class="mt-2 text-lg">Active customers</p>
        </div>

      </div>
    </div>
  </section>

  <section class="md:pl-20 md:pr-20 pl-5 pr-5">
    <div class="w-full" style="height: 400px;">
      <h1 class="text-2xl md:text-3xl font-bold text-center mb-10" style="color: rgb(212, 120, 1);">
        We Are Located Here
      </h1>
      <iframe
        class="w-full h-full"
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d460305.28002212517!2d72.60331048165922!3d23.034884205349478!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395c19aef2bb365d%3A0x27fe4fde3925ec5c!2sS%20V%20Campus!5e0!3m2!1sen!2sin!4v1745494287651!5m2!1sen!2sin"
        style="border:0;"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
  </section>

   


  <!-- Footer Section -->
  <?php include "footer.php" ?>

  <script src="main.js"></script>
</body>

</html>