
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
            <input type="number" name="ProductID" placeholder="Price" step="0.01" required>
            <input type="text" name="ProductName" placeholder="Product Name" required>
            <textarea name="Description" placeholder="Product Description" required></textarea>
            <input type="number" name="UnitPrice" placeholder="Price" step="0.01" required>
            <input type="file" name="Image" accept="image/*" required>
            <input type="number" name="Quantity" placeholder="Price" step="0.01" required>
            <select name="Category" required>
                <option value="" disabled selected>Select Category</option>
                <option value="electronics">Electronics</option>
                <option value="clothing">Clothing</option>
            </select>
            <button type="submit">Add Product</button>
        </form>
    </div>
</body>
</html>


