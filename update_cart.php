<?php
session_start();

// Check if AJAX request is received
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productId']) && isset($_POST['action'])) {
    $productId = $_POST['productId'];
    $action = $_POST['action'];

    // Update cart based on action (increment or decrement)
    if ($action === 'increment') {
        // Increment product count
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]++;
        }
    } elseif ($action === 'decrement') {
        // Decrement product count
        if (isset($_SESSION['cart'][$productId]) && $_SESSION['cart'][$productId] > 1) {
            $_SESSION['cart'][$productId]--;
        }
    }
}
?>
