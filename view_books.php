<?php
include 'server.php';


$sql = "SELECT * FROM books";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h3>" . $row['title'] . " by " . $row['author'] . "</h3>";
        echo "<p>Price: $" . $row['price'] . "</p>";
        echo "<img src='uploads/" . $row['image'] . "' width='100' height='150'>";
        echo "<p>" . $row['description'] . "</p>";
        echo "</div><hr>";
    }
} else {
    echo "No books available.";
}
?>
