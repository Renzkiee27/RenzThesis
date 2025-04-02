<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $contact_number = $_POST["contact_number"];

    if (empty($email) || empty($username) || empty($password) || empty($confirm_password) || empty($contact_number)) {
        echo "<p class='text-danger'>Please fill in all the fields.</p>";
        exit();
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<p class='text-danger'>Passwords do not match.</p>";
        exit();
    }

    // Hash the password before storing
    
    // Prepare SQL query
    $stmt = $conn->prepare("INSERT INTO customer_users (email, username, password, contact_number) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $email, $username, $password, $contact_number);

    // Execute the statement and check if successful
    if ($stmt->execute()) {
        header("Location: /../Renz_Thesis/landing page/index.php");
        exit();
    } else {
        echo "<p class='text-danger'>Registration failed. Please try again.</p>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    header("Location: ../landing page/header.php");
    exit();
}
