<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

    // Archive the product by setting is_archived = 1
    $sql = "UPDATE inventory_db SET is_archived = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $product_id);

        if ($stmt->execute()) {
            echo "<script>alert('Product archived successfully.'); window.location.href='inventory.php';</script>";
        } else {
            echo "<script>alert('Error archiving product.'); window.location.href='inventory.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error preparing statement.'); window.location.href='inventory.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='inventory.php';</script>";
}

$conn->close();
?>
