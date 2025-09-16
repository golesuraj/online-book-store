<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['key'])) {
    $key = $_POST['key'];
    if (isset($_SESSION['wishlist'][$key])) {
        unset($_SESSION['wishlist'][$key]);
        // Reindex the array
        $_SESSION['wishlist'] = array_values($_SESSION['wishlist']);
    }
}

header("Location: wishlist.php");
exit();
