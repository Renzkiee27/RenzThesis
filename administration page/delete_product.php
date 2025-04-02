<?php
include 'db_connection.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = intval($_GET['id']);

    // Delete the product from the database
    $sql = "DELETE FROM inventory_db WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $product_id);
        if ($stmt->execute()) {
            echo "<script>alert('Product deleted successfully.'); window.location.href='inventory.php';</script>";
        } else {
            echo "<script>alert('Error deleting product.'); window.location.href='inventory.php';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Error preparing statement.'); window.location.href='inventory.php';</script>";
    }
} else {
    echo "<script>alert('Invalid product ID.'); window.location.href='inventory.php';</script>";
}
?>
