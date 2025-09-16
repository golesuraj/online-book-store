<?php
// Database connection
$host = "localhost"; // Change if needed
$user = "root";      // Your DB username
$pass = "";          // Your DB password
$dbname = "project"; // Your database name

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

// Prevent SQL injection
$name = $conn->real_escape_string($name);
$email = $conn->real_escape_string($email);
$subject = $conn->real_escape_string($subject);
$message = $conn->real_escape_string($message);

// Insert into database
$sql = "INSERT INTO contact (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";

if ($conn->query($sql) === TRUE) {
    echo "Message sent successfully!";
} else {
    echo "Error: " . $conn->error;
}

// Close connection
$conn->close();
?>
