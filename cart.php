<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .cart-item {
            display: flex;
            align-items: center;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            padding: 15px;
            transition: transform 0.3s ease;
        }
        .cart-item:hover {
            transform: translateY(-5px);
        }
        .cart-item img {
            width: 100px;
            height: 130px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 15px;
        }
        .cart-details {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .cart-details h3 {
            color: #444;
            margin: 0;
            font-size: 18px;
        }
        .cart-details p {
            color: #666;
            margin: 5px 0;
        }
        .cart-actions {
            text-align: right;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: center;
        }
        .remove-btn {
            text-decoration: none;
            background: #cc0000;
            color: #fff;
            padding: 8px 12px;
            border-radius: 5px;
            transition: background 0.3s;
            margin-top: 10px;
            text-align: center;
        }
        .remove-btn:hover {
            background: #a80000;
        }
        .checkout-btn, .home-btn {
            display: block;
            width: fit-content;
            margin: 20px auto;
            background: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
            text-align: center;
        }
        .checkout-btn:hover {
            background: #0056b3;
        }
        .home-btn {
            background: #28a745;
        }
        .home-btn:hover {
            background: #218838;
        }
        .empty-cart {
            text-align: center;
            font-size: 18px;
            color: #888;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Your Cart</h2>

    <?php
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if (!isset($item['quantity'])) {
                $item['quantity'] = 1;
            }

            $imagePath = !empty($item['image']) ? 'uploads/' . $item['image'] : 'default.jpg';

            if (!file_exists($imagePath)) {
                $imagePath = 'default.jpg';
            }
    ?>
        <div class="cart-item">
            <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" onerror="this.onerror=null; this.src='default.jpg';">
            <div class="cart-details">
                <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                <p>Price: <?php echo htmlspecialchars($item['price']); ?></p>
                <p>Quantity: <?php echo htmlspecialchars($item['quantity']); ?></p>
            </div>
            <div class="cart-actions">
                <a href="remove_from_cart.php?key=<?php echo urlencode($key); ?>" class="remove-btn">Remove</a>
            </div>
        </div>
    <?php
        }
        echo "<a href='checkout.php' class='checkout-btn'>Proceed to Checkout</a>";
    } else {
        echo "<p class='empty-cart'>Your cart is empty.</p>";
    }
    ?>

    <!-- Back to Home Button -->
    <a href="index.php" class="home-btn">Back to Home</a>
</div>

</body>
</html>
