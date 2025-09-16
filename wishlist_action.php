<?php
session_start();

if (isset($_POST['add_to_wishlist'])) {
    $book_id = $_POST['book_id'];
    $title = $_POST['title'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    // Initialize wishlist if not already set
    if (!isset($_SESSION['wishlist'])) {
        $_SESSION['wishlist'] = [];
    }

    // Check if book is already in wishlist
    $already_added = false;
    foreach ($_SESSION['wishlist'] as $item) {
        if ($item['book_id'] == $book_id) {
            $already_added = true;
            break;
        }
    }

    if (!$already_added) {
        $_SESSION['wishlist'][] = [
            'book_id' => $book_id,
            'title' => $title,
            'price' => $price,
            'image' => $image
        ];
    }

    header("Location: wishlist.php");
    exit();
}
?>
