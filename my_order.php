<?php

include 'server.php'; // Database connection

$user_email = "test@example.com"; // Replace with session-based user email

$query = "SELECT * FROM orders WHERE email='$user_email' ORDER BY order_date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-top: 30px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #007bff;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>My Orders</h2>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Address</th>
            <th>Total Price</th>
            <th>Status</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['order_id']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td>₹<?php echo number_format($row['total_price'], 2); ?></td>
                <td><?php echo $row['status']; ?></td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
