<?php
include 'server.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'admin'; // Admin role

    // Check if an admin already exists
    $checkQuery = "SELECT * FROM users WHERE role = 'admin'";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Admin account already exists! Redirecting to login.'); window.location.href='admin_login.php';</script>";
        exit();
    }

    // Check if email already exists
    $checkEmailQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $emailResult = $stmt->get_result();

    if ($emailResult->num_rows > 0) {
        echo "<script>alert('Email already exists! Try another.');</script>";
    } else {
        // Insert new admin
        $query = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $name, $email, $password, $role);
        
        if ($stmt->execute()) {
            echo "<script>alert('Admin registered successfully! Redirecting to login...'); window.location.href='admin_login.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(-45deg, #1e3c72, #2a5298, #ff416c, #ff4b2b);
            background-size: 400% 400%;
            animation: gradientBG 8s ease infinite;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            background: rgba(255, 255, 255, 0.2);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(15px);
            width: 350px;
            text-align: center;
            animation: fadeIn 1s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            color: #fff;
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-size: 16px;
            outline: none;
            transition: 0.3s;
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        input:focus {
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 8px rgba(255, 255, 255, 0.5);
        }

        .password-container {
            position: relative;
            width: 100%;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: rgba(255, 255, 255, 0.7);
        }

        .btn {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            font-size: 18px;
            font-weight: bold;
            color: white;
            background: linear-gradient(90deg, #ff416c, #ff4b2b);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 5px 15px rgba(255, 75, 43, 0.3);
        }

        .btn:hover {
            background: linear-gradient(90deg, #ff4b2b, #ff416c);
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(255, 75, 43, 0.5);
        }

        p {
            color: #fff;
            margin-top: 10px;
        }

        a {
            color: #ffdd57;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        @media (max-width: 400px) {
            .container {
                width: 90%;
                padding: 30px;
            }
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let passwordField = document.getElementById("password");
            let togglePassword = document.getElementById("togglePassword");

            togglePassword.addEventListener("click", function() {
                if (passwordField.type === "password") {
                    passwordField.type = "text";
                    togglePassword.textContent = "🙈";
                } else {
                    passwordField.type = "password";
                    togglePassword.textContent = "👁️";
                }
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h2>Admin Registration</h2>
        <form action="" method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>

            <div class="password-container">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <span class="toggle-password" id="togglePassword">👁️</span>
            </div>

            <button type="submit" class="btn">Register</button>
        </form>
        
        <p>Already have an account? <a href="admin_login.php">Login here</a></p>
    </div>
</body>
</html>
