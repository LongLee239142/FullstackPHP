<?php
// Include database connection
include 'php/dbconnect.php';
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $user_id = $_SESSION['user_id']; // Assuming you have the user ID stored in a session
    $address = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $zip_code = $_POST['zip_code'];
    $payment_method_id = 1; // Assuming the default payment method ID for credit card is 1

    // Calculate the total manually
    $total_amount = 0;
    foreach ($_SESSION['cart_shop'] as $item) {
        $total_amount += $item['price'] * $item['quantity'];
    }

    // Prepare and execute SQL statement to save order information to the database
    $sql_order_info = "INSERT INTO order_info (user_id, total_amount, address, city, country, zip_code, payment_method_id)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_order_info = $conn->prepare($sql_order_info);
    $stmt_order_info->bind_param("idssssi", $user_id, $total_amount, $address, $city, $country, $zip_code, $payment_method_id);
    $stmt_order_info->execute();

    // Get the order ID of the newly inserted order
    $order_id = $stmt_order_info->insert_id;

    // Prepare and execute SQL statement to save order details to the database
    foreach ($_SESSION['cart_shop'] as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $price = $item['price'];
        
        $sql_order_detail = "INSERT INTO order_detail (order_id, product_id, quantity, price)
                            VALUES (?, ?, ?, ?)";
        $stmt_order_detail = $conn->prepare($sql_order_detail);
        $stmt_order_detail->bind_param("iiid", $order_id, $product_id, $quantity, $price);
        $stmt_order_detail->execute();
    }

    // Check if the order and order details are successfully saved
    if ($stmt_order_info->affected_rows > 0 && $stmt_order_detail->affected_rows > 0) {
        // Clear the cart
        $_SESSION['cart_shop'] = array();

        // Redirect to order_list.php
        header("Location: order_list.php");
        exit();
    } else {
        // Failed to save order or order details
        echo "Error placing order!";
    }

    // Close statements and database connection
    $stmt_order_info->close();
    $stmt_order_detail->close();
    $conn->close();
} else {
    // If the form is not submitted, redirect back to the checkout page
    header("Location: checkout.php");
    exit();
}
?>
