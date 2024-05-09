<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .container {
            padding:2rem;
            display: block;
        }

        .categories select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-gap: 20px;
        }

        .product {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
        }

        .product img {
            max-width: 100%;
            height: auto;
        }


        .addToCartBtn {
            background-color: #555555;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }

        .cartItem {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }

        #cartItems {
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Product Catalog</h2>
        <div style="display: flex; flex-direction: row; justify-content: space-around;">
        <form action="" method="GET">
            <input type="text" name="search" placeholder="Search products...">
            <button type="submit">Search</button>
        </form>

        <div class="categories">
            <h3>Categories</h3>
            <select onchange="location = this.value;">
                <option value="?category=all">All</option>
                <option value="?category=electronics">Electronics</option>
                <option value="?category=clothing">Clothing</option>
            </select>
        </div>

        </div>
        <div style="display: flex; flex-direction: row; justify-content: space-around; padding-bottom:2rem;">
        <button><a href="add_product_html.php">Add Products to inventory</a></button>
        <a href="getCart.php"><button>View Cart</button></a>
        </div>
        <div class="products">
    <?php
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $database = "exam";
    $port = 8111;

    $conn = new mysqli($servername, $username, $password, $database, $port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $search_keyword = isset($_GET['search']) ? $_GET['search'] : '';
    if (!empty($search_keyword)) {
        $sql = "SELECT * FROM Products WHERE ProductName LIKE '%$search_keyword%'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='product'>";
                echo "<img src='" . $row['Image'] . "' alt='" . $row['ProductName'] . "'>";
                echo "<h3>" . $row['ProductName'] . "</h3>";
                echo "<p>" . $row['Description'] . "</p>";
                echo "<p>Price: $" . $row['UnitPrice'] . "</p>";
                echo "<p>Quantity: " . $row['Quantity'] . "</p>";
                echo "<p>Category: " . $row['Category'] . "</p>";
                echo "<button class='addToCartBtn' onclick='addToCart(" . $row['ProductID'] . ")'>Add to Cart</button>";
                echo "</div>";
            }
        } else {
            echo "No products found.";
        }
    } else {
        include 'display_products.php';
    }
    ?>
</div>

    </div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function addToCart(ProductID) {
        $.ajax({
            url: 'addToCart.php',
            method: 'POST',
            data: { ProductID: ProductID },
            success: function(response) {
                alert(response);
            }
        });
    }
</script>
    
</body>
</html>
