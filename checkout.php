<?php

include 'server.php'; // Database connection

$order_placed = false;
$order_id = null;
$order_details = null;

// Ensure session cart is set and not empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Your cart is empty!'); window.location.href='items.php';</script>";
    exit();
}

$cart = $_SESSION['cart'];
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Dummy delivery date (Estimated 3 to 7 days from now)
$delivery_date = date('Y-m-d', strtotime('+5 days'));

// Handle order submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payment_method'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $payment_method = $_POST['payment_method'];

    // Validate input fields
    if (empty($name) || empty($email) || empty($phone) || empty($address)) {
        echo "<script>alert('All fields are required!'); window.location.href='checkout.php';</script>";
        exit();
    }

    // Generate session ID for guest users
    $session_id = session_id();

    // Insert order into 'orders' table
    $stmt = $conn->prepare("INSERT INTO orders (session_id, name, email, phone, address, total_price, order_status, payment_method) VALUES (?, ?, ?, ?, ?, ?, 'Pending', ?)");

    if (!$stmt) {
        die("Prepare failed (orders table): " . $conn->error);
    }

    $stmt->bind_param("ssssdds", $session_id, $name, $email, $phone, $address, $total, $payment_method);

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;
        $order_placed = true;

        // Store order ID and total price in session (Fix for payments.php)
        $_SESSION['order_id'] = $order_id;
        $_SESSION['total_price'] = $total;

        // Insert items into 'order_items' table
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, book_name, price, quantity) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed (order_items table): " . $conn->error);
        }

        foreach ($cart as $item) {
            $stmt->bind_param("isdi", $order_id, $item['name'], $item['price'], $item['quantity']);
            $stmt->execute();
        }

        // Clear session cart
        unset($_SESSION['cart']);

        // Redirect to payments.php if Card Payment is chosen
        if ($payment_method === "Card Payment") {
            header("Location: payments.php");
            exit();
        }

        // Store order details for display (for Cash on Delivery)
        $order_details = [
            "name" => $name,
            "email" => $email,
            "phone" => $phone,
            "address" => $address,
            "total_price" => $total,
            "items" => $cart,
            "delivery_date" => $delivery_date
        ];
    } else {
        die("Error placing order: " . $conn->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #ff9a9e, #fad0c4);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 450px;
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        h2 { color: #333; margin-bottom: 15px; text-align: center; }
        input, textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background: #28a745;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            width: 100%;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 10px;
        }
        button:hover { background: #218838; }
        .cart-payment { background: #007bff; }
        .cart-payment:hover { background: #0056b3; }
        .order-details { text-align: left; margin-top: 20px; }
        .success-message { color: green; font-weight: bold; text-align: center; }
        .print-btn {
            background: #f39c12;
            margin-top: 15px;
        }
        .print-btn:hover { background: #d68910; }
        @media print {
            body * { visibility: hidden; }
            #bill-section, #bill-section * { visibility: visible; }
            #bill-section { position: absolute; left: 0; right: 0; margin: auto; }
        }
    </style>
</head>
<body>

<div class="container">
    <?php if ($order_placed): ?>
        <div id="bill-section">
            <h2>Order Placed Successfully!</h2>
            <p class="success-message">Your order has been placed. Here are the details:</p>
            <div class="order-details">
                <p><strong>Order ID:</strong> <?php echo $order_id; ?></p>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($order_details['name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($order_details['email']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($order_details['phone']); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($order_details['address']); ?></p>
                <p><strong>Total Price:</strong> ₹<?php echo number_format($order_details['total_price'], 2); ?></p>
                <p><strong>Estimated Delivery Date:</strong> <?php echo $order_details['delivery_date']; ?></p>
                <p><strong>Items Ordered:</strong></p>
                <ul>
                    <?php foreach ($order_details['items'] as $item): ?>
                        <li><?php echo htmlspecialchars($item['name']); ?> - ₹<?php echo number_format($item['price'], 2); ?> (x<?php echo $item['quantity']; ?>)</li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <button class="print-btn" onclick="window.print()">Print Bill</button>
        <a href="items.php"><button>Continue Shopping</button></a>
    <?php else: ?>
        <h2>Checkout</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <textarea name="address" placeholder="Shipping Address" required></textarea>
            <p><strong>Total: ₹<?php echo number_format($total, 2); ?></strong></p>
            
            <button type="submit" name="payment_method" value="Cash on Delivery">Cash on Delivery</button>
            <button type="submit" name="payment_method" value="Card Payment" class="cart-payment">Card Payment</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
