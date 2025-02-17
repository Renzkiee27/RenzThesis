<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_product'])) {
    // Check if product_id is set
    if (!isset($_POST['product_id']) || empty($_POST['product_id'])) {
        die("Error: No product ID provided.");
    }

    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $product = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : 'Unknown Product';

    // Activity log details
    $action = "Deleted a product";
    $user = isset($_SESSION['username']) ? $_SESSION['username'] : 'Unknown user';
    $details = "Deleted the product: " . $product;

    // Delete query
    $sql = "DELETE FROM inventory_db WHERE id='$product_id'";

    // Log query
    // $log_sql = "INSERT INTO activity (action, user, details) VALUES ('$action', '$user', '$details')";

    // Execute both queries
    if ($conn->query($sql) === TRUE) {
        // Log the deletion (optional)
        // $conn->query($log_sql);

        // Redirect after successful deletion
        header("Location: inventory.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>
