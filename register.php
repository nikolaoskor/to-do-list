<?php
session_start();
include 'functions/functionsdb.php';
include 'functions/functionsregister.php';

function registerUser()
{
    processRegistrationForm();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    registerUser();
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
    <link href="styles/stylesregister.css" rel="stylesheet">
    <title>To-Do Register</title>
</head>

<body>
    <div class="container mt-5 pt-5 text-center">
        <h1>TO DO WEBSITE</h1>
        <p>Create a new account to start organizing your tasks!</p>
        <h3>Sign Up</h3>
        <p>It's quick and easy.</p>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <label>Name<br>
                <input type="text" class="input" name="name" placeholder="Name" required>
            </label>
            <br />

            <label>Email<br>
                <input type="text" class="input" name="email" placeholder="Email" required>
            </label>
            <br />

            <label>Password<br>
                <input type="password" class="input" name="password" placeholder="Password" required>
            </label>
            <br />

            <label>Gender</label><br />
            <select name="gender" class="input" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>

            <br />

            <button type="submit" class="register-button">Register</button>
        </form>

        <!-- Display error message (if any) -->
        <?php if (isset($error_message)): ?>
            <p style="color: red;">
                <?php echo $error_message; ?>
            </p>
        <?php endif; ?>

        <button onclick="location.href='login.php'" class="login-button">Already have an account? <br>Log in</button>

        <video autoplay muted loop>
            <source src="uploads/golden.mp4" type="video/mp4">
        </video>
    </div>
</body>

</html>