<?php
session_start();

// Check if productId is provided
if (isset($_POST['productId'])) {
    $productId = $_POST['productId'];

    // Check if cart session variable is set, initialize if not
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add productId to cart
    if (!in_array($productId, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $productId;
        echo "Product added to cart successfully.";
    } else {
        echo "Product already exists in cart.";
    }
} else {
    echo "Product ID not provided.";
}
?>
