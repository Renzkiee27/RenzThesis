<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = 1; // Default quantity

    // Check if product already exists in cart
    $checkCart = $conn->query("SELECT * FROM cart WHERE product_id = $product_id");

    if ($checkCart->num_rows > 0) {
        // If product exists, update quantity
        $conn->query("UPDATE cart SET quantity = quantity + 1, total_price = price * quantity WHERE product_id = $product_id");
    } else {
        // Insert new product into cart
        $total_price = $price * $quantity;
        $sql = "INSERT INTO cart (product_id, name, price, quantity, total_price) 
                VALUES ($product_id, '$name', $price, $quantity, $total_price)";

        if ($conn->query($sql) === TRUE) {
            echo "Added to cart successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>
