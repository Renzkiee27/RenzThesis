<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

    // Restore the product by setting is_archived to 0
    $sql = "UPDATE inventory_db SET is_archived = 0 WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $product_id);
        if ($stmt->execute()) {
            echo "<script>alert('Product restored successfully.'); window.location.href='archived_products.php';</script>";
        } else {
            echo "<script>alert('Error restoring product.'); window.location.href='archived_products.php';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Error preparing statement.'); window.location.href='archived_products.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='archived_products.php';</script>";
}

$conn->close();
?>
