<?php
session_start();

// Check if productId is provided
if (isset($_POST['productId'])) {
    $productId = $_POST['productId'];

    // Check if cart session variable is set
    if (isset($_SESSION['cart'])) {
        // Find and remove productId from cart
        $index = array_search($productId, $_SESSION['cart']);
        if ($index !== false) {
            unset($_SESSION['cart'][$index]);
            echo "Product removed from cart successfully.";
        } else {
            echo "Product not found in cart.";
        }
    } else {
        echo "Cart is empty.";
    }
} else {
    echo "Product ID not provided.";
}
?>
