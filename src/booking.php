<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = mysqli_connect("localhost", "root", "", "turfbookingsystem");

    if (!$conn) die("Connection failed: " . mysqli_connect_error());

    if (!isset($_SESSION['username'])) {
        echo "<script>alert('User not logged in.'); window.location.href='login.php';</script>";
        exit;
    }

    $username = $_SESSION['username'];

    // Fetch user_id
    $user_query = mysqli_query($conn, "SELECT user_id FROM signup WHERE username = '$username'");
    if (!$user_query || mysqli_num_rows($user_query) === 0) {
        echo "<script>alert('❌ User not found.'); window.location.href='login.php';</script>";
        exit;
    }
    $user_data = mysqli_fetch_assoc($user_query);
    $user_id = $user_data['user_id'];

    function clean($value, $conn)
    {
        return mysqli_real_escape_string($conn, trim($value));
    }

    // Clean form data
    $fullname = clean($_POST['fullname'], $conn);
    $email    = clean($_POST['email'], $conn);
    $address  = clean($_POST['address'], $conn);
    $mobile   = clean($_POST['mobile'], $conn);
    $state    = clean($_POST['state'], $conn);
    $city     = clean($_POST['city'], $conn);
    $pincode  = clean($_POST['pincode'], $conn);
    $date     = clean($_POST['date'], $conn);
    $turfs    = clean($_POST['turfs'], $conn);
    $payment  = clean($_POST['payment_method'], $conn);

    // Turf prices
    $turf_prices = [
        "archery" => 1500,
        "badminton" => 8000,
        "baseball" => 5000,
        "basketball" => 4500,
        "cricket" => 10000,
        "football" => 5000,
        "golf" => 1500,
        "hockey" => 3000,
        "tennis" => 2500,
        "volleyball" => 2000,
        "javelin" => 1000,
        "kho-kho" => 1100
    ];

    if (!isset($turf_prices[$turfs])) {
        echo "<script>alert('❌ Invalid turf selected.'); history.back();</script>";
        exit;
    }

    // Check turf availability
    $check_sql = "SELECT * FROM ticket WHERE date='$date' AND turfs='$turfs'";
    $check_result = mysqli_query($conn, $check_sql);
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('❌ Turf already booked on this date.'); history.back();</script>";
        exit;
    }

    // Prices
    $base_price = $turf_prices[$turfs];
    $cgst = round($base_price * 0.09, 2);
    $sgst = round($base_price * 0.09, 2);
    $total_price = round($base_price + $cgst + $sgst, 2);

    // Generate unique payment reference
    do {
        $paymentRef = strtoupper($turfs) . rand(10000, 99999);
        $refCheck = mysqli_query($conn, "SELECT * FROM ticket WHERE payment_reference='$paymentRef'");
    } while (mysqli_num_rows($refCheck) > 0);

    $sql1 = "INSERT INTO ticket (
        user_id, username, fullname, email, address, mobile, state, city, pincode, date, turfs, base_price, cgst, sgst, total_price, payment_method, payment_reference
    ) VALUES (
        '$user_id','$username','$fullname','$email','$address','$mobile','$state','$city','$pincode','$date','$turfs','$base_price',$cgst,$sgst,$total_price,'$payment','$paymentRef'
    )";
    if (mysqli_query($conn, $sql1)) {
        $last_id = mysqli_insert_id($conn); // <-- Add this

        if ($payment === "card") {
            $cardnumber = clean($_POST['cardnumber'], $conn);
            $cardholdername = clean($_POST['cardholdername'], $conn);
            $expiry = clean($_POST['expiry'], $conn);
            $cvv = clean($_POST['cvv'], $conn);

            mysqli_query($conn, "INSERT INTO card_data 
            (user_id, username, turfs, payment_reference, cardnumber, cardholdername, expiry, cvv)
            VALUES ('$user_id','$username','$turfs','$paymentRef','$cardnumber','$cardholdername','$expiry','$cvv')");
        } elseif ($payment === "upi") {
            $upi = clean($_POST['upi'], $conn);
            mysqli_query($conn, "INSERT INTO upi 
            (user_id, username, turfs, payment_reference, upiid)
            VALUES ('$user_id','$username','$turfs','$paymentRef','$upi')");
        }

        echo "<script>
            alert('✅ Booking Successful!\\nPayment Reference: $paymentRef');
            window.location.href='history.php?id=$last_id';
          </script>";
        exit;
    } else {
        echo "<script>
                alert('❌ Booking failed: " . mysqli_error($conn) . "');
                history.back(booking.php);
              </script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOOKING DETAILS | TURFBOOKING SYSTEM</title>
    <link href="./output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="./gallery/favicon.png" type="image/x-icon">
</head>
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out;
    }
</style>

<body>
    <?php include "header.php" ?>

    <form method="POST" id="bookingForm" action="" class="max-w-2xl mx-auto rounded-2xl p-8 space-y-5 mt-10 mb-20" style="background-color:aliceblue;">
        <h2 class="text-3xl font-bold text-center py-4 bg-gradient-to-r from-blue-500 to-blue-300 rounded-t-xl text-white">
            Booking Details
        </h2>

        <div class="grid md:grid-cols-2 gap-6">

            <!-- Full Name (Alphabets & spaces only) -->
            <input type="text" name="fullname" placeholder="Full Name" required
                oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')"
                class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-500 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out" />

            <!-- Email (HTML5 handles this) -->
            <input type="email" name="email" placeholder="Email" required
                class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-500 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out" />

            <!-- Mobile (Exactly 10 digits) -->
            <input type="text" name="mobile" placeholder="Mobile Number" required
                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10); this.setCustomValidity(this.value.length < 10 ? 'Enter a valid 10-digit number' : '')"
                maxlength="10"
                pattern="\d{10}"
                class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-500 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out" />

            <!-- State (Alphabets & spaces only) -->
            <input type="text" name="state" placeholder="State" required
                oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')"
                class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-500 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out" />

            <!-- City (Alphabets & spaces only) -->
            <input type="text" name="city" placeholder="City" required
                oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')"
                class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-500 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out" />

            <!-- Pincode (Exactly 6 digits only) -->
            <input type="text" name="pincode" placeholder="Pincode" required
                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6); this.setCustomValidity(this.value.length < 6 ? 'Pincode must be 6 digits' : '')"
                maxlength="6"
                pattern="\d{6}"
                class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-500 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out" />

            <input type="text" name="address" placeholder="Address" required
                class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-500 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out" />


            <input type="date" name="date" required min="<?php echo date('Y-m-d'); ?>"
                class="w-full px-4 py-3 border rounded-md outline-none appearance-none text-black focus:ring-2 focus:ring-blue-400 focus:border-blue-500 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out" />
        </div>


        <select name="turfs" required
            class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-500 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out">
            <option value="">🎯 Select Turf</option>
            <option value="archery">Archery Turf ₹1500 (per day)</option>
            <option value="badminton">Badminton Turf ₹8000 (per day)</option>
            <option value="baseball">Baseball Turf ₹5000 (per day)</option>
            <option value="basketball">Basketball Turf ₹4500 (per day)</option>
            <option value="cricket">Cricket Turf ₹10000 (per day)</option>
            <option value="football">Football Turf ₹5000 (per day)</option>
            <option value="golf">Golf Turf ₹1500 (per day)</option>
            <option value="hockey">Hockey Turf ₹3000 (per day)</option>
            <option value="tennis">Tennis Turf ₹2500 (per day)</option>
            <option value="volleyball">Volleyball Turf ₹2000 (per day)</option>
            <option value="javelin">Javelin Turf ₹1000 (per day)</option>
            <option value="kho-kho">Kho-Kho Turf ₹1100 (per day)</option>
        </select>


        <select name="payment_method" id="payment_method" required
            class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-500 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out" style="margin: 0px;">
            <option value="">💳 Select Payment Method</option>
            <option value="card">Card</option>
            <option value="upi">UPI</option>
            <option value="cod">Cash on Delivery</option>
        </select>
        <!-- Card Fields -->
        <div id="card_fields" class="space-y-3 hidden">
            <!-- Card Number: 12-digit numeric only -->
            <input type="text" name="cardnumber" placeholder="Card Number" maxlength="12" required
                title="Card number must be 12 digits"
                class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-500 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out"
                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,12);" />

            <!-- Cardholder Name: alphabets only -->
            <input type="text" name="cardholdername" placeholder="Cardholder Name" pattern="[A-Za-z ]{2,}" required
                title="Cardholder name must contain only letters and spaces"
                class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-500 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out"
                oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '');" />

            <!-- Expiry Date: MM/YY format -->
            <input type="text" name="expiry" placeholder="Expiry (MM/YY)" maxlength="5" required
                oninput="
    let v = this.value.replace(/[^0-9]/g, '');
    if (v.length >= 2) v = v.slice(0, 2) + '/' + v.slice(2, 4);
    this.value = v.slice(0, 5);
    
    // Validate against past date
    if (v.length === 5) {
      const parts = v.split('/');
      const mm = parseInt(parts[0], 10);
      const yy = parseInt(parts[1], 10) + 2000;

      const today = new Date();
      const currentMonth = today.getMonth() + 1;
      const currentYear = today.getFullYear();

      if (mm < 1 || mm > 12 || yy < currentYear || (yy === currentYear && mm < currentMonth)) {
        this.setCustomValidity('Expiry cannot be in the past');
      } else {
        this.setCustomValidity('');
      }
    } else {
      this.setCustomValidity('Enter expiry in MM/YY format');
    }
  "
                title="Enter expiry in MM/YY format (e.g., 08/26). Cannot be past date."
                pattern="^(0[1-9]|1[0-2])\/\d{2}$"
                class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-500 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out" />

            <!-- CVV: 3-digit numeric -->
            <input type="text" name="cvv" placeholder="CVV" maxlength="3" required
                title="CVV must be 3 digits"
                class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-500 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out"
                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,3);" />

        </div>


        <!-- UPI Field -->
        <div id="upi_fields" class="hidden">
            <input type="text" name="upi" placeholder="UPI ID" required
                pattern="[a-zA-Z0-9._\-]+@[a-zA-Z]+"
                title="Enter a valid UPI ID (e.g., prince@upi)"
                class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-500 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out"
                oninput="this.value = this.value.replace(/[^a-zA-Z0-9._\-@]/g,'');" />
        </div>



        <div class="flex flex-col sm:flex-row gap-4 justify-between pt-4">
            <!-- Book Now Button -->
            <button type="submit"
                class="w-full sm:w-auto px-6 py-3 font-semibold text-white rounded-md 
               bg-gradient-to-r from-blue-600 to-blue-800
               hover:from-blue-700 hover:to-blue-900 
               transform hover:scale-105 transition-all duration-300 ease-in-out 
               shadow-md hover:shadow-lg">
                Book Now
            </button>

            <!-- Reset Button -->
            <button type="reset"
                class="w-full sm:w-auto px-6 py-3 text-black font-medium rounded-md 
               bg-gradient-to-r from-gray-200 to-gray-300 
               hover:from-gray-300 hover:to-gray-400 
               transform hover:scale-105 transition-all duration-300 ease-in-out 
               shadow hover:shadow-md">
                Reset
            </button>
        </div>

    </form>

    <!-- Custom Confirmation Modal -->
    <div id="confirmModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white p-6 rounded-xl shadow-2xl max-w-lg w-full mx-4 text-gray-800 space-y-4 animate-fadeIn">
            <h2 class="text-xl font-bold text-center text-blue-700">📋 Confirm Your Booking</h2>
            <div id="confirmMessage" class="text-sm whitespace-pre-line max-h-64 overflow-y-auto border p-3 rounded bg-gray-50"></div>
            <div class="flex justify-end gap-4 pt-4">
                <button id="cancelBtn" class="px-4 py-2 rounded-md bg-gray-300 hover:bg-gray-400">Back</button>
                <button id="continueBtn" class="px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700">Continue</button>
            </div>
        </div>
    </div>

    <?php include "footer.php"; ?>
    <script src="all-animation.js"></script>
    <script src="main.js"></script>
    <script src="confirm-model.js"></script>
</body>

</html>

<script>
    const turfPrices = {
        archery: 1500,
        badminton: 8000,
        baseball: 5000,
        basketball: 4500,
        cricket: 10000,
        football: 5000,
        golf: 1500,
        hockey: 3000,
        tennis: 2500,
        volleyball: 2000,
        javelin: 1000,
        "kho-kho": 1100
    };

    const GST_RATE = 0.18;

    const turfSelect = document.querySelector('select[name="turfs"]');
    const priceDisplay = document.createElement("div");
    priceDisplay.className = "text-lg font-semibold text-blue-700 mt-2";

    turfSelect.insertAdjacentElement("afterend", priceDisplay);

    turfSelect.addEventListener("change", function() {
        const turf = this.value;
        if (turfPrices[turf]) {
            const base = turfPrices[turf];
            const cgst = base * 0.09;
            const sgst = base * 0.09;
            const total = base + cgst + sgst;

            document.getElementById("cgst").value = cgst.toFixed(2);
            document.getElementById("sgst").value = sgst.toFixed(2);
            document.getElementById("total_price").value = total.toFixed(2);
        } else {
            document.getElementById("cgst").value = 0;
            document.getElementById("sgst").value = 0;
            document.getElementById("total_price").value = 0;
        }
    });
</script>