<?php
// Include database connection
include 'db_connection.php';

// Ensure the is_archived column exists
$checkColumn = "SHOW COLUMNS FROM inventory_db LIKE 'is_archived'";
$result = $conn->query($checkColumn);
if ($result->num_rows == 0) {
    $alterTable = "ALTER TABLE inventory_db ADD COLUMN is_archived TINYINT(1) DEFAULT 0";
    if (!$conn->query($alterTable)) {
        die("Error adding column: " . $conn->error);
    }
}

// Handle form submission for adding a new product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_item'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);
    $unit_measurement = isset($_POST['unit_measurement']) ? $conn->real_escape_string($_POST['unit_measurement']) : '';
    $category = $conn->real_escape_string($_POST['category']);
    $size = $conn->real_escape_string($_POST['size']);
    
    // Ensure the uploads directory exists
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    $imageName = "";
    if (!empty($_FILES["image"]["name"])) {
        // Handle image upload
        $imageName = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $imageName;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedTypes)) {
            die("Error: Invalid file type. Only JPG, JPEG, PNG, and GIF allowed.");
        }

        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            die("Error: Failed to move uploaded file.");
        }
    }

    $sql = "INSERT INTO inventory_db (name, description, price, quantity, unit_measurement, category, size, image, is_archived) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssissss", $name, $description, $price, $quantity, $unit_measurement, $category, $size, $imageName);
    
    if ($stmt->execute()) {
        echo "<script>alert('Product added successfully!'); window.location.href='inventory.php';</script>";
    } else {
        die("Error inserting data: " . $stmt->error);
    }
    
    $stmt->close();
}

// Handle product archiving
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['archive_product']) && !empty($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $sqlArchive = "UPDATE inventory_db SET is_archived = 1 WHERE id = ?";
    $stmt = $conn->prepare($sqlArchive);
    $stmt->bind_param("i", $product_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Product archived successfully!'); window.location.href='inventory.php';</script>";
    } else {
        die("Error archiving product: " . $stmt->error);
    }
    $stmt->close();
}

// Fetch updated product list (only non-archived products)
$sql = "SELECT * FROM inventory_db WHERE is_archived = 0";
$result = $conn->query($sql);

// Fetch inventory items for index.php (only non-archived products)
$sqlFetch = "SELECT id, name, image FROM inventory_db WHERE is_archived = 0";
$resultFetch = $conn->query($sqlFetch);

if ($resultFetch->num_rows > 0) {
    echo "<h2>Inventory List</h2>";
    echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Image</th></tr>";
    while ($row = $resultFetch->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td><img src='uploads/{$row['image']}' width='50' height='50'></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No records found.";
}

$conn->close();
?>
