<?php
session_start();

// Check if AJAX request is received
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productId']) && isset($_POST['action'])) {
    // Check if productId is provided
    $productId = $_POST['productId'];
    $action = $_POST['action'];

    // Check if cart session variable is set, initialize if not
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Update product quantity in cart based on action
    if ($action == 'increment') {
        if (array_key_exists($productId, $_SESSION['cart'])) {
            $_SESSION['cart'][$productId] += 1;
        }
    } elseif ($action == 'decrement') {
        if (array_key_exists($productId, $_SESSION['cart'])) {
            if ($_SESSION['cart'][$productId] > 1) {
                $_SESSION['cart'][$productId] -= 1;
            } else {
                // If quantity becomes 0, remove the product from cart
                unset($_SESSION['cart'][$productId]);
            }
        }
    }

    exit; // Exit after handling AJAX request
}
?>
