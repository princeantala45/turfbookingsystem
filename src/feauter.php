<?php
session_start();


include "db.php";


if (!isset($_SESSION['username'])) {
    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: "warning",
                title: "Login Required",
                text: "Please login first to access this page.",
                confirmButtonText: "OK"
            }).then(function() {
                window.location.href = "login.php";
            });
        </script>
    </body>
    </html>
    ';
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
  <link rel="stylesheet" href="turf.css">
  <link rel="shortcut icon" href="./gallery/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="style.css">
  <title>FEAUTERS | TURFBOOKING SYSTEM</title>
  <style>
    .feauter {
      display: grid;
      grid-template-columns: 23% 23% 23% 23%;
      justify-content: center;
      padding-top: 40px;
      padding-bottom: 40px;
    }
    .feauter-box img {
      width: 90px;
      padding-bottom: 20px;
      transform: scale(.5);
      opacity: 0;
    }
    .feauter-box {
      border: 1px dotted;
    }
    .feauter-info {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: justify;
      gap: 10px;
      padding: 30px;
      font-size: 15px;
    }
    .feauter-text{
      transform: translateY(80px);
      opacity: 0;
    }
    .feauter-h3{
      opacity: 0;
      transform: translateX(-80px);
    }
    @media (max-width: 769px) {
      .feauter {
        grid-template-columns: 40% 40%;
      }
    }
    @media (max-width: 426px) {
      .feauter {
        grid-template-columns: 80%;
        font-size: 20px;
      }
      .feauter-box {
        align-items: center;
        text-align: center;
      }
    } 
  </style>
</head>
<body>
    <?php include"header.php" ?> 
  <section>
        <div class="line-turf">
            <p>Home /</p>
            <p style="margin-left: 5px;"> Feauters</p>
        </div>
     </section>

     <section class="turf-header">
  <h1 class="text-2xl sm:text-3xl font-bold" style="color: rgb(212, 120, 1);">
    Salient Features
  </h1>
