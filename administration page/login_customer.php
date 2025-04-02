<?php
session_start(); // Ensure session starts at the very beginning

// Include the database connection
include 'db_connection.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]); // Trim input
    $password = trim($_POST["password"]);
    
    // Validate input
    if (empty($username) || empty($password)) {
        echo "<script>alert('Username and password are required.'); window.history.back();</script>";
        exit();
    }

    // Prepare the query to fetch the user by username
    $stmt = $conn->prepare("SELECT * FROM customer_users WHERE username = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $username);
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }
    $result = $stmt->get_result();

    // Debugging: Print the number of rows returned
    echo "Number of rows: " . $result->num_rows;

    if ($result->num_rows === 1) {
        // Fetch the user data
        $user = $result->fetch_assoc();

        // Verify password (plain text comparison)
        if ($password === $user['password']) {
            // Successful login, store session data
            $_SESSION['username'] = $user['username'];

            // Debugging: Print session data
            echo "<pre>";
            print_r($_SESSION);
            echo "</pre>";

            // Redirect to customer dashboard
            header("Location: /../Renz_Thesis/landing page/header_customer.php");
            exit();
        } else {
            echo "<script>alert('Invalid password.'); window.history.back();</script>";
        }
    } else {
        echo "<p>User not found</p>";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>