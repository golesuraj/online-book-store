<?php
// Start session

include 'server.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Default role: "user"
    $role = 'user';

    // Check if email already exists
    $check_query = "SELECT * FROM users WHERE email='$email'";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        $error = "Email already exists. Please use a different email.";
    } else {
        // Ensure only one admin exists
        if (isset($_POST['role']) && $_POST['role'] == 'admin') {
            $admin_check = "SELECT * FROM users WHERE role='admin'";
            $admin_result = mysqli_query($conn, $admin_check);
            if (mysqli_num_rows($admin_result) > 0) {
                $error = "Only one admin is allowed.";
            } else {
                $role = 'admin';
            }
        }

        if (!isset($error)) {
            // Insert user into database
            $query = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashed_password', '$role')";
            
            if (mysqli_query($conn, $query)) {
                $_SESSION['user_email'] = $email;
                $_SESSION['user_role'] = $role;
                
                header("Location: user_login.php"); // Redirect to login page
                exit();
            } else {
                $error = "Registration failed. Error: " . mysqli_error($conn); // Show SQL error
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 300px;
            margin: auto;
            margin-top: 100px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        input[type="text"], input[type="email"], input[type="password"], select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
        }
        .btn {
            background: #333;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background: #555;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Registration</h2>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
        <form action="user_register.php" method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn">Register</button>
        </form>
        <p>Already have an account? <a href="user_login.php">Login</a></p>
    </div>
</body>
</html>
