<?php
session_start();

$alertScript = "";

include "db.php";


function clean($value, $conn)
{
    return mysqli_real_escape_string($conn, trim($value));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_SESSION['username'])) {

        $alertScript = "
        Swal.fire({
            icon: 'warning',
            title: 'User not logged in.'
        }).then(() => {
            window.location.href='login.php';
        });
        ";

    } else {

        $username = $_SESSION['username'];

        $user_query = mysqli_query(
            $conn,
            "SELECT user_id FROM signup WHERE username='$username'"
        );

        if (!$user_query || mysqli_num_rows($user_query) === 0) {

            $alertScript = "
            Swal.fire({
                icon: 'error',
                title: 'User not found.'
            }).then(() => {
                window.location.href='login.php';
            });
            ";

        } else {

            $user_data = mysqli_fetch_assoc($user_query);
            $user_id = $user_data['user_id'];

            $fullname = clean($_POST['fullname'] ?? '', $conn);
           $email = strtolower(clean($_POST['email'] ?? '', $conn));
            $address = clean($_POST['address'] ?? '', $conn);
            $mobile = clean($_POST['mobile'] ?? '', $conn);
            $state = clean($_POST['state'] ?? '', $conn);
            $city = clean($_POST['city'] ?? '', $conn);
            $pincode = clean($_POST['pincode'] ?? '', $conn);
            $date = clean($_POST['date'] ?? '', $conn);
            $turfs = clean($_POST['turfs'] ?? '', $conn);
            $payment = clean($_POST['payment_method'] ?? '', $conn);
            $time_slot = clean($_POST['time_slot'] ?? '', $conn);

            if (empty($time_slot)) {
                $alertScript = "
                Swal.fire({
                    icon: 'error',
                    title: 'Please select a time slot.'
                }).then(() => {
                    history.back();
                });
                ";
            } else {

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

                    $alertScript = "
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid turf selected.'
                    }).then(() => {
                        history.back();
                    });
                    ";

                } else {

                    $check_sql = "SELECT booking_id FROM ticket
 
                                  WHERE date='$date' 
                                  AND turfs='$turfs' 
                                  AND time_slot='$time_slot'";

                    $check_result = mysqli_query($conn, $check_sql);

                    if (!$check_result) {
                        die("SQL Error: " . mysqli_error($conn));
                    }

                    if (mysqli_num_rows($check_result) > 0) {


                        $alertScript = "
                        Swal.fire({
                            icon: 'error',
                            title: 'This time slot is already booked.'
                        }).then(() => {
                            history.back();
                        });
                        ";

                    } else {

                        $base_price = $turf_prices[$turfs];
                        $cgst = round($base_price * 0.09, 2);
                        $sgst = round($base_price * 0.09, 2);
                        $total_price = round($base_price + $cgst + $sgst, 2);

                        do {
                            $paymentRef = strtoupper($turfs) . rand(10000, 99999);
                            $refCheck = mysqli_query(
                                $conn,
                                "SELECT booking_id FROM ticket 
     WHERE payment_reference='$paymentRef'"
                            );

                        } while (mysqli_num_rows($refCheck) > 0);

                        $insert_sql = "INSERT INTO ticket (
                            user_id, username, fullname, email, address, mobile,
                            state, city, pincode, date, turfs, time_slot,
                            base_price, cgst, sgst, total_price,
                            payment_method, payment_reference
                        ) VALUES (
                            '$user_id','$username','$fullname','$email','$address','$mobile',
                            '$state','$city','$pincode','$date','$turfs','$time_slot',
                            '$base_price','$cgst','$sgst','$total_price',
                            '$payment','$paymentRef'
                        )";

                        if (mysqli_query($conn, $insert_sql)) {

                            $last_id = mysqli_insert_id($conn);

                            $alertScript = "
                            Swal.fire({
                                icon: 'success',
                                title: 'Booking Successful!',
                                html: 'Payment Reference: <b>$paymentRef</b>'
                            }).then(() => {
                                window.location.href='history.php?id=$last_id';
                            });
                            ";

                        } else {

                            $error = mysqli_error($conn);

                            $alertScript = "
                            Swal.fire({
                                icon: 'error',
                                title: 'Booking failed',
                                text: '$error'
                            }).then(() => {
                                history.back();
                            });
                            ";
                        }
                    }
                }
            }
        }
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
  <link rel="stylesheet" href="turf.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    <section>
    <div class="line-turf">
      <p>Home /</p>
      <p style="margin-left: 5px;"> Booking Details</p>
    </div>
  </section>

    <form method="POST" id="bookingForm" action="" class="max-w-2xl mx-auto rounded-2xl p-8 space-y-5 mt-10 mb-20"
        style="background-color:aliceblue;">
        <h2
            class="text-3xl font-bold text-center py-4 bg-gradient-to-r from-green-700 to-green-500
 rounded-t-xl text-white">
            Booking Details
        </h2>

        <div class="grid md:grid-cols-2 gap-6">

            <!-- Full Name (Alphabets & spaces only) -->
            <input type="text" name="fullname" placeholder="Full Name" required
                oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')"
                class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600
 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out" />

