<?php

include 'dbconnect.php';
session_start();
// Function to add product to cart
function addToCart($productId, $quantity = 1)
{
    global $conn;
    $sql = "SELECT p.*, c.category_name FROM products p LEFT JOIN categories c ON p.category_id = c.category_id WHERE product_id = $productId";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if ($row) {
        if (isset($_SESSION['cart_shop'][$productId])) {
            $_SESSION['cart_shop'][$productId]['quantity'] += $quantity;
        } else {
            $_SESSION['cart_shop'][$productId] = [
                'product_id' => $row['product_id'],
                'imageproduct' => $row['image'],
                'category_name' => $row['category_name'],
                'product_name' => $row['product_name'],
                'price' => $row['price'],
                'quantity' => $quantity
            ];
        }
    }
}

// The function updates the number of products in the shopping cart
function updateCartQuantity($productId, $quantity)
{
    if ($quantity <= 0) {
        unset($_SESSION['cart_shop'][$productId]); // If quantity is 0 or negative, remove product from cart
    } else {
        $_SESSION['cart_shop'][$productId]['quantity'] = $quantity;
    }
}
function removeQuantity($productId)
{
    unset($_SESSION['cart_shop'][$productId]); // remove product from cart
}

// The function calculates the total amount of the shopping cart
function calculateTotal()
{
    $total = 0;
    foreach ($_SESSION['cart_shop'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}
