<?php 
    include 'db_connection.php';
    $sql = "SELECT * FROM inventory_db";
    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <?php include 'header.php' ?>
    <div class="container">
        <h2>Checkout</h2>
        <div class="mb-3">
            <label for="" class="form-label">Name</label>
            <input type="text" name="" id="" class="form-control">
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Phone Number</label>
            <input type="number" name="" id="" class="form-control">
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Address</label>
            <input type="text" name="" id="" class="form-control">  
        </div>
        <div class="btn btn-primary">Checkout</div>
    </div>
</body>
</html>