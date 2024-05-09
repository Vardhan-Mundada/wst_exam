<?php
session_start();

if (isset($_POST['ProductID'])) {
    $productId = $_POST['ProductID'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (array_key_exists($productId, $_SESSION['cart'])) {
        $_SESSION['cart'][$productId] += 1;
        echo "Quantity increased for the product in cart.";
    } else {
        $_SESSION['cart'][$productId] = 1;
        echo "Product added to cart successfully.";
    }
} else {
    echo "Product ID not provided.";
}
?>
