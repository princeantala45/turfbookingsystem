<?php

include "db.php";




// Handle user deletion
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM signup WHERE user_id = $id");
    header("Location: admin_user.php");
    exit();
}

$users = mysqli_query($conn, "SELECT * FROM signup");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ALL USERS | ADMIN</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="shortcut icon" href="./gallery/favicon.png" type="image/x-icon">

</head>
<body class="bg-gradient-to-br from-gray-100 to-blue-100 text-gray-800 min-h-screen">

  <div class="max-w-6xl mx-auto py-10 px-6">
    <div class="bg-white p-8 rounded-xl shadow-xl">
      <h1 class="text-3xl font-bold mb-6 text-center text-indigo-700">👥 All Registered Users</h1>

      <div class="overflow-x-auto">
        <table class="min-w-full text-sm border border-gray-300 rounded-lg shadow">
          <thead class="bg-indigo-100 text-indigo-800">
            <tr>
              <th class="py-3 px-4 border">User_id</th>
              <th class="py-3 px-4 border">Username</th>
              <th class="py-3 px-4 border">Email</th>
              <th class="py-3 px-4 border">Mobile</th>
              <th class="py-3 px-4 border">Password</th>
              <th class="py-3 px-4 border">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($users)) : ?>
              <tr class="hover:bg-gray-50 transition">
                <td class="py-2 px-4 border"><?= htmlspecialchars($row['user_id']) ?></td>
                <td class="py-2 px-4 border"><?= htmlspecialchars($row['username']) ?></td>
                <td class="py-2 px-4 border"><?= htmlspecialchars($row['email']) ?></td>
                <td class="py-2 px-4 border"><?= htmlspecialchars($row['mobile']) ?></td>
                <td class="py-2 px-4 border text-red-600"><?= htmlspecialchars($row['password']) ?></td>
                <td class="py-2 px-4 border text-center">
                  <a href="?delete=<?= $row['user_id'] ?>" 
                     onclick="return confirm('Are you sure you want to delete this user?')"
                     class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs shadow">
                    Delete
                  </a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>

      <div class="text-center mt-6">
        <a href="admin_dashboard.php" class="inline-block text-indigo-600 hover:underline">← Back to Dashboard</a>
      </div>
    </div>
  </div>

</body>
</html>