<input type="email" name="email" placeholder="Email" required
    oninput="this.value = this.value.toLowerCase();"
        style="text-transform: lowercase;"
    autocapitalize="none"
    spellcheck="false"
    class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600
 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out" />



            <!-- Mobile (Exactly 10 digits) -->
            <input type="text" name="mobile" placeholder="Mobile Number" required
                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10); this.setCustomValidity(this.value.length < 10 ? 'Enter a valid 10-digit number' : '')"
                maxlength="10" pattern="\d{10}"
                class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600
 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out" />

            <!-- State (Alphabets & spaces only) -->
            <input type="text" name="state" placeholder="State" required
                oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')"
                class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600
 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out" />

            <!-- City (Alphabets & spaces only) -->
            <input type="text" name="city" placeholder="City" required
                oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')"
                class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600
 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out" />

            <!-- Pincode (Exactly 6 digits only) -->
            <input type="text" name="pincode" placeholder="Pincode" required
                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6); this.setCustomValidity(this.value.length < 6 ? 'Pincode must be 6 digits' : '')"
                maxlength="6" pattern="\d{6}"
                class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600
 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out" />

            <input type="text" name="address" placeholder="Address" required
                class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600
 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out" />


            <input type="date" name="date" required min="<?php echo date('Y-m-d'); ?>"
                class="w-full px-4 py-3 border rounded-md outline-none appearance-none text-black focus:ring-2 focus:ring-green-500 focus:border-green-600
 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out" />
            

        </div>

        <select name="turfs" required
            class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600
 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out">
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


<div class="mb-6">
    <label class="font-semibold text-gray-700 block mb-2">
        Select Time Slot
    </label>

    <div id="timeSlots"
         class="grid grid-cols-4 md:grid-cols-6 gap-2">
    </div>

    <input type="hidden" name="time_slot" id="selectedSlot" required>
</div>


        <select name="payment_method" id="payment_method" required
            class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600
 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out"
            style="margin-top: 10px;">
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
                class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600
 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out"
                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,12);" />

            <!-- Cardholder Name: alphabets only -->
            <input type="text" name="cardholdername" placeholder="Cardholder Name" pattern="[A-Za-z ]{2,}" required
                title="Cardholder name must contain only letters and spaces"
                class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600
 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out"
                oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '');" />

            <!-- Expiry Date: MM/YY format -->
            <input type="text" name="expiry" placeholder="Expiry (MM/YY)" maxlength="5" required oninput="
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
  " title="Enter expiry in MM/YY format (e.g., 08/26). Cannot be past date." pattern="^(0[1-9]|1[0-2])\/\d{2}$"
                class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600
 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out" />

            <!-- CVV: 3-digit numeric -->
            <input type="text" name="cvv" placeholder="CVV" maxlength="3" required title="CVV must be 3 digits"
                class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600
 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out"
                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,3);" />

        </div>


        <!-- UPI Field -->
        <div id="upi_fields" class="hidden">
            <input type="text" name="upi" placeholder="UPI ID" required pattern="[a-zA-Z0-9._\-]+@[a-zA-Z]+"
                title="Enter a valid UPI ID (e.g., prince@upi)"
                class="w-full px-4 py-3 border rounded-md outline-none focus:ring-2 focus:ring-green-500 focus:border-green-600
 focus:scale-105 focus:shadow-lg transition-all duration-300 ease-in-out"
                oninput="this.value = this.value.replace(/[^a-zA-Z0-9._\-@]/g,'');" />
        </div>



        <div class="flex flex-col sm:flex-row gap-4 justify-between pt-4">
            <!-- Book Now Button -->
            <div class="pt-4 flex justify-start">
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
</div>


            <!-- Reset Button -->
<div class="pt-4 flex justify-start">
      <button type="reset" name="add_to_cart"  class="cssbuttons-io-button">
        RESET FORM
        <div class="icon1">
            <svg height="24" width="24" viewBox="0 0 24 24">
                <path d="M0 0h24v24H0z" fill="none"></path>
                <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                      fill="currentColor"></path>
            </svg>
        </div>
    </button>
</div>

        </div>

    </form>

    <!-- Custom Confirmation Modal -->
    <div id="confirmModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white p-6 rounded-xl shadow-2xl max-w-lg w-full mx-4 text-gray-800 space-y-4 animate-fadeIn">
            <h2 class="text-xl font-bold text-center text-green-700">📋 Confirm Your Booking</h2>
            <div id="confirmMessage"
                class="text-sm whitespace-pre-line max-h-64 overflow-y-auto border p-3 rounded bg-gray-50"></div>
            <div class="flex justify-end gap-4 pt-4">
                <button id="cancelBtn" class="px-4 py-2 rounded-md bg-gray-300 hover:bg-gray-400">Back</button>
                <button id="continueBtn"
                    class="px-4 py-2 rounded-md bg-green-600 text-white hover:bg-green-700
