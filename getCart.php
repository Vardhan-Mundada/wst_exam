<?php
session_start();


// Check if AJAX request is received
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productId']) && isset($_POST['action'])) {
    include 'update_cart.php'; // Include update_cart.php to handle AJAX request
    exit; // Exit after handling AJAX request
}


// Check if cart session variable is set
if (isset($_SESSION['cart'])) {
    // Include database connection
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $database = "trial";
    $port = 8111;

    $conn = new mysqli($servername, $username, $password, $database, $port);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch cart items from database based on product IDs in the cart
    $cartItems = [];
    foreach ($_SESSION['cart'] as $productId => $quantity) { // Update loop to fetch quantity as well
        $sql = "SELECT * FROM product WHERE id = $productId";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $row['quantity'] = $quantity; // Add quantity to the row
            $cartItems[] = $row;
        }
    }
} else {
    $cartItems = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cart</title>
    <link rel="stylesheet" href="styles.css">
    <style>
         <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        h2 {
            text-align: center;
        }

        .cartItems {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .cartItem {
            margin: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 200px;
        }

        .cartItem img {
            max-width: 100px;
            height: auto;
        }

        .cartItem h3 {
            margin: 10px 0;
        }

        .cartItem p {
            margin: 5px 0;
        }

        .checkoutBtn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Function to increment product count in cart
        function incrementProduct(productId) {
            $.ajax({
                url: 'getCart.php', // Use the same page to handle AJAX request
                method: 'POST',
                data: { productId: productId, action: 'increment' },
                success: function(response) {
                    location.reload(); // Reload the page to update cart
                }
            });
        }

        // Function to decrement product count in cart
        function decrementProduct(productId) {
            $.ajax({
                url: 'getCart.php', // Use the same page to handle AJAX request
                method: 'POST',
                data: { productId: productId, action: 'decrement' },
                success: function(response) {
                    location.reload(); // Reload the page to update cart
                }
            });
        }
    </script>
</head>
<body>
    <h2>Shopping Cart</h2>
    <?php if (!empty($cartItems)) : ?>
        <div class="cartItems">
            <?php foreach ($cartItems as $item) : ?>
                <div class="cartItem">
                    <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                    <h3><?php echo $item['name']; ?></h3>
                    <p>Price: $<?php echo $item['price']; ?></p>
                    <button onclick="removeFromCart(<?php echo $item['id']; ?>)">Remove from Cart</button>
                    <button onclick="incrementProduct(<?php echo $item['id']; ?>)">+</button>
                    <button onclick="decrementProduct(<?php echo $item['id']; ?>)">-</button>
                    <p>Quantity: <?php echo $item['quantity']; ?></p>s
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>

    <a href="checkout.php" class="checkoutBtn">Checkout</a>
    <a href="product_catalog.php"><button>Continue Shopping</button></a>

    <!-- JavaScript for removing from cart -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function removeFromCart(productId) {
            $.ajax({
                url: 'removeFromCart.php',
                method: 'POST',
                data: { productId: productId },
                success: function(response) {
                    alert(response); // Show success message or handle response as needed
                    location.reload(); // Reload the page to update cart items
                }
            });
        }
    </script>
</body>
</html>
