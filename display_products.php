<?php
// Connect to the database (replace with your database credentials)
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "exam";
$port = 8111;

$conn = new mysqli($servername, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products based on selected category (or all products if no category is selected)
$category = isset($_GET['category']) ? $_GET['category'] : 'all';
if ($category == 'all') {
    $sql = "SELECT * FROM Products";
} else {
    $sql = "SELECT * FROM Products WHERE Category='$category'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Display product information
        echo "<div class='product'>";
        echo "<img src='" . $row['Image'] . "' alt='" . $row['ProductName'] . "'>";
        echo "<h3>" . $row['ProductName'] . "</h3>";
        echo "<p>Description: " . $row['Description'] . "</p>";
        echo "<p>Price: $" . $row['UnitPrice'] . "</p>";
        echo "<p>Quantity: " . $row['Quantity'] . "</p>";
        echo "<p>Availability: " . ($row['Quantity'] > 0 ? 'In stock' : 'Out of stock') . "</p>"; // Assuming availability is based on quantity
        echo "<button class='addToCartBtn' onclick='addToCart(" . $row['ProductID'] . ")'>Add to Cart</button>";
        echo "</div>";
    }
} else {
    echo "No products found.";
}

// Close database connection
$conn->close();
?>
