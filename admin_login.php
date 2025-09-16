<?php

include 'server.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the email exists
    $query = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            if ($user['role'] === 'admin') {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = 'admin';

                // Redirect to the admin dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                echo "<script>alert('Access denied! Only admins can log in here.');</script>";
            }
        } else {
            echo "<script>alert('Invalid password!');</script>";
        }
    } else {
        echo "<script>alert('User not found!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
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

        .back-btn {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            font-size: 18px;
            font-weight: bold;
            color: white;
            background: linear-gradient(90deg, #2a5298, #1e3c72);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 5px 15px rgba(30, 60, 114, 0.3);
        }

        .back-btn:hover {
            background: linear-gradient(90deg, #1e3c72, #2a5298);
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(30, 60, 114, 0.5);
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

            // Fixed "Back to Home" button redirecting to index.php
            document.getElementById("backToHome").addEventListener("click", function() {
                window.location.href = "index.php"; // Redirect to home page (corrected)
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h2>Admin Login</h2>
        <form action="" method="POST">
            <input type="email" name="email" placeholder="Admin Email" required>

            <div class="password-container">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <span class="toggle-password" id="togglePassword">👁️</span>
            </div>

            <button type="submit" class="btn">Login</button>
            <button type="button" class="back-btn" id="backToHome">Back to Home</button>
        </form>
        
        <p>Don't have an admin account? <a href="admin_register.php">Register here</a></p>
    </div>
</body>
</html>
