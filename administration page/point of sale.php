<?php
session_start();
include 'db_connection.php';

// Fetch products from inventory
$sql = "SELECT * FROM inventory_db";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sundae Brew POS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Sundae Brew Cafe - Point of Sale</h2>
        <div class="row">
            <div class="col-md-8">
                <h4>Product List</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['product_name']; ?></td>
                                <td><?php echo $row['price']; ?></td>
                                <td><?php echo $row['stock']; ?></td>
                                <td>
                                    <button class="btn btn-primary add-to-cart" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['product_name']; ?>" data-price="<?php echo $row['price']; ?>">Add</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <h4>Cart</h4>
                <ul id="cart" class="list-group mb-3"></ul>
                <h5>Total: <span id="total">0</span></h5>
                <button class="btn btn-success" id="checkout">Checkout</button>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
