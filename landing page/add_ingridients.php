<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = $conn->real_escape_string($_POST['price']);
    $quantity = $conn->real_escape_string($_POST['quantity']);
    $expiration_date = $conn->real_escape_string($_POST['expiration_date']);
    $unit_measurement = $conn->real_escape_string($_POST['unit_measurement']);

    // // Check for file upload errors
    // if (!isset($_FILES["image"]) || $_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
    //     die("Error: File upload failed with error code " . $_FILES["image"]["error"]);
    // }

    // // Ensure the upload directory exists
    // $targetDir = "uploads/";
    // if (!is_dir($targetDir) || !is_writable($targetDir)) {
    //     die("Error: Upload directory does not exist or is not writable.");
    // }

    // // Handle unique file name
    // $imageName = time() . "_" . basename($_FILES["image"]["name"]);
    // $targetFilePath = $targetDir . $imageName;
    // $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // // Validate Image Type
    // $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    // if (!in_array($imageFileType, $allowedTypes)) {
    //     die("Error: Invalid file type. Only JPG, JPEG, PNG, and GIF allowed.");
    // }

    // Move the uploaded file
    // if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
    //     // Verify file upload success
    //     if (!file_exists($targetFilePath)) {
    //         die("Error: File was not successfully uploaded.");
    //     }

        // Insert into database
        $sql = "INSERT INTO ingredients (name, description, price, quantity, expiration_date, unit_measurement)
                VALUES ('$name', '$description', '$price', '$quantity', '$expiration_date', '$unit_measurement')";

        if ($conn->query($sql) === TRUE) {
            echo "File uploaded and data inserted successfully.";
            header("Location: ingridients.php");
            exit();
        } else {
            die("Error inserting data: " . $conn->error);
        }
    } else {
        die("Error: Failed to move uploaded file.");
    }


// Close connection
$conn->close();
?>
