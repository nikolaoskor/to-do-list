<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, do not perform any further redirections
    header("Location: login.php");
    exit();
}

// If the user is logged in, proceed with the logout process
session_unset();
session_destroy();
header("Location: login.php");
exit();
?>