<?php

// Check if a user with the given email already exists
function checkUserExists($email)
{
    $conn = connectDB();
    $check_user_query = "SELECT * FROM users WHERE email='$email'";
    $check_user_result = $conn->query($check_user_query);

    if (!$check_user_result) {
        echo "Error in checkUserExists: " . $conn->error;
    }

    $conn->close();

    return ($check_user_result->num_rows > 0);
}

// Insert a new user into the database with gender and default profile picture information
function insertUserWithGenderAndDefaultPicture($name, $email, $password, $gender, $default_profile_picture)
{
    $conn = connectDB();
    $insert_user_query = "INSERT INTO users (name, email, password, gender, profile_picture) VALUES ('$name', '$email', '$password', '$gender', '$default_profile_picture')";

    if ($conn->query($insert_user_query) === TRUE) {
        $conn->close();
        return true;
    } else {
        echo "Error in insertUserWithGenderAndDefaultPicture: " . $conn->error;
        $conn->close();
        return false;
    }
}

// Process registration form submission if POST request
function processRegistrationForm()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $gender = $_POST['gender'];
        $error_message = "";

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if (checkUserExists($email)) {
                $error_message = "Email already exists. Please choose a different one.";
            } else {
                $default_profile_picture = ($gender == 'Male') ? 'male.png' : 'female.png';

                if (insertUserWithGenderAndDefaultPicture($name, $email, $password, $gender, $default_profile_picture)) {
                    $_SESSION['user_name'] = $name;
                    header("Location: main.php");
                    exit();
                } else {
                    $error_message = "Error creating user.";
                }
            }
        } else {
            $error_message = "Invalid email format. Please enter a valid email address.";
        }
    }
}

?>