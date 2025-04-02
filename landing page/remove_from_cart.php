<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cart_id = $_POST['cart_id'];

    $sql = "DELETE FROM cart WHERE id = $cart_id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: cart.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
