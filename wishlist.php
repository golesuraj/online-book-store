<?php
session_start();
$wishlist = isset($_SESSION['wishlist']) ? $_SESSION['wishlist'] : [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Wishlist</title>
    <style>
        .book-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
            justify-content: center;
        }
        .book {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            width: 200px;
            background: #fff;
            text-align: center;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .book img {
            width: 120px;
            height: 160px;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .remove-button {
            margin-top: 10px;
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
        }
        .remove-button:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Your Wishlist</h2>
<div class="book-container">
    <?php if (!empty($wishlist)) {
        foreach ($wishlist as $key => $item) { ?>
            <div class="book">
                <img src="uploads/<?php echo $item['image']; ?>" alt="<?php echo $item['title']; ?>">
                <h3><?php echo $item['title']; ?></h3>
                <p>Price: ₹<?php echo $item['price']; ?></p>
                <form action="remove_from_wishlist.php" method="POST">
                    <input type="hidden" name="key" value="<?php echo $key; ?>">
                    <button type="submit" class="remove-button">Remove</button>
                </form>
            </div>
    <?php } } else { ?>
        <p style="text-align:center;">Your wishlist is empty.</p>
    <?php } ?>
</div>

<div style="text-align:center; margin-top: 20px;">
    <a href="items.php">← Back to Books</a>
</div>

</body>
</html>
