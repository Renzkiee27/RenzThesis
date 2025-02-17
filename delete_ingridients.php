<?php
include 'db_connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_product'])) {
    // Get the product ID from the form submission
    $product_id = $_POST['product_id'];

    // Ensure that the product_id is a valid number
    if (is_numeric($product_id)) {
        // Prepare and bind the delete query
        $stmt = $conn->prepare("DELETE FROM ingredients WHERE id = ?");
        $stmt->bind_param("i", $product_id);  // "i" means integer
        $stmt->execute();

        // Check if the deletion was successful
        if ($stmt->affected_rows > 0) {
            // Redirect back to the inventory page after successful deletion
            header("Location: ingridients.php");
            exit(); // Ensure no further code is executed after the redirect
        } else {
            // If no rows were affected, display an error
            echo "Error: Item not found or could not be deleted.";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "Invalid product ID.";
    }
}

// Close the database connection
$conn->close();
?>
