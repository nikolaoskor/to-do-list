<?php

// Add a new task for the user
function addTask($user_id, $description, $urgency, $type)
{
    $conn = connectDB();

    if ($type == 'note' || $type == 'to-do') {
        $insert_task_query = "INSERT INTO tasks (user_id, description, urgency, type) VALUES ('$user_id', '$description', '$urgency', '$type')";
        $conn->query($insert_task_query);

        $conn->close();

        header("Location: redirect.php");
        exit();
    }
}

// Delete a task based on task_id
function deleteTask($task_id)
{
    $conn = connectDB();
    $delete_task_query = "DELETE FROM tasks WHERE id='$task_id'";
    $conn->query($delete_task_query);
    $conn->close();
}

// Mark the status of a task
function markTaskStatus($task_id, $new_status)
{
    $conn = connectDB();
    $update_status_query = "UPDATE tasks SET status='$new_status' WHERE id='$task_id'";
    $conn->query($update_status_query);
    $conn->close();
}

// Toggle the status of a task (mark as done or in progress)
function toggleTaskStatus($task_id, $action)
{
    $conn = connectDB();

    if ($action == 'mark_done' || $action == 'mark_in_progress') {
        $get_status_query = "SELECT status FROM tasks WHERE id='$task_id'";
        $result = $conn->query($get_status_query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $current_status = $row['status'];

            if (($action == 'mark_done' && $current_status != 'done') || ($action == 'mark_in_progress' && $current_status != 'in_progress')) {
                $new_status = ($action == 'mark_done') ? 'done' : 'in_progress';
                $update_status_query = "UPDATE tasks SET status='$new_status' WHERE id='$task_id'";
                $conn->query($update_status_query);
            }
        }
    }

    $conn->close();
}

// Update the status of a task
function updateTaskStatus($task_id, $new_status)
{
    $conn = connectDB();
    $update_status_query = "UPDATE tasks SET status='$new_status' WHERE id='$task_id'";
    $conn->query($update_status_query);
    $conn->close();
}

// Retrieve tasks for a specific user
function getTasks($user_id)
{
    $conn = connectDB();
    $select_tasks_query = "SELECT id, description, urgency, CASE WHEN type = 'note' THEN 'Note' ELSE 'To-Do' END AS type, status FROM tasks WHERE user_id='$user_id'";
    $result_tasks = $conn->query($select_tasks_query);
    $conn->close();

    return $result_tasks;
}

// Edit the description of a task
function editTaskDescription($task_id, $new_description)
{
    $conn = connectDB();
    $new_description = $conn->real_escape_string($new_description);

    $edit_task_query = "UPDATE tasks SET description='$new_description' WHERE id='$task_id'";
    $conn->query($edit_task_query);

    $conn->close();
}

// Display user tasks
function DisplayUserTasks($result_tasks)
{
    $tasks = [];

    if ($result_tasks->num_rows > 0) {
        while ($row_task = $result_tasks->fetch_assoc()) {
            $task_id = $row_task['id'];
            $description = $row_task['description'];
            $urgency = $row_task['urgency'];
            $type = $row_task['type'];
            $status = $row_task['status'];

            $task_style = ($status == 'done') ? 'style="color: green;"' : '';

            $task = [
                'id' => $task_id,
                'description' => $description,
                'urgency' => $urgency,
                'type' => $type,
                'status' => $status,
                'style' => $task_style
            ];

            $tasks[] = $task;
        }
    }

    return $tasks;
}

// Display tasks or a message if no tasks are available
function displayTasksOrMessage($tasks)
{
    if (count($tasks) > 0) {
        foreach ($tasks as $task) {
            $task_id = $task['id'];
            $description = $task['description'];
            $urgency = $task['urgency'];
            $type = $task['type'];
            $status = $task['status'] === 'in_progress' ? 'in progress' : $task['status']; // Replace underscore with space
            $task_style = $task['style'];

            echo '<div class="task" ' . $task_style . '>';
            echo '<p style="text-align: left;">';

            $wrapped_description = chunk_split($description, 20, "<br />\n");
            echo $wrapped_description;

            echo '<br />(';
            echo 'Type: ' . $type . ', ';
            echo 'Status: ' . $status . ', ';
            echo 'Urgency: ' . $urgency;
            echo ')</p>';

            echo '<div class="task-buttons">';
            echo '<form action="" method="POST">';
            echo '<input type="hidden" name="task_id" value="' . $task_id . '">';
            echo '<input type="hidden" name="task_description" value="' . $description . '">';
            echo '<button type="button" class="edit-button" data-bs-toggle="modal" data-bs-target="#editModal" onclick="openEditModal(' . $task_id . ', \'' . $description . '\')">Edit</button>';

            echo '<button type="submit" class="delete-button" name="action" value="delete">Delete</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "<p>No tasks available.</p>";
    }
}

// Handles the submission of the form for adding a new task
function handleAddTaskFormSubmission()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task_description'])) {
        $user_id = $_SESSION['user_id'];
        $description = $_POST['task_description'];
        $urgency = $_POST['urgency'];
        $type = $_POST['type'];
        addTask($user_id, $description, $urgency, $type);
    }
}

// Handles the submission of the form for task actions (delete, mark done, mark in progress, edit)
function handleTaskActionFormSubmission()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
        $task_id = $_POST['task_id'];
        $action = $_POST['action'];

        if ($action == 'delete') {
            deleteTask($task_id);
        } elseif ($action == 'mark_done' || $action == 'mark_in_progress') {
            toggleTaskStatus($task_id, $action);
        } elseif ($action == 'edit') {
            $edited_description = $_POST['edited_description'];
            $edited_task_id = $_POST['task_id'];
            editTaskDescription($edited_task_id, $edited_description);
        }

        header("Location: redirect.php");
        exit();
    }
}

// Retrieve filtered tasks for a specific user
function getFilteredTasks($user_id, $filter_type, $filter_urgency, $filter_status)
{
    $conn = connectDB();

    $where_conditions = [];
    $where_conditions[] = "user_id='$user_id'";
    if (!empty($filter_type)) {
        $where_conditions[] = "type='$filter_type'";
    }
    if (!empty($filter_urgency)) {
        $where_conditions[] = "urgency='$filter_urgency'";
    }
    if (!empty($filter_status)) {
        $where_conditions[] = "status='$filter_status'";
    }

    $where_clause = '';
    if (!empty($where_conditions)) {
        $where_clause = ' WHERE ' . implode(' AND ', $where_conditions);
    }

    $select_tasks_query = "SELECT id, description, urgency, CASE WHEN type = 'note' THEN 'Note' ELSE 'To-Do' END AS type, status FROM tasks $where_clause";
    $result_tasks = $conn->query($select_tasks_query);
    $conn->close();

    return $result_tasks;
}

