<?php
session_start();
include 'server.php';

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    echo "<script>alert('Please log in to view your orders.'); window.location.href='login.php';</script>";
    exit();
}

$user_id = $_SESSION['id']; // Correct reference

// Fetch orders and their items using JOIN
$query = mysqli_query($conn, 
    "SELECT o.id AS order_id, oi.book_name, oi.price, oi.quantity, o.order_status, o.order_date 
     FROM orders o
     JOIN order_items oi ON o.id = oi.order_id
     WHERE o.id = '$user_id'
     ORDER BY o.order_date DESC"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .container {
            width: 80%;
            margin: auto;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .success-message {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Orders</h2>
        
        <?php if (isset($_GET['order']) && $_GET['order'] == "success"): ?>
            <p class="success-message">Your order has been placed successfully!</p>
        <?php endif; ?>

        <table>
            <tr>
                <th>Book Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Order Date</th>
            </tr>
            <?php
            if (mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<tr>
                            <td>{$row['book_name']}</td>
                            <td>\${$row['price']}</td>
                            <td>{$row['quantity']}</td>
                            <td>{$row['order_status']}</td>
                            <td>{$row['order_date']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No orders found.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
