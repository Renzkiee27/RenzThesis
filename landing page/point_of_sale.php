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
                        <?php while ($row = $result->fetch_assoc()){ ?>
                            <tr>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo number_format($row['price'], 2); ?></td>
                                <td><?php echo $row['quantity']; ?></td>
                                <td>
                                    <form method="POST" action="cart.php">
                                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                        <input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
                                        <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
                                        <button type="submit" name="add_to_cart" class="btn btn-primary">Add</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <h4>Cart</h4>
                <ul id="cart" class="list-group mb-3">
                    <?php 
                    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                        $total = 0;
                        foreach ($_SESSION['cart'] as $key => $item) {
                            $total += $item['price'] * $item['quantity'];
                            echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
                            echo $item['name'] . " - &#8369;" . number_format($item['price'], 2) . " x " . $item['quantity'];
                            echo "<form method='POST' action='remove_from_cart.php' class='ms-2'>";
                            echo "<input type='hidden' name='cart_key' value='$key'>";
                            echo "<button type='submit' name='remove_item' class='btn btn-danger btn-sm'>Remove</button>";
                            echo "</form>";
                            echo "</li>";
                        }
                        echo "<li class='list-group-item'><strong>Total: &#8369;" . number_format($total, 2) . "</strong></li>";
                    } else {
                        echo "<li class='list-group-item text-center'>Cart is empty</li>";
                    }
                    ?>
                </ul>
                <form method="POST" action="checkout.php">
                    <button type="submit" class="btn btn-success" <?php echo (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) ? '' : 'disabled'; ?>>Checkout</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
