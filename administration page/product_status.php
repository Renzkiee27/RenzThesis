<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate if product_id and action are set and not empty
    if (!isset($_POST['product_id']) || !isset($_POST['action']) || empty($_POST['product_id']) || empty($_POST['action'])) {
        echo "<script>alert('Invalid request: Missing product ID or action.'); window.location.href='inventory.php';</script>";
        exit;
    }

    $product_id = intval($_POST['product_id']);
    $action = $_POST['action'];

    if ($action === 'archive') {
        $sql = "UPDATE inventory_db SET is_archived = 1 WHERE id = ?";
        $message = "Product archived successfully.";
    } elseif ($action === 'restore') {
        $sql = "UPDATE inventory_db SET is_archived = 0 WHERE id = ?";
        $message = "Product restored successfully.";
    } else {
        echo "<script>alert('Invalid action.'); window.location.href='inventory.php';</script>";
        exit;
    }

    // Prepare and execute the query
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $product_id);
        if ($stmt->execute()) {
            echo "<script>alert('$message'); window.location.href='inventory.php';</script>";
        } else {
            echo "<script>alert('Error updating product.'); window.location.href='inventory.php';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Database error: Unable to prepare statement.'); window.location.href='inventory.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request method.'); window.location.href='inventory.php';</script>";
}

$conn->close();
?>
