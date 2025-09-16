<?php

include 'server.php';

// Check if order exists in session
if (!isset($_SESSION['order_id']) || !isset($_SESSION['total_price'])) {
    echo "<script>alert('No order found! Redirecting to cart...'); window.location.href='cart.php';</script>";
    exit();
}

$order_id = $_SESSION['order_id'];
$total_price = $_SESSION['total_price'];
$delivery_date = date('Y-m-d', strtotime('+5 days')); // Estimated delivery date

// Fetch order items
$order_items = [];
$stmt = $conn->prepare("
    SELECT b.book_id, b.title, b.price, b.image 
    FROM order_items oi 
    JOIN books b ON oi.book_id = b.book_id 
    WHERE oi.order_id = ?
");
if ($stmt) {
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $row['image'] = !empty($row['image']) ? 'uploads/' . $row['image'] : 'placeholder.jpg';
        $order_items[] = $row;
    }
    $stmt->close();
}

// Handle Payment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay_now'])) {
    $card_number = trim($_POST['card_number']);
    $expiry = trim($_POST['expiry']);
    $cvv = trim($_POST['cvv']);

    if (empty($card_number) || empty($expiry) || empty($cvv)) {
        echo "<script>alert('Please enter valid card details!');</script>";
    } else {
        // Simulate successful payment
        $_SESSION['payment_status'] = 'Success';

        // Update order status to 'Paid'
        $stmt = $conn->prepare("UPDATE orders SET order_status = 'Paid' WHERE order_id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $order_id);
            $stmt->execute();
            $stmt->close();
            // ✅ Stay on page and show bill
        } else {
            die("Error updating order: " . $conn->error);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Card Payment</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: linear-gradient(to right, #6a11cb, #2575fc); 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            margin: 0; 
            padding: 20px;
        }
        .container { 
            background: white; 
            padding: 20px; 
            border-radius: 10px; 
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); 
            width: 500px; 
            text-align: center; 
        }
        h2 { color: #333; }
        input { 
            width: 100%; 
            padding: 10px; 
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
            margin-top: 10px; 
        }
        button:hover { background: #218838; }
        .cancel-btn { background: #dc3545; }
        .cancel-btn:hover { background: #c82333; }

        /* Bill / Invoice */
        .bill {
            margin-top: 20px;
            padding: 20px;
            border: 2px solid #333;
            border-radius: 10px;
            text-align: left;
            background: #f9f9f9;
        }
        .bill h2 { text-align: center; margin-bottom: 10px; }
        .bill table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .bill table th, .bill table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .bill table th {
            background: #333;
            color: white;
        }
        .bill button {
            margin-top: 15px;
            padding: 10px;
            width: 100%;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .bill button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>All Cards Accepted</h2>
        <p>Order ID: <?php echo $order_id; ?></p>
        <p>Total: ₹<?php echo number_format($total_price, 2); ?></p>

        <?php if (!isset($_SESSION['payment_status']) || $_SESSION['payment_status'] !== 'Success'): ?>
            <!-- Payment Form -->
            <form method="POST">
                <input type="text" name="card_number" placeholder="Card Number" minlength="13" maxlength="19" required>
                <input type="text" name="expiry" placeholder="Expiry (MM/YY)" required>
                <input type="text" name="cvv" placeholder="CVV" minlength="3" maxlength="4" required>
                <button type="submit" name="pay_now">Pay Now</button>
            </form>
            <a href="cart.php"><button class="cancel-btn">Cancel</button></a>
        <?php endif; ?>

        <?php if (isset($_SESSION['payment_status']) && $_SESSION['payment_status'] == 'Success'): ?>
            <!-- Bill / Invoice -->
            <div class="bill">
                <h2>Invoice / Bill</h2>
                <hr>
                <p><strong>Order ID:</strong> <?php echo $order_id; ?></p>
                <p><strong>Date:</strong> <?php echo date("d-m-Y"); ?></p>
                <p><strong>Estimated Delivery:</strong> <?php echo $delivery_date; ?></p>
                <p><strong>Payment Status:</strong> ✅ Paid</p>

                <h3>Items:</h3>
                <table>
                    <tr>
                        <th>Book</th>
                        <th>Price</th>
                    </tr>
                    <?php foreach ($order_items as $item): ?>
                        <tr>
                            <td>
                                <img src="<?php echo $item['image']; ?>" width="40" height="40" style="border-radius:5px;vertical-align:middle;"> 
                                <?php echo $item['title']; ?>
                            </td>
                            <td>₹<?php echo number_format($item['price'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td><strong>Total</strong></td>
                        <td><strong>₹<?php echo number_format($total_price, 2); ?></strong></td>
                    </tr>
                </table>

                <button onclick="window.print()">🖨 Print Bill</button>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
