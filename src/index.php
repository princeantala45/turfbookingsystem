<?php
session_start();

if (!isset($_SESSION['username'])) {
  echo "
    <!DOCTYPE html>
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Login Required',
                text: 'Please login first',
                confirmButtonText: 'OK'
            }).then(function() {
                window.location.href = 'login.php';
            });
        </script>
    </body>
    </html>
    ";
  exit();
}



$host = $_ENV['DB_HOST'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$db   = $_ENV['DB_NAME'];

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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

          <p class="p" style="padding-top: 20px; padding-bottom: 20px; font-size: large;">Effortless booking for
            everyone</p>
          <div class="pt-4 flex justify-center md:justify-start">
            <a href="turf.php">
              <button type="submit" class="cssbuttons-io-button">
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
        <img src="./slider-1.png" alt="" class="image">
      </div>

      <div class="slider2 slide">
        <div class="slider-box-info">
          <h1 class="font-bold text-2xl sm:text-5xl md:text-5xl">Our All Products</h1>
          <p style="padding-top: 20px; padding-bottom: 20px; font-size: large;">Effortless shopping for everyone</p>
          <div class="pt-4 flex justify-center md:justify-start">
            <a href="product.php">
              <button type="submit" class="cssbuttons-io-button">
                BUY NOW
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
    <div class="marquee">
      <div class="marquee-content">
        <img src="./play-boy.png" width="69" alt="playlogo" />
        <strong>Book, Play, Win - Sports Life</strong>
        <img src="./play-boy.png" width="69" alt="playlogo" />
      </div>
    </div>
  </section>

  <style>
    .marquee {
      overflow: hidden;
      white-space: nowrap;
      box-sizing: border-box;
    }

    .marquee-content {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      animation: scroll-left 10s linear infinite;
    }

    @keyframes scroll-left {
      from {
        transform: translateX(100%);
      }

      to {
        transform: translateX(-100%);
      }
    }
  </style>


  <section class="flex justify-center" style="overflow: hidden;">
    <div class="flex flex-col justify-center items-center text-center w-1/1">
      <h1 id="welcome-h1" class="text-2xl pt-0 font-bold pt-20 sm:text-3xl"
        style="transform: translateY(70px); color: rgb(212, 120, 1);">Welcome to Turfbooking System</h1>
      <div class="flex flex-col pl-5 pr-5 gap-5 text-justify text-xs sm:pl-20 sm:pr-20 sm:text-lg md:text-lg">
        <p style="transform: translateX(200px);" id="welcome-text1">
          TufrBooking is a cutting-edge booking management system designed to streamline the reservation process for
          businesses in the hospitality and travel sectors. Established in 2020, TufrBooking aims to enhance customer
          experience by providing a seamless and efficient platform for booking accommodations, activities, and
          services.
        </p>
        <p style="transform: translateX(200px);" id="welcome-text2">At TufrBooking, we prioritize quality and
          reliability. Our team of experienced professionals conducts rigorous testing and quality assurance processes
          to ensure that the system operates flawlessly. Regular updates and maintenance are performed to keep the
          platform secure and up-to-date with the latest technology trends.</p>
        <p style="transform: translateX(200px);" id="welcome-text3">TufrBooking is committed to revolutionizing the
          booking experience for both businesses and customers. With a focus on quality, efficiency, and user
          satisfaction, TufrBooking stands out as a premier choice for booking management solutions in the hospitality
          and travel industries.</p>
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
        <h1 class="text-5xl font-bold text-white" style="text-transform: uppercase;">Active Customer 160+ Cities Across
          India</h1>
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
            Our mission is to revolutionize the way individuals and organizations book and manage turf facilities by
            providing a seamless, user-friendly platform that enhances accessibility, promotes community engagement, and
            fosters a love for sports. We aim to deliver an efficient and transparent booking experience while ensuring
            the highest standards of service, sustainability, and customer satisfaction.
          </p>
        </div>

        <!-- Vision -->
        <div class="flex flex-col justify-top items-center text-justify space-y-3  w-full md:w-1/2">
          <h2 class="mission-and-vision-h1-2 text-2xl font-bold text-orange-500">OUR VISION</h2>
          <p class="vision-text-1 text-gray-700 text-sm md:text-lg">
            "To revolutionize the turf booking industry by creating a sustainable and user-friendly platform that
            benefits all stakeholders, including customers, turf managers, and the environment, by:
          </p>
          <p class="vision-text-2 text-gray-700 text-sm md:text-lg">
            Implementing a robust verification system for turf facilities against a world-class sustainability code of
            conduct.
          </p>
          <p class="vision-text-3 text-gray-700 text-sm md:text-lg">
            Collaborating with turf managers and industry experts to tackle key challenges such as resource management,
            maintenance efficiency, fair pricing, customer satisfaction, and equitable access for all users."
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
      <iframe class="w-full h-full"
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d460305.28002212517!2d72.60331048165922!3d23.034884205349478!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395c19aef2bb365d%3A0x27fe4fde3925ec5c!2sS%20V%20Campus!5e0!3m2!1sen!2sin!4v1745494287651!5m2!1sen!2sin"
        style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
  </section>

  <section>
    <div class="supported-company">
      <h1 class="text-2xl font-bold sm:text-3xl text-center mt-12" style="margin-top: 80px; color: rgb(212, 120, 1);">

        Supported Integrations
      </h1>


      <div class="marquee-wrapper">
        <div class="marquee-track">
          <img src="./trusted-image/1.webp">
          <img src="./trusted-image/2.webp">
          <img src="./trusted-image/3.webp">
          <img src="./trusted-image/4.webp">
          <img src="./trusted-image/5.webp">
          <img src="./trusted-image/6.webp">
          <img src="./trusted-image/7.webp">
          <img src="./trusted-image/8.webp">
          <img src="./trusted-image/9.webp">
          <img src="./trusted-image/10.webp">
          <img src="./trusted-image/11.webp">
          <img src="./trusted-image/12.webp">
          <img src="./trusted-image/13.webp">
          <img src="./trusted-image/14.webp">
          <img src="./trusted-image/15.webp">
          <img src="./trusted-image/16.webp">
          <img src="./trusted-image/17.webp">
          <img src="./trusted-image/18.webp">
          <img src="./trusted-image/19.webp">
          <img src="./trusted-image/20.webp">
          <img src="./trusted-image/21.webp">
          <img src="./trusted-image/22.webp">
          <img src="./trusted-image/23.webp">

          <!-- duplicate for smooth infinite scroll -->
          <img src="./trusted-image/1.webp">
          <img src="./trusted-image/2.webp">
          <img src="./trusted-image/3.webp">
          <img src="./trusted-image/4.webp">
          <img src="./trusted-image/5.webp">
        </div>
      </div>
    </div>
  </section>

  <section class="py">
    <div class="max-w-4xl mx-auto pb-10">
      <h1 class="text-2xl font-bold sm:text-3xl text-center mt-12" style="margin-top: 60px; color: rgb(212, 120, 1);">

        Frequently Asked Questions

      </h1>

      <div class="space-y-4 mt-8">

        <!-- Question 1 -->
        <details class="bg-white rounded-lg shadow-md p-5">
          <summary class="cursor-pointer font-semibold text-green-700 text-lg">
            How to book a turf?
          </summary>
          <div class="mt-3">
            <p class="text-gray-600">
              To book a turf, visit the website and select your preferred date and time slot.
              Fill in the required details and proceed to payment. After successful payment,
              your booking will be confirmed.
            </p>
          </div>
        </details>

        <!-- Question 2 -->
        <details class="bg-white rounded-lg shadow-md p-5">
          <summary class="cursor-pointer font-semibold text-green-700 text-lg">
            How to buy a product?
          </summary>
          <div class="mt-3">
            <p class="text-gray-600">
              Browse the product list, select your desired item, and click on Buy or Add to Cart.
              Complete the payment process to confirm your order.
            </p>
          </div>
        </details>

        <!-- Question 3 -->
        <details class="bg-white rounded-lg shadow-md p-5">
          <summary class="cursor-pointer font-semibold text-green-700 text-lg">
            How to create an account?
          </summary>
          <div class="mt-3">
            <p class="text-gray-600">
              Click on Sign Up and enter your basic details such as name, email, and password.
              Once submitted, your account will be created successfully.
            </p>
          </div>
        </details>

        <!-- Question 4 -->
        <details class="bg-white rounded-lg shadow-md p-5">
          <summary class="cursor-pointer font-semibold text-green-700 text-lg">
            How to cancel a booking?
          </summary>
          <div class="mt-3">
            <p class="text-gray-600">
              Log in to your account, go to My Bookings, select the booking, and click Cancel.
              Refunds will be processed according to the cancellation policy.
            </p>
          </div>
        </details>

        <!-- Question 5 -->
        <details class="bg-white rounded-lg shadow-md p-5">
          <summary class="cursor-pointer font-semibold text-green-700 text-lg">
            How to make a payment?
          </summary>
          <div class="mt-3">
            <p class="text-gray-600">
              Choose your preferred payment method such as debit card, credit card, net banking,
              or UPI. After successful payment, confirmation will be shown.
            </p>
          </div>
        </details>

      </div>
    </div>
  </section>


  <!-- Footer Section -->
  <?php include "footer.php" ?>

  <script src="main.js"></script>
</body>

</html>