</section>

     </section>

     <section>
    <div class="feauter">

     <!-- Feature Cards -->
      <div class="feauter-box">
        <div class="feauter-info">
          <img src="./feauters-img/1.png" alt="" class="feauter-img">
          <h3 class="feauter-h3 text-2xl pt-0 font-bold sm:text-lg" style="color: rgb(212, 120, 1);">Custom Scheduling</h3>
          <p class="feauter-text">Set Unique Schedules, Durations, Prices, And Booking Rules For Each Service Or Location, Offering Tailored Availability And Pricing.</p>
        </div>
      </div>

      <div class="feauter-box">
        <div class="feauter-info">
          <img src="./feauters-img/2.png" alt="" class="feauter-img">
          <h3 class="feauter-h3 text-2xl pt-0 font-bold sm:text-lg" style="color: rgb(212, 120, 1);">Agent Scheduling Flexibility</h3>
          <p class="feauter-text">Enable Agents Or Service Providers To Set And Manage Their Own Schedules, Reflecting Real-Time Availability For Booking.</p>
        </div>
      </div>

      <div class="feauter-box">
        <div class="feauter-info">
          <img src="./feauters-img/3.png" alt="" class="feauter-img">
          <h3 class="feauter-h3 text-2xl pt-0 font-bold sm:text-lg" style="color: rgb(212, 120, 1);">UI Customization & White Labeling</h3>
          <p class="feauter-text">Modify Colors, Graphics, And Layouts To Reflect Your Brand Identity, Ensuring A Seamless And Professional Experience For Your Clients.</p>
        </div>
      </div>

      <div class="feauter-box">
        <div class="feauter-info">
          <img src="./feauters-img/4.png" alt="" class="feauter-img">
          <h3 class="feauter-h3 text-2xl pt-0 font-bold sm:text-lg" style="color: rgb(212, 120, 1);">Notifications & Reminders</h3>
          <p class="feauter-text">Automate Email And SMS Notifications To Keep Customers Informed And Reduce Missed Appointments With Timely Reminders.</p>
        </div>
      </div>

      <div class="feauter-box">
        <div class="feauter-info">
          <img src="./feauters-img/5.png" alt="" class="feauter-img">
          <h3 class="feauter-h3 text-2xl pt-0 font-bold sm:text-lg" style="color: rgb(212, 120, 1);">Payment Gateways</h3>
          <p class="feauter-text">Choose From Various Payment Gateways Such As RazorPay, Stripe Etc. To Collect On-Site Payments At The Time Of Bookings.</p>
        </div>
      </div>

      <div class="feauter-box">
        <div class="feauter-info">
          <img src="./feauters-img/6.png" alt="" class="feauter-img">
          <h3 class="feauter-h3 text-2xl pt-0 font-bold sm:text-lg" style="color: rgb(212, 120, 1);">Flexible Payment Choices</h3>
          <p class="feauter-text">Allow Customers The Flexibility & Convenience To Pay Either The Full Amount Or A Deposit For Each Booking.</p>
        </div>
      </div>

      <div class="feauter-box">
        <div class="feauter-info">
          <img src="./feauters-img/7.png" alt="" class="feauter-img">
          <h3 class="feauter-h3 text-2xl pt-0 font-bold sm:text-lg" style="color: rgb(212, 120, 1);">Availability Control</h3>
          <p class="feauter-text">Manage Booking Limits, Holiday Schedules, And Blackout Dates, Helping You Optimize Your Facility’s Availability And Booking Flow.</p>
        </div>
      </div>

      <div class="feauter-box">
        <div class="feauter-info">
          <img src="./feauters-img/8.png" alt="" class="feauter-img">
          <h3 class="feauter-h3 text-2xl pt-0 font-bold sm:text-lg" style="color: rgb(212, 120, 1);">Third-Party Integrations</h3>
          <p class="feauter-text">Seamlessly Connect With Popular Tools Like MailChimp, Google Calendar, Zoom For Auto-Scheduled Meetings, And Twilio.</p>
        </div>
      </div>

      <div class="feauter-box">
        <div class="feauter-info">
          <img src="./feauters-img/9.png" alt="" class="feauter-img">
          <h3 class="feauter-h3 text-2xl pt-0 font-bold sm:text-lg" style="color: rgb(212, 120, 1);">Advanced Coupons And Discounts</h3>
          <p class="feauter-text">Create Advanced Discount Combinations, With Eligibility And Validity Settings To Attract And Reward Customers.</p>
        </div>
      </div>

      <div class="feauter-box">
        <div class="feauter-info">
          <img src="./feauters-img/10.png" alt="" class="feauter-img">
          <h3 class="feauter-h3 text-2xl pt-0 font-bold sm:text-lg" style="color: rgb(212, 120, 1);">Memberships And Bundles</h3>
          <p class="feauter-text">Offer Packages, Memberships And Bundles, Allowing Customers To Buy Multiple Services And Schedule Sessions Conveniently.</p>
        </div>
      </div>

      <div class="feauter-box">
        <div class="feauter-info">
          <img src="./feauters-img/11.png" alt="" class="feauter-img">
          <h3 class="feauter-h3 text-2xl pt-0 font-bold sm:text-lg" style="color: rgb(212, 120, 1);">Customer Dashboard</h3>
          <p class="feauter-text">Give Customers A Dashboard Where They Can Manage Bookings, Reschedule Appointments, And Book From Purchased Service Bundles.</p>
        </div>
      </div>

      <div class="feauter-box">
        <div class="feauter-info">
          <img src="./feauters-img/12.png" alt="" class="feauter-img">
          <h3 class="feauter-h3 text-2xl pt-0 font-bold sm:text-lg" style="color: rgb(212, 120, 1);">Flexible Venue Partitioning</h3>
          <p class="feauter-text">Virtually Split Venues Into Multiple Sections For Simultaneous Bookings, Like Dividing A Football Turf For Different Group Sizes.</p>
        </div>
      </div>

      <div class="feauter-box">
        <div class="feauter-info">
          <img src="./feauters-img/13.png" alt="" class="feauter-img">
          <h3 class="feauter-h3 text-2xl pt-0 font-bold sm:text-lg" style="color: rgb(212, 120, 1);">Service Add-Ons And Extras</h3>
          <p class="feauter-text">Customers Can Add Extras Like Meals Or Equipment To Their Booking, Enhancing Their Experience With Value-Added Options.</p>
        </div>
      </div>

      <div class="feauter-box">
        <div class="feauter-info">
          <img src="./feauters-img/14.png" alt="" class="feauter-img">
          <h3 class="feauter-h3 text-2xl pt-0 font-bold sm:text-lg" style="color: rgb(212, 120, 1);">Analytics & Reporting</h3>
          <p class="feauter-text">Generate Insightful Reports To Analyze Booking Trends, Helping You Make Data-Driven Decisions And Optimize Your Services.</p>
        </div>
      </div>

      <div class="feauter-box">
        <div class="feauter-info">
          <img src="./feauters-img/15.png" alt="" class="feauter-img">
          <h3 class="feauter-h3 text-2xl pt-0 font-bold sm:text-lg" style="color: rgb(212, 120, 1);">Clean And Responsive UI</h3>
          <p class="feauter-text">Enjoy A Modern, User-Friendly Interface, Providing A Seamless Booking Experience Across Desktops, Tablets, And Smartphones.</p>
        </div>
      </div>

      <div class="feauter-box">
        <div class="feauter-info">
          <img src="./feauters-img/16.png" alt="" class="feauter-img">
          <h3 class="feauter-h3 text-2xl pt-0 font-bold sm:text-lg" style="color: rgb(212, 120, 1);">Tax Compliance</h3>
          <p class="feauter-text">Customize Tax Structures, Including GST, VAT, Or Other Local Taxes, And Fees Ensuring Business Compliance.</p>
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
