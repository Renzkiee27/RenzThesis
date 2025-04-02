<?php
// Include the database connection
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    // Validate input
    if (empty($username) || empty($password)) {
        echo "<p class='text-danger'>Username and password are required.</p>";
    } else {
        // Prepare the query to fetch the user by username
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username); // "s" means string
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // Fetch the user
            $user = $result->fetch_assoc();

            // Debugging: Print stored password and entered password for testing
            echo "Stored password: " . $user['password'];
            echo "<br>Entered password: " . $password;

            // Direct comparison of entered password and stored password
            if ($password === $user['password']) {
                // Successful login
                session_start();
                $_SESSION['username'] = $user['username'];
                header("Location: inventory.php"); // Redirect to a dashboard page or home page
                exit();
            } else {
                echo "<p class='text-danger'>Invalid password.</p>";
            }
        } else {
            echo "<p class='text-danger'>User not found.</p>";
        }

        // Close the prepared statement
        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>
