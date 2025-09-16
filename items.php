<?php
include 'server.php'; // Database connection

?>

<!DOCTYPE html>
<html>
<head>
    <title>Books List</title>
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
            overflow: hidden;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }
        .book-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .book {
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }
        .book:hover {
            transform: translateY(-5px);
        }
        .book img {
            width: 150px;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }
        .book h3 {
            color: #333;
            font-size: 18px;
            margin: 10px 0;
        }
        .book p {
            color: #666;
            margin: 5px 0;
        }
        .add-to-cart, .add-to-wishlist {
            display: inline-block;
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 10px;
            transition: background 0.3s;
        }
        .add-to-cart:hover {
            background-color: #218838;
        }
        .add-to-wishlist {
            background-color: #ffc107;
            margin-left: 10px;
        }
        .add-to-wishlist:hover {
            background-color: #e0a800;
        }
        .home-btn {
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
        .home-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Available Books</h2>
    <div class="book-container">

    <?php
    $query = "SELECT * FROM books";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
    ?>
        <div class="book">
            <img src="uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>">
            <h3><?php echo $row['title']; ?></h3>
            <p>Author: <?php echo $row['author']; ?></p>
            <p>Price: <?php echo $row['price']; ?></p>

            <!-- Add to Cart Form -->
            <form method="post" action="cart_action.php" style="display:inline;">
                <input type="hidden" name="book_id" value="<?php echo $row['book_id']; ?>">
                <input type="hidden" name="title" value="<?php echo $row['title']; ?>">
                <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                <input type="hidden" name="image" value="<?php echo $row['image']; ?>">
                <button type="submit" name="add_to_cart" class="add-to-cart">Add to Cart</button>
            </form>

            <!-- Add to Wishlist Form -->
            <form method="post" action="wishlist_action.php" style="display:inline;">
                <input type="hidden" name="book_id" value="<?php echo $row['book_id']; ?>">
                <input type="hidden" name="title" value="<?php echo $row['title']; ?>">
                <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                <input type="hidden" name="image" value="<?php echo $row['image']; ?>">
                <button type="submit" name="add_to_wishlist" class="add-to-wishlist">Add to Wishlist</button>
            </form>
        </div>
    <?php
    }
    ?>

    </div>

    <!-- Back to Home Button -->
    <a href="index.php" class="home-btn">Back to Home</a>
</div>

</body>
</html>
