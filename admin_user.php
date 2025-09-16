<?php
// admin_user.php - Landing Page with User and Admin Login Buttons

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #1e3c72, #2a5298);
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255, 255, 255, 0.15);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
        }
        h2 {
            color: #fff;
            font-size: 28px;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            margin: 15px;
            font-size: 20px;
            font-weight: bold;
            color: white;
            background: linear-gradient(45deg, #ff416c, #ff4b2b);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 5px 15px rgba(255, 75, 43, 0.3);
        }
        .btn:hover {
            background: linear-gradient(45deg, #ff4b2b, #ff416c);
            transform: scale(1.1);
            box-shadow: 0 8px 20px rgba(255, 75, 43, 0.5);
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let buttons = document.querySelectorAll(".btn");
            buttons.forEach(button => {
                button.addEventListener("mouseover", function() {
                    this.style.transform = "scale(1.1) rotate(2deg)";
                });
                button.addEventListener("mouseout", function() {
                    this.style.transform = "scale(1) rotate(0deg)";
                });
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h2>Welcome to Online Book Store</h2>
        <a href="user_login.php" class="btn">User Login</a>
        <a href="admin_login.php" class="btn">Admin Login</a>
    </div>
</body>
</html>