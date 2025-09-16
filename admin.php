<?php
include "server.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

echo "<h2>Welcome, Admin!</h2>";
echo "<a href='logout.php'>Logout</a>";
?>
