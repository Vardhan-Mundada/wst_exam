<?php
// Start session
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Add Product</h2>
        <form action="add_product.php" method="post" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Product Name" required>
            <textarea name="description" placeholder="Product Description" required></textarea>
            <input type="number" name="price" placeholder="Price" step="0.01" required>
            <select name="category" required>
                <option value="" disabled selected>Select Category</option>
                <option value="electronics">Electronics</option>
                <option value="clothing">Clothing</option>
                <!-- Add more categories as needed -->
            </select>
            <input type="checkbox" name="availability" id="availability" checked>
            <label for="availability">Available</label>
            <input type="file" name="image" accept="image/*" required>
            <button type="submit">Add Product</button>
        </form>
    </div>
</body>
</html>