">Continue</button>
            </div>
        </div>
    </div>

    <?php include "footer.php"; ?>
    <script src="all-animation.js"></script>
    <script src="main.js"></script>
    <script src="confirm-model.js"></script>
    <?php if (!empty($alertScript)): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                <?php echo $alertScript; ?>
            });
        </script>
    <?php endif; ?>

</body>

</html>

<script>
document.addEventListener("DOMContentLoaded", function () {

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

    const turfSelect = document.querySelector('select[name="turfs"]');
    const dateInput = document.querySelector('input[name="date"]');
    const timeSlotsDiv = document.getElementById("timeSlots");
    const selectedSlotInput = document.getElementById("selectedSlot");

    const form = document.getElementById("bookingForm");
    const confirmModal = document.getElementById("confirmModal");
    const confirmMessage = document.getElementById("confirmMessage");
    const cancelBtn = document.getElementById("cancelBtn");
    const continueBtn = document.getElementById("continueBtn");

    // -------- PRICE DISPLAY --------

    const priceDisplay = document.createElement("div");
    priceDisplay.className = "text-lg font-semibold text-green-700 mt-2";
    turfSelect.insertAdjacentElement("afterend", priceDisplay);

    turfSelect.addEventListener("change", function () {
        const turf = this.value;

        if (turfPrices[turf]) {
            const base = turfPrices[turf];
            const cgst = base * 0.09;
            const sgst = base * 0.09;
            const total = base + cgst + sgst;

            priceDisplay.innerHTML = `
                Base: ₹${base} <br>
                CGST: ₹${cgst.toFixed(2)} <br>
                SGST: ₹${sgst.toFixed(2)} <br>
                Total: ₹${total.toFixed(2)}
            `;
        } else {
            priceDisplay.innerHTML = "";
        }

        fetchBookedSlots();
    });

    // -------- GENERATE 24 HOUR SLOTS --------

    function generateSlots() {
        const slots = [];

        for (let i = 0; i < 24; i++) {
            let start = new Date(0, 0, 0, i);
            let end = new Date(0, 0, 0, i + 1);

            const options = { hour: '2-digit', minute: '2-digit', hour12: true };

            const startTime = start.toLocaleTimeString('en-US', options);
            const endTime = end.toLocaleTimeString('en-US', options);

            slots.push(`${startTime} - ${endTime}`);
        }

        return slots;
    }

    const allSlots = generateSlots();

   function loadSlots(bookedSlots = []) {

    timeSlotsDiv.innerHTML = "";

    const selectedDate = dateInput.value;
    const today = new Date();
    const currentHour = today.getHours();

    const normalizedBooked = bookedSlots.map(s => s.trim());

    allSlots.forEach((slot, index) => {

        const btn = document.createElement("button");
        btn.type = "button";
        btn.textContent = slot;
        btn.className = "p-2 border rounded text-xs";

        const isToday = selectedDate === today.toISOString().split('T')[0];
        const isPastHour = isToday && index <= currentHour;

        if (normalizedBooked.includes(slot.trim()) || isPastHour) {

            btn.classList.add("bg-red-500", "text-white", "cursor-not-allowed");
            btn.disabled = true;

        } else {

            btn.classList.add("bg-green-500", "text-white");

            btn.onclick = () => {

                selectedSlotInput.value = slot;

                document.querySelectorAll("#timeSlots button")
                    .forEach(b => b.classList.remove("ring-4", "ring-green-500"));

                btn.classList.add("ring-4", "ring-green-500");
            };
        }

        timeSlotsDiv.appendChild(btn);
    });
}

    // -------- FETCH BOOKED SLOTS --------

function fetchBookedSlots() {

    const date = dateInput.value;
    const turf = turfSelect.value;

    if (!date || !turf) {
        loadSlots(); // show all slots if not selected
        return;
    }

    fetch("get_booked_slots.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `date=${date}&turf=${turf}`
    })
    .then(res => res.json())
    .then(data => loadSlots(data))
    .catch(error => {
        console.error("Error:", error);
        loadSlots(); // fallback
    });
}

    // -------- CONFIRMATION MODAL --------

    form.addEventListener("submit", function (e) {

        e.preventDefault();

        const date = dateInput.value;
        const turf = turfSelect.value;
        const slot = selectedSlotInput.value;

        if (!slot) {
            alert("Please select a time slot");
            return;
        }

        confirmMessage.innerHTML = `
            <strong>Date:</strong> ${date}<br>
            <strong>Turf:</strong> ${turf}<br>
            <strong>Time Slot:</strong> ${slot}
        `;

        confirmModal.classList.remove("hidden");
    });

    cancelBtn.addEventListener("click", function () {
        confirmModal.classList.add("hidden");
    });

    continueBtn.addEventListener("click", function () {
        confirmModal.classList.add("hidden");
        form.submit();
    });

});
</script>
