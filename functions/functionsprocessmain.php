<?php

// Retrieve user data based on user_id
function getUserData($user_id) {
    $conn = connectDB();
    $select_user_query = "SELECT * FROM users WHERE id='$user_id'";
    $result = $conn->query($select_user_query);

    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        $conn->close();
        return $user_data;
    } else {
        $conn->close();
        return null;
    }
}

// Redirects the user to the login page if not logged in
function redirectIfNotLoggedIn() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

// Main processing function that orchestrates the different actions
function processMainCode() {
    redirectIfNotLoggedIn();
    $user_data = getUserData($_SESSION['user_id']);
    handleAddTaskFormSubmission();
    handleTaskActionFormSubmission();
}

?>