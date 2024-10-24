<?php
session_start();

if (!isset($_SESSION['authenticated_regular'])) {
    $_SESSION['status'] = "ERROR: Please login to access dashboard.";
    header('Location: login.php');
    exit(0);
} else if (isset($_SESSION['authenticated_admin'])) {
    // Redirecting to admin page is fine, but check for correct target
    if ($_SERVER['PHP_SELF'] !== '/admin.php') {
        $_SESSION['status'] = "ERROR: You are already admin.";
        header('Location: admin.php');
        exit(0);
    }
}

?>