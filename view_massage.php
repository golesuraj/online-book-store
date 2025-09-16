<?php
$conn = new mysqli("localhost", "root", "", "project");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM contact ORDER BY id DESC";
$result = $conn->query($sql);

echo "<h2>Contact Messages</h2>";
while ($row = $result->fetch_assoc()) {
    echo "<p><strong>Name:</strong> " . $row['name'] . "</p>";
    echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
    echo "<p><strong>Subject:</strong> " . $row['subject'] . "</p>";
    echo "<p><strong>Message:</strong> " . $row['message'] . "</p>";
    echo "<hr>";
}

$conn->close();
?>
