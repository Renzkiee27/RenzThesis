<?php
include 'db_connection.php';

if (isset($_POST['delete_product'])) {
    $product_id = $_POST['product_id'];

    // Move product to archive instead of deleting
    $sql = "UPDATE inventory_db SET is_archived = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        header("Location: inventory.php?message=Product archived successfully");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
