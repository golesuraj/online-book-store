<?php
include 'server.php'; // Database connection

// Debugging: Check if order_id is passed
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    die("Error: Invalid Order ID in URL!");
}

$order_id = intval($_GET['order_id']); // Ensure it's an integer

// Fetch order details
$order_query = "SELECT * FROM orders WHERE order_id = $order_id";
$order_result = mysqli_query($conn, $order_query);

// If order does not exist
if (!$order_result || mysqli_num_rows($order_result) == 0) {
    die("Error: Order not found in the database!");
}

$order = mysqli_fetch_assoc($order_result);

// Fetch order items
$items_query = "SELECT order_items.*, books.image 
                FROM order_items 
                JOIN books ON order_items.book_id = books.book_id
                WHERE order_items.order_id = $order_id";

$items_result = mysqli_query($conn, $items_query);

if (!$items_result) {
    die("Error fetching items: " . mysqli_error($conn));
}
?>
