<?php

require_once 'db_connection.php';

if(isset($_POST["btn_signup"])){
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $contact_number = $_POST["contact_number"];


    $sql = "INSERT INTO customer_account (email, username, password, confirm_password, contact_number)
    VALUES ('$email', '$username', '$password', '$confirm_password', '$contact_number')";

if ($conn->query($sql) === TRUE) {
header("Location: index.php");
exit();
} else {
die("Error inserting data: " . $conn->error);
}
        
            // Close the prepared statement
            $stmt->close();
        

}