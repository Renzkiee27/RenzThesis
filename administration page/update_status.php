<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cart_id"]) && isset($_POST["status"])) {
    $cart_id = $conn->real_escape_string($_POST["cart_id"]);
    $status = $conn->real_escape_string($_POST["status"]);

    // Update the status in the database
    $sql = "UPDATE cart SET status = '$status' WHERE id = '$cart_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: cart.php"); // Redirect back to cart page
        exit();
    } else {
        echo "Error updating status: " . $conn->error;
    }
}

$conn->close();
?>
