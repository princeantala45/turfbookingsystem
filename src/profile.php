<?php
session_start();


include "db.php";



if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

$username = $_SESSION['username'];

$alertType = "";
$alertMessage = "";

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $email    = mysqli_real_escape_string($conn, $_POST['email']);
  $mobile   = mysqli_real_escape_string($conn, $_POST['mobile']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  // ✅ This was missing
  $update_sql = "UPDATE signup 
                 SET email='$email', mobile='$mobile', password='$password' 
                 WHERE username='$username'";

  if (mysqli_query($conn, $update_sql)) {
      $alertType = "success";
      $alertMessage = "Profile updated successfully!";
  } else {
      $alertType = "error";
      $alertMessage = "Failed to update profile: " . mysqli_error($conn);
  }
}

// Fetch user data
$sql = "SELECT * FROM signup WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>USER PROFILE | TURFBOOKING SYSTEM</title>
  <link href="./output.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="shortcut icon" href="./gallery/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="turf.css">
</head>
<style>
    input, label, textarea {
  text-transform: none !important;
}
</style>
<body class="">

  <?php include "header.php"; ?>
    <section>
        <div class="line-turf">
            <p>Home /</p>
            <p style="margin-left: 5px;"> Profile</p>
        </div>
     </section>

  <div class="max-w-xl mx-auto m-20 p-8" style="border: 1px dotted;
  border-radius:20px;">
    <h2 class="text-3xl font-bold mb-6 text-blue-600 text-center">👤 My Profile</h2>

    <form method="POST" id="profileForm" class="space-y-5 text-lg">
      <div>
        <label class="font-semibold block mb-1">Username</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" disabled
          class="w-full px-4 py-2 border rounded bg-gray-200 cursor-not-allowed">
      </div>

      <div>
        <label class="font-semibold block mb-1">Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required disabled
          class="w-full px-4 py-2 border rounded bg-gray-200">
      </div>

      <div>
        <label class="font-semibold block mb-1">Mobile</label>
        <input type="text" name="mobile" value="<?= htmlspecialchars($user['mobile']) ?>" required disabled
          class="w-full px-4 py-2 border rounded bg-gray-200">
      </div>

      <div><label class="font-semibold block mb-1">Password</label>
<input 
  type="text" 
  name="password" 
  id="password"
  value="<?= htmlspecialchars($user['password']) ?>" disabled
  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" 
  required 
class="w-full px-4 py-2 border rounded bg-gray-200"/>

 <ul id="passwordmsg" class="text-sm space-y-1 mt-5">
  <li id="length" class="text-gray-500">• At least 8 characters</li>
  <li id="uppercase" class="text-gray-500">• One uppercase letter</li>
  <li id="lowercase" class="text-gray-500">• One lowercase letter</li>
  <li id="number" class="text-gray-500">• One number</li>
  <li id="special" class="text-gray-500">• One special character (@,#,$,&,...)</li>
</ul>
      </div>
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

      <div class="flex justify-between mt-6">
        <a href="index.php" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">🏠 Home</a>

        <!-- Edit Button -->
        <button type="button" id="editBtn"
          class="px-6 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">✏️ Edit</button>

        <!-- Save Button (hidden initially) -->
        <button type="submit" id="saveBtn"
          class="hidden px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">💾 Save</button>

        <a href="logout.php" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">🔓 Logout</a>
      </div>
    </form>
  </div>

  <?php include "footer.php"; ?>

  <script>
  document.getElementById("editBtn").addEventListener("click", function () {
    const form = document.getElementById("profileForm");

    // Enable all inputs except username
    const inputs = form.querySelectorAll("input");
    inputs.forEach(input => {
      if (input.name !== "username") {
        input.disabled = false;
        input.classList.remove("bg-gray-200", "cursor-not-allowed");
        input.classList.add("bg-white");
      }
    });

    // Show Save button
    document.getElementById("saveBtn").classList.remove("hidden");

    // Disable Edit button
    this.disabled = true;
    this.classList.add("opacity-50", "cursor-not-allowed");
  });
</script>
  
  <script src="main.js"></script>
  <?php if (!empty($alertMessage)) : ?>
<script>
Swal.fire({
    icon: '<?= $alertType ?>',
    title: '<?= $alertType === "success" ? "Success" : "Error" ?>',
    text: '<?= $alertMessage ?>',
    confirmButtonColor: '#2563eb'
}).then(() => {
    <?php if ($alertType === "success") : ?>
        window.location.href = "profile.php";
    <?php endif; ?>
});
</script>
<?php endif; ?>

</body>
</html>
