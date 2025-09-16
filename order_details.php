<?php
include 'server.php'; // Database connection

if (isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']); // Ensure valid order ID

    // Fetch order details
    $order_query = "SELECT * FROM orders WHERE order_id = $order_id";
    $order_result = mysqli_query($conn, $order_query);

    if (!$order_result) {
        die("Order Query Failed: " . mysqli_error($conn));
    }

    $order = mysqli_fetch_assoc($order_result);

    // Fetch order items with images
    $items_query = "SELECT order_items.*, books.image 
                    FROM order_items 
                    JOIN books ON order_items.book_name = books.title
                    WHERE order_items.order_id = $order_id";

    $items_result = mysqli_query($conn, $items_query);

    if (!$items_result) {
        die("Items Query Failed: " . mysqli_error($conn));
    }
} else {
    die("Invalid Order ID!");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background: white;
            box-shadow: 0px 0px 10px gray;
            border-radius: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        table, th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            width: 60px;
            height: 80px;
            border-radius: 5px;
            box-shadow: 2px 2px 5px gray;
        }
        .back-btn {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-btn:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Order Details for Order ID: <?php echo htmlspecialchars($order['order_id']); ?></h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($order['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
        <p><strong>Total Price:</strong> ₹<?php echo number_format($order['total_price'], 2); ?></p>
        <p><strong>Order Date:</strong> <?php echo htmlspecialchars($order['order_date']); ?></p>

        <h3>Ordered Items</h3>
        <table>
            <tr>
                <th>Book Name</th>
                <th>Image</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            <?php while ($item = mysqli_fetch_assoc($items_result)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($item['book_name']); ?></td>
                <td>
                    <?php 
                    if (!empty($item['image'])) { 
                        $image_path = "uploads/" . $item['image']; // Ensure correct image path
                    ?>
                        <img src="<?php echo htmlspecialchars($image_path); ?>" alt="Book Image">
                    <?php } else { ?>
                        <p>No Image</p>
                    <?php } ?>
                </td>
                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                <td><?php echo number_format($item['price'], 2); ?></td>
            </tr>
            <?php } ?>
        </table>

        <a href="orders.php" class="back-btn">Back to Orders</a>
    </div>
</body>
</html>
