<?php
include 'db_connection.php';

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])){
    $user_id = $_POST['user_id'];

    //

    $action = "Deleted an account";
    $user = isset($_SESSION['username']) ? $_SESSION['username'] : 'Unknown user';
    $details = "Deleted user $user_id";

    $sql = "DELETE FROM users WHERE id='$user_id'"; 

    $log_sql = "INSERT INTO activity (action, user, details)
                VALUES ('$action', '$user', '$details')";

    if ($conn->query($sql) === TRUE && $conn->query($log_sql) === TRUE){
        header("Location: users.php");
        exit();
    } else {
        echo "Error" . $sql . "<br>" . $conn->error;
    }

}
