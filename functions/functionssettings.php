<?php

// Changes the user's name
function changeName($user_id, $new_name)
{
    $conn = connectDB();
    $new_name = $conn->real_escape_string($new_name);

    $update_name_query = "UPDATE users SET name='$new_name' WHERE id='$user_id'";
    $conn->query($update_name_query);

    $conn->close();
}

// Changes the user's email
function changeEmail($user_id, $new_email)
{
    $conn = connectDB();
    $new_email = $conn->real_escape_string($new_email);

    $update_email_query = "UPDATE users SET email='$new_email' WHERE id='$user_id'";
    $conn->query($update_email_query);

    $conn->close();
}

// Changes the user's password
function changePassword($user_id, $new_password)
{
    $conn = connectDB();
    $new_password = $conn->real_escape_string($new_password);

    $update_password_query = "UPDATE users SET password='$new_password' WHERE id='$user_id'";
    $conn->query($update_password_query);

    $conn->close();
}

// Deletes the user's account
function deleteAccount($user_id)
{
    $conn = connectDB();

    $delete_tasks_query = "DELETE FROM tasks WHERE user_id='$user_id'";
    $conn->query($delete_tasks_query);

    $delete_user_query = "DELETE FROM users WHERE id='$user_id'";
    $conn->query($delete_user_query);

    session_destroy();
    header("Location: login.php");
    exit();
}

// Handles the form submission
function handleFormSubmission($user_id)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['change_name'])) {
            handleNameFormSubmission($user_id);
        } elseif (isset($_POST['change_email'])) {
            handleEmailFormSubmission($user_id);
        } elseif (isset($_POST['change_password'])) {
            handlePasswordFormSubmission($user_id);
        } elseif (isset($_POST['delete_account'])) {
            handleDeleteAccountFormSubmission($user_id);
        }
    }
}

// Handles the form submission for changing the name
function handleNameFormSubmission($user_id)
{
    if (!empty($_POST['new_name'])) {
        $new_name = $_POST['new_name'];
        changeName($user_id, $new_name);
        header("Location: settings.php");
        exit();
    }
}

// Handles the form submission for changing the email
function handleEmailFormSubmission($user_id)
{
    if (!empty($_POST['new_email'])) {
        $new_email = $_POST['new_email'];
        changeEmail($user_id, $new_email);
        header("Location: settings.php");
        exit();
    }
}

// Handles the form submission for changing the password
function handlePasswordFormSubmission($user_id)
{
    if (!empty($_POST['new_password'])) {
        $new_password = $_POST['new_password'];
        changePassword($user_id, $new_password);
        header("Location: settings.php");
        exit();
    }
}

// Handles the form submission for deleting the account
function handleDeleteAccountFormSubmission($user_id)
{
    deleteAccount($user_id);
}
