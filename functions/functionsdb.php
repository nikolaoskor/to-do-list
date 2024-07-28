<?php
function connectDB()
{
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "dbtodo";

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>