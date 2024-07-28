<?php

function loginUser($email, $password)
{
    $conn = connectDB();

    $sql = "SELECT id, name FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);
    $conn->close();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        header("Location: main.php");
        exit();
    } else {
        $error_message = "Invalid email or password";
        return $error_message;
    }

}


