<?php
include 'server.php'; // Include database connection

$query = "SELECT * FROM orders ORDER BY order_date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Orders</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>All Orders</h2>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Total Price</th>
            <th>Order Date</th>
            <th>View Items</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['order_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td>₹<?php echo number_format($row['total_price'], 2); ?></td>
            <td><?php echo $row['order_date']; ?></td>
            <td><a href="order_details.php?order_id=<?php echo $row['order_id']; ?>">View Items</a></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
