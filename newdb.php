<?php
$host = "localhost"; // Change if your database is hosted elsewhere
$user = "root"; // Default user for XAMPP is 'root'
$pass = ""; // Default password for XAMPP is empty
$dbname = "project"; // Change this to your actual database name

// Create connection
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
