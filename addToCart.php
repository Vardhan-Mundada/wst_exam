<?php
session_start();

// Check if productId is provided
if (isset($_POST['ProductID'])) {
    $productId = $_POST['ProductID'];

    // Check if cart session variable is set, initialize if not
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if product already exists in cart
    if (array_key_exists($productId, $_SESSION['cart'])) {
        // If product exists, increase its quantity
        $_SESSION['cart'][$productId] += 1;
        echo "Quantity increased for the product in cart.";
    } else {
        // Add productId to cart with quantity 1
        $_SESSION['cart'][$productId] = 1;
        echo "Product added to cart successfully.";
    }
} else {
    echo "Product ID not provided.";
}
?>
