<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ProductID']) && isset($_POST['action'])) {
    include 'update_cart.php'; 
    exit; 
}


if (isset($_SESSION['cart'])) {
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $database = "exam";
    $port = 8111;

    $conn = new mysqli($servername, $username, $password, $database, $port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $cartItems = [];
    foreach ($_SESSION['cart'] as $productId => $quantity) { 
        $sql = "SELECT * FROM Products WHERE ProductID = $productId";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $row['quantity'] = $quantity; 
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function incrementProduct(productId) {
            $.ajax({
                url: 'update_cart.php', 
                method: 'POST',
                data: { productId: productId, action: 'increment' }, 
                success: function(response) {
                    location.reload(); 
                }
            });
        }

        function decrementProduct(productId) {
            $.ajax({
                url: 'update_cart.php', 
                method: 'POST',
                data: { productId: productId, action: 'decrement' }, 
                success: function(response) {
                    location.reload();
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
                    <img src="<?php echo $item['Image']; ?>" alt="<?php echo $item['ProductName']; ?>">
                    <h3><?php echo $item['ProductName']; ?></h3>
                    <p>Price: $<?php echo $item['UnitPrice']; ?></p>
                    <button onclick="removeFromCart(<?php echo $item['ProductID']; ?>)">Remove from Cart</button>
                    <button onclick="incrementProduct(<?php echo $item['ProductID']; ?>)">+</button>
                    <button onclick="decrementProduct(<?php echo $item['ProductID']; ?>)">-</button>
                    <p>Quantity: <?php echo $item['quantity']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>

    <a href="checkout.php" class="checkoutBtn">Checkout</a>

    <script>
        function removeFromCart(productId) {
            $.ajax({
                url: 'removeFromCart.php',
                method: 'POST',
                data: { productId: productId },
                success: function(response) {
                    alert(response); 
                    location.reload();
                }
            });
        }
    </script>
</body>
</html>
