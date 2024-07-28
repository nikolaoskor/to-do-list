<?php
// Save the profile picture filename in the database
function saveProfilePicture($user_id, $file_name) {
    $conn = connectDB();
    $update_query = "UPDATE users SET profile_picture='$file_name' WHERE id='$user_id'";
    $conn->query($update_query);
    $conn->close();
}

// Upload and update the profile picture for a user
function uploadProfilePicture($user_id, $file) {
    $conn = connectDB();

    if (!file_exists('uploads')) {
        mkdir('uploads', 0777, true);
    }

    // Extract the file extension (e.g., jpg, png)
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $original_file_name = pathinfo($file['name'], PATHINFO_FILENAME);
    $new_file_name = $original_file_name . '.' . $file_extension;
    $target_file = 'uploads/' . $new_file_name;

    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        $update_query = "UPDATE users SET profile_picture='$new_file_name' WHERE id='$user_id'";
        if ($conn->query($update_query)) {
            $conn->close();
            saveProfilePicture($user_id, $new_file_name);
            return $new_file_name;
        } else {
            $conn->close();
            return false;
        }
    } else {
        $conn->close();
        return false;
    }
}

function handleChangeProfilePicture() {
    if (isset($_POST['action']) && $_POST['action'] == 'change_profile_picture') {
        if (isset($_FILES['profile_picture'])) {
            $file = $_FILES['profile_picture'];
            $upload_result = uploadProfilePicture($_SESSION['user_id'], $file);

            if ($upload_result !== false) {
                $_SESSION['user_profile_picture'] = $upload_result;
            }
        }
    }
}