<?php
session_start();
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];

    // Add the product to the cart
    $_SESSION['cart'][$product_id] = array(
        'name' => $product_name,
        'price' => $product_price,
        'qty' => 1
    );

    // Redirect back to the products page
    header('Location: products.php');
    exit();
}
?>