<?php
// Start session
session_start();

// If user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-image: url('coffee-cup-many-books_250469-6478.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            position: relative;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 20px 50px;
            border-bottom: 1px solid #ddd;
            background-color: rgba(255, 255, 255, 0.8);
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #007BFF;
        }

        .nav-links {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-grow: 1;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: #007BFF;
        }

        .auth-buttons {
            display: flex;
            align-items: center;
        }

        .auth-buttons input[type="text"],
        .auth-buttons button, 
        .cart-button {
            background-color: transparent;
            border: 2px solid black;
            color: black;
            padding: 8px 16px;
            margin-left: 10px;
            cursor: pointer;
            font-size: 14px;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .auth-buttons input[type="text"] {
            padding: 8px;
            width: 160px;
        }

        .auth-buttons button:hover, 
        .cart-button:hover {
            background-color: black;
            color: white;
        }

        .cart-button {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cart-button i {
            margin-right: 5px;
        }

        .content {
            position: absolute;
            top: 50%;
            left: 10%;
            transform: translateY(-50%);
            text-align: left;
            color: black;
        }

        h2, h1 {
            color: white;
        }

        .shop-now-button {
            background-color: #007BFF;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .shop-now-button:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function goToCart() {
            alert("Redirecting to your cart!");
            window.location.href = "cart.php";
        }

        function goToWishlist() {
            alert("Redirecting to your wishlist!");
            window.location.href = "wishlist.php";
        }

        function goToDashboard() {
            alert("Redirecting to your dashboard!");
            window.location.href = "user_dashboard.php";
        }

        function performSearch() {
            const query = document.getElementById("searchInput").value.trim();
            if (query) {
                window.location.href = `search.php?q=${encodeURIComponent(query)}`;
            } else {
                alert("Please enter a search term.");
            }
        }
    </script>
</head>
<body>
    <nav>
        <div class="logo">Book Store</div>
        <div class="nav-links">
            <a href="#">Home</a><span>  </span>
            <a href="items.php">Book Shop</a><span>  </span>
            <a href="about.php">About</a><span> </span>
            <a href="contact.php">Contact</a><span>  </span>
            <a href="dashboard.php">Admin</a>
        </div>
        <div class="auth-buttons">
            <input type="text" id="searchInput" placeholder="Search books...">
            <button onclick="performSearch()">Search</button>
            <a href="logout.php"><button>Logout</button></a>
            <button class="cart-button" onclick="goToCart()">
                <i class="fas fa-shopping-cart"></i> Cart
            </button>
            <button class="cart-button" onclick="goToWishlist()">
                <i class="fas fa-heart"></i> Wishlist
            </button>
        </div>
    </nav>

    <div class="content">
        <h2>Fiction Book by Famous Authors</h2>
        <h1>Buy Hundreds of Books Online</h1>
        <a href="items.php"><button class="shop-now-button">Shop Now</button></a>
    </div>
</body>
</html>
