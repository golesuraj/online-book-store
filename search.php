<?php
// Include database connection
include 'server.php'; // Make sure this file connects to your DB

if (!isset($_GET['q']) || empty(trim($_GET['q']))) {
    echo "<h2>Please enter a search term.</h2>";
    exit();
}

$searchTerm = mysqli_real_escape_string($conn, $_GET['q']);

$query = "SELECT * FROM books WHERE title LIKE '%$searchTerm%' OR author LIKE '%$searchTerm%'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-color: #f9f9f9;
        }

        h2 {
            margin-bottom: 20px;
        }

        .book-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .book-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            width: 250px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.2s ease;
        }

        .book-card:hover {
            transform: translateY(-5px);
        }

        .book-card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        .book-details {
            padding: 15px;
        }

        .book-details h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .book-details p {
            margin: 5px 0;
        }

        .no-results {
            font-size: 18px;
            color: red;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <a href="index.php" class="back-button">← Back to Home</a>
    <h2>Search Results for "<?php echo htmlspecialchars($searchTerm); ?>"</h2>

    <div class="book-container">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $imagePath = 'uploads/' . htmlspecialchars($row['image']);
                echo '<div class="book-card">';
                echo '<img src="' . $imagePath . '" alt="Book Cover">';
                echo '<div class="book-details">';
                echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
                echo '<p><strong>Author:</strong> ' . htmlspecialchars($row['author']) . '</p>';
                echo '<p><strong>Price:</strong> ₹' . htmlspecialchars($row['price']) . '</p>';
                echo '<p><strong>Stock:</strong> ' . htmlspecialchars($row['stock']) . '</p>';
                echo '<p>' . htmlspecialchars(substr($row['description'], 0, 100)) . '...</p>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p class="no-results">No books found.</p>';
        }
        ?>
    </div>
</body>
</html>
