<?php
include 'db_connection.php';

// Fetch cart items
$sql = "SELECT * FROM cart";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Cart</title>
</head>
<body>
<?php include 'header.php' ?>
<div class="container">
    <h2 class="my-4">Cart</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totalAmount = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $itemTotal = $row['total_price'];
                    $totalAmount += $itemTotal;
                    echo "<tr>
                        <td>{$row['name']}</td>
                        <td>&#8369; ".number_format($row['price'], 2)."</td>
                        <td>{$row['quantity']}</td>
                        <td>&#8369; ".number_format($itemTotal, 2)."</td>
                        <td>
                            <form action='remove_from_cart.php' method='POST' class='d-inline'>
                                <input type='hidden' name='cart_id' value='{$row['id']}'>
                                <button type='submit' name='remove_item' class='btn btn-danger btn-sm'>Remove</button>
                            </form>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>Cart is empty</td></tr>";
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total Amount</th>
                <th>&#8369; <?php echo number_format($totalAmount, 2); ?></th>
                <th>
                    <button class="btn btn-primary btn-sm">Checkout</button>
                </th>
            </tr>
        </tfoot>
    </table>
</div>
</body>
</html>

<?php $conn->close(); ?>
