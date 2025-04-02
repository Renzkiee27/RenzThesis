<?php
include 'db_connection.php';

if($_SERVER["REQUEST_METHOD"] === "POST"){
    //collects data from accounts.php
    $uname = $_POST['name'];
    $password = $_POST['password'];
    $position = $_POST['position'];

    //for activity logs

    $action = "Added an account";
    $user = isset($_SESSION['username']) ? $_SESSION['username'] : 'Unknown user';
    $details = "Added user $username";

    $sql = "INSERT INTO users (username, password, position)
            VALUES ('$uname', '$password', '$position')"; 

    $log_sql = "INSERT INTO activity (action, user, details)
                VALUES ('$action', '$user', '$details')";

    if ($conn->query($sql) === TRUE && $conn->query($log_sql) === TRUE){
        header("Location: users.php");
        exit();
    } else {
        echo "Error" . $sql . "<br>" . $conn->error;
    }

}