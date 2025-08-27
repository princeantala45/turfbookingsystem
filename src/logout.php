<?php
// logout.php
// This script handles both logout confirmation and session destruction

// Start the session
session_start();

// Check if the user has confirmed the logout via the query string
if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    // Destroy session if the user has confirmed the logout
    session_unset();
    session_destroy();

    // Alert the user and redirect to the login page
    echo "<script>
        alert('Logout successful');
        window.location.href = 'login.php'; // Redirect to login page after logout
    </script>";
    exit();
} else {
    // If the user hasn't confirmed the logout, show a confirmation dialog
    echo "<script>
        if (confirm('Are you sure you want to log out?')) {
            // If the user confirms, redirect with 'confirm=yes' to logout
            window.location.href = 'logout.php?confirm=yes'; 
        } else {
            // If the user cancels, redirect to index.php (or any page you want)
            window.location.href = 'index.php'; 
        }
    </script>";
    exit();
}
?>
 