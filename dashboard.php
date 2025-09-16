<?php
include 'server.php'; // Ensure database connection is included

// Check if user is logged in and has an 'admin' role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php"); // Redirect to admin login page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            position: relative;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 30px;
        }

        .button-container {
            display: flex;
            gap: 20px;
        }

        .btn {
            background-color: #3498db;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .btn:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        .btn:active {
            transform: scale(0.95);
        }

        /* Glowing effect */
        .btn::after {
            content: "";
            position: absolute;
            top: -5px;
            left: -5px;
            width: 100%;
            height: 100%;
            border-radius: 8px;
            border: 2px solid rgba(255, 255, 255, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .btn:hover::after {
            opacity: 1;
        }

        /* Logout button styling */
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #e74c3c;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 6px;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }

    </style>
</head>
<body>

    <button class="btn logout-btn" id="logoutBtn">Logout</button> <!-- Logout Button -->

    <h1>Admin Dashboard</h1>

    <div class="button-container">
        <button class="btn" id="addBooksBtn">Add Books</button>
        <button class="btn" id="userManagementBtn">User Management</button>
        <button class="btn" id="viewOrdersBtn">View Orders</button>
    </div>
 
    <script>
        document.getElementById("addBooksBtn").addEventListener("click", function() {
            window.location.href = "add_book.php"; // Redirect to add books page
        });

        document.getElementById("userManagementBtn").addEventListener("click", function() {
            window.location.href = "admin.html"; // Redirect to user management page
        });

        document.getElementById("viewOrdersBtn").addEventListener("click", function() {
            window.location.href = "orders.php"; // Redirect to orders page
        });

        document.getElementById("logoutBtn").addEventListener("click", function() {
            window.location.href = "admin_logout.php"; // Redirect to logout page
        });

        console.log("Dashboard loaded successfully!");
    </script>

</body>
</html>
