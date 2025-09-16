<?php

session_start();
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "project";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Redirect to admin_user.php when accessing the root directory
if ($_SERVER['REQUEST_URI'] == "/" || basename($_SERVER['PHP_SELF']) == "index.php") {
    header("Location: admin_user.php");
    exit();
}
?>

