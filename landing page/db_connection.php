<?php
// db_connection.php

$servername = "localhost";  // Database server
$username = "root";         // Database username
$password = "";             // Database password (for local development, it's empty by default)
$dbname = "sundae_brew";  // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
