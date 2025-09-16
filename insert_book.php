<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'server.php'; // Database connection

if (isset($_POST['submit'])) {
    // Retrieve and sanitize form data
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $stock = 10; // Default stock value

    // Ensure uploads directory exists
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Check if file is uploaded
    if (!isset($_FILES['image']) || $_FILES['image']['error'] != UPLOAD_ERR_OK) {
        die("Error: Image upload failed. Please select a valid image.");
    }

    $image_name = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

    // Allowed image formats (including WEBP)
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($image_ext, $allowed_extensions)) {
        die("Error: Only JPG, JPEG, PNG, GIF, and WEBP formats are allowed.");
    }

    // Generate a unique image name
    $new_image_name = time() . "_" . uniqid() . "." . $image_ext;
    $image_path = $upload_dir . $new_image_name;

    // Move the uploaded file
    if (!move_uploaded_file($image_tmp_name, $image_path)) {
        die("Error: Failed to move uploaded file.");
    }

    // Verify the image exists in the uploads folder
    if (!file_exists($image_path)) {
        die("Error: Image upload failed. File not found after upload.");
    }

    // Save only filename, not full path
    $sql = "INSERT INTO books (title, author, price, stock, image, description) 
            VALUES ('$title', '$author', '$price', '$stock', '$new_image_name', '$description')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Book added successfully!'); window.location.href='dashboard.php';</script>";
    } else {
        die("Database Insert Error: " . mysqli_error($conn));
    }
}
?>
