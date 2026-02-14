<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Logout</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php

if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {

    session_unset();
    session_destroy();

    echo "
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Logout Successful'
        }).then(function() {
            window.location.href = 'login.php';
        });
    </script>";
    exit();

} else {

    echo "
    <script>
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to log out?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Logout',
            cancelButtonText: 'Cancel'
        }).then(function(result) {
            if (result.isConfirmed) {
                window.location.href = 'logout.php?confirm=yes';
            } else {
                window.location.href = 'index.php';
            }
        });
    </script>";
    exit();
}
?>

</body>
</html>
