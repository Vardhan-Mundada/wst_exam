
<?php include 'navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Add styles for the product catalog */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            display: block;
        }

        .categories {
            margin-bottom: 20px;
        }

        .categories h3 {
            margin-bottom: 10px;
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

        .product h3 {
            margin-top: 0;
        }

        .product p {
            margin: 5px 0;
        }

        .addToCartBtn {
            background-color: #4CAF50;
            color: black;
            padding: 10px;
            border: 1px solid black;
            border-radius: 5px;
            cursor: pointer;
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

        <!-- Add search form -->
        <form action="" method="GET">
            <input type="text" name="search" placeholder="Search products...">
            <button type="submit">Search</button>
        </form>

        <!-- Categories Section -->
        <div class="categories">
            <h3>Categories</h3>
            <select onchange="location = this.value;">
                <option value="?category=all">All</option>
                <option value="?category=electronics">Electronics</option>
                <option value="?category=clothing">Clothing</option>
                <!-- Add more categories as needed -->
            </select>
        </div>

        <!-- Products Section -->
        <div class="products">
    <?php
    // Include database connection
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

    // Retrieve search keyword if provided
    $search_keyword = isset($_GET['search']) ? $_GET['search'] : '';

    // Query products based on search keyword
    if (!empty($search_keyword)) {
        $sql = "SELECT * FROM Products WHERE ProductName LIKE '%$search_keyword%'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Display each product with an "Add to Cart" button
                echo "<div class='product'>";
                echo "<img src='" . $row['Image'] . "' alt='" . $row['ProductName'] . "'>";
                echo "<h3>" . $row['ProductName'] . "</h3>";
                echo "<p>" . $row['Description'] . "</p>";
                echo "<p>Price: $" . $row['UnitPrice'] . "</p>";
                echo "<p>Quantity: " . $row['Quantity'] . "</p>";
                echo "<p>Category: " . $row['Category'] . "</p>";
                echo "hii";
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

    <!-- Shopping cart modal -->
    <div id="cartModal" class="modal">
        <div id="cartItems">
            <!-- Cart items will be dynamically loaded here -->
        </div>
        <!-- <button id="checkoutBtn">Checkout</button> -->
    </div>

    <a href="getCart.php"><button>View Cart</button></a>

<!-- JavaScript for adding to cart -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function addToCart(productId) {
        $.ajax({
            url: 'addToCart.php',
            method: 'POST',
            data: { productId: productId },
            success: function(response) {
                alert(response); // Show success message or handle response as needed
            }
        });
    }
</script>
    
</body>
</html>
