<?php
session_start();
include 'server.php'; // Database connection

if (isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];

    // Fetch book details from the database
    $query = "SELECT * FROM books WHERE book_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();

    if ($book) {
        $cart_item = [
            'id' => $book['book_id'],
            'name' => $book['title'],
            'price' => $book['price'], // Ensure this matches your DB column name
            'image' => $book['image'],
            'quantity' => 1
        ];

        // Check if cart exists
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Check if item already in cart
        $found = false;
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] == $book['book_id']) {
                $_SESSION['cart'][$key]['quantity'] += 1; // Increase quantity
                $found = true;
                break;
            }
        }

        // If item is new, add to cart
        if (!$found) {
            $_SESSION['cart'][] = $cart_item;
        }
    } else {
        echo "Error: Book not found!";
        exit();
    }
} else {
    echo "Error: Invalid request!";
    exit();
}

// Redirect to cart
header("Location: cart.php");
exit();
?>
