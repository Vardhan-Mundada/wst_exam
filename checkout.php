<?php
session_start();

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
        $sql = "SELECT * FROM products WHERE ProductID = $productId";
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $totalPrice = $_POST['totalPrice'];

    $sql = "INSERT INTO orders (address, phone, total_price) VALUES ('$address', '$phone', '$totalPrice')";
    if ($conn->query($sql) === TRUE) {
        $orderId = $conn->insert_id;

        foreach ($_SESSION['cart'] as $productId => $quantity) {
            $sql = "UPDATE products SET quantity = quantity - $quantity WHERE ProductID = $productId";
            $conn->query($sql);
        }

        unset($_SESSION['cart']);
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Checkout</h2>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required><br><br>

            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" required><br><br>
            <h3>Order Summary</h3>
            <ul>
                <?php foreach ($cartItems as $item) : ?>
                    <li><?php echo $item['ProductName']; ?> - $<?php echo $item['UnitPrice']; ?> (Quantity: <?php echo $item['quantity']; ?>)</li>
                <?php endforeach; ?>
            </ul>

            <?php
            $totalPrice = array_sum(array_map(function($item) {
                return $item['UnitPrice'] * $item['quantity'];
            }, $cartItems));
            ?>
            <p>Total Price: $<?php echo $totalPrice; ?></p>
            <input type="hidden" name="totalPrice" value="<?php echo $totalPrice; ?>">

            <button type="submit">Place Order</button>
        </form>
    </div>
</body>
</html>
