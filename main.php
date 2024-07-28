<?php

session_start();
include 'functions/functionsdb.php';
include 'functions/functionsprocessmain.php';
include 'functions/functionsphoto.php';
include 'functions/functionstasks.php';

handleChangeProfilePicture();

function maincode()
{
    processMainCode();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    maincode();
}

// Get all tasks for the user
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $all_tasks = getTasks($user_id);

    $user_data = getUserData($user_id);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $filter_type = $_POST['filter_type'] ?? '';
        $filter_urgency = $_POST['filter_urgency'] ?? '';
        $filter_status = $_POST['filter_status'] ?? '';

        $filtered_tasks = getFilteredTasks($user_id, $filter_type, $filter_urgency, $filter_status);
        $tasks_to_display = DisplayUserTasks($filtered_tasks);
    } else {
        $tasks_to_display = DisplayUserTasks($all_tasks);
    }
} else {
    header("Location: login.php");
    exit();
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
    <title>Home</title>
    <link href="styles/stylesmain.css" rel="stylesheet">
</head>

<body style="overflow: auto;">

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">
            <?php
            // Display user profile picture
            if ($user_data['profile_picture'] != null) {
                echo '<img src="uploads/' . $user_data['profile_picture'] . '" alt="Profile Picture" style="max-width: 30px; max-height: 30px; border-radius: 50%;">';
            }
            ?>
            Welcome,
            <?php echo $_SESSION['user_name']; ?>!
        </a>

        <!-- Navbar toggle button for mobile view -->
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item ms-2 me-2">
                    <a class="nav-link" href="settings.php">Settings</a>
                </li>
                <li class="nav-item me-2">
                    <a class="nav-link" href="logout.php">Log Out</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5 pt-5 text-center">
        <div class="row align-items-center">
            <!-- Display user profile picture on the left side -->
            <div class="col-md-4 profile-container">
                <?php
                if ($user_data['profile_picture'] != null) {
                    echo '<img src="uploads/' . $user_data['profile_picture'] . '" alt="Profile Picture" class="profile-picture">';
                }
                ?>
                <button type="button" class="changephoto-button" data-bs-toggle="modal"
                    data-bs-target="#profilePictureModal"> Photo Profile </button>
            </div>
            <!-- Form for adding a new task on the right side -->
            <div class="col-md-8">
                <p>Add a new task:</p>
                <form action="" method="POST">
                    <label>Task Description</label><br>
                    <input type="text" class="input" name="task_description" placeholder="Task Description" required>
                    <br />

                    <label>Type</label><br>
                    <select name="type" class="input" required>
                        <option value="note">Note</option>
                        <option value="to-do">To-Do</option>
                    </select>
                    <br />

                    <label>Urgency</label><br>
                    <select name="urgency" class="input" required>
                        <option value="normal">Normal</option>
                        <option value="urgent">Urgent</option>
                    </select>
                    <br />

                    <button type="submit" class="addtask-button">Add Task</button>
                </form>
            </div>
        </div>
        <hr>

        <!-- Form for filtering tasks -->
        <form action="" method="POST" class="mb-3">
            <label>Type:</label>
            <select name="filter_type">
                <option value="">All</option>
                <option value="note">Note</option>
                <option value="to-do">To-Do</option>
            </select>

            <label>Urgency:</label>
            <select name="filter_urgency">
                <option value="">All</option>
                <option value="normal">Normal</option>
                <option value="urgent">Urgent</option>
            </select>

            <label>Status:</label>
            <select name="filter_status">
                <option value="">All</option>
                <option value="in_progress">In Progress</option>
                <option value="done">Done</option>
            </select>
            <button type="submit" class="btn btn-primary">Apply</button>
        </form>
        <hr>
        <?php
        displayTasksOrMessage($tasks_to_display);
        ?>
    </div>

    <!-- Modal for Editing -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <input type="hidden" name="task_id" id="editTaskId">
                        <label for="editedDescription">New Task Description:</label>
                        <input type="text" class="form-control" name="edited_description" id="editedDescription"
                            required>
                        <br>
                        <button type="submit" class="btn btn-success" name="action" value="mark_done">Done</button>
                        <button type="submit" class="btn btn-warning" name="action" value="mark_in_progress">In
                            Progress</button>
                        <button type="submit" class="btn btn-primary" name="action" value="edit">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for changing profile picture -->
    <div class="modal fade" id="profilePictureModal" tabindex="-1" aria-labelledby="profilePictureModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profilePictureModalLabel">Change Profile Photo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <label for="profilePicture">Choose a new profile photo:</label>
                        <input type="file" class="form-control" name="profile_picture" id="profilePicture"
                            accept="image/*" required>
                        <br>
                        <button type="submit" class="btn btn-primary" name="action" value="change_profile_picture">Save
                            Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <video autoplay muted loop>
        <source src="uploads/golden.mp4" type="video/mp4">
    </video>

    <!-- Open Edit Modal -->
    <script>
        function openEditModal(taskId, taskDescription) {
            document.getElementById('editTaskId').value = taskId;
            document.getElementById('editedDescription').value = taskDescription;
        }
    </script>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>