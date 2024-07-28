<?php
session_start();
include 'functions/functionsdb.php';
include 'functions/functionslogin.php';

// Process login form submission if POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['pass'];

    // Attempt to log in user
    $error_message = loginUser($email, $password);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link href="styles/styleslogin.css" rel="stylesheet">
    <title>To-Do Home</title>
</head>

<body>
    <div class="container mt-5 pt-5 text-center">
        <h1>TO DO WEBSITE</h1>
        <p>The best website for TO-DO lists! Sign up or log in now!</p>

        <!-- Login form -->
        <form action="" method="POST">
            <input type="text" class="input" name="email" id="email" placeholder="Email address">
            </br>
            <input type="password" class="input" name="pass" id="pass" placeholder="Password">
            </br>
            <button type="submit" class="login-button">Log in</button>
        </form>

        <?php
        if (isset($error_message)) {
            echo "<p style='color:red;'>$error_message</p>";
        }
        ?>

        <button onclick="location.href='register.php'" class="register-button">Create new account</button>

        <video autoplay muted loop>
            <source src="uploads/golden.mp4" type="video/mp4">
        </video>
    </div>
</body>

</html>