<?php
session_start();
include 'functions/functionsdb.php';
include 'functions/functionssettings.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = connectDB();
$user_id = $_SESSION['user_id'];

// Error checking
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    handleFormSubmission($user_id);
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link href="styles/stylessettings.css" rel="stylesheet">
    <title>Settings</title>
</head>

<body style="overflow: auto;">

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <!-- Navbar toggle button for mobile view -->
        <button class="navbar-toggler ms-auto " type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item ms-2 me-2">
                    <a class="nav-link" href="main.php">Home</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item me-2">
                    <a class="nav-link" href="logout.php">Log Out</a>
                </li>
            </ul>
        </div>

    </nav>

    <div class="container mt-5 pt-5 text-center">
        <h1>Settings</h1>
        <p>Change your details!</p>

        <form action="" method="POST">
            <label>Change Name:</label>
            <input type="text" name="new_name" placeholder="New Name">
            <button type="submit" name="change_name">Change Name</button>
        </form>

        <form action="" method="POST">
            <label>Change Email:</label>
            <input type="email" name="new_email" placeholder="New Email">
            <button type="submit" name="change_email">Change Email</button>
        </form>

        <form action="" method="POST">
            <label>Change Password:</label>
            <input type="password" name="new_password" placeholder="New Password">
            <button type="submit" name="change_password">Change Password</button>
        </form>
        <hr>

        <form action="" method="POST">
            <label>Delete Account:</label>
            <button type="submit" class="delete_account" name="delete_account">Delete Account</button>
        </form>

        <video autoplay muted loop>
            <source src="uploads/golden.mp4" type="video/mp4">
        </video>
    </div>
</body>

</html>