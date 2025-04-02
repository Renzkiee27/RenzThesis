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
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#checkoutModal">Checkout</button>
                </th>
            </tr>
        </tfoot>
    </table>
</div>
<div class="modal fade" id="checkoutModal" tabindex="-1" arial-labelleby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkoutModalLabel">checkout</h5>
                <button class="btn-close" id="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="submit_order.php">
                    <div class="mb-3">
                        <label for="" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="customerName" name="customerName">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">address</label>
                        <input type="text" class="form-control" id="customerAddress" name="customerAddress">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="customerPhone" name="customerPhone">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">payment Method</label>
                        <select name="paymentMethod" id="paymentMethod" class="form-control">
                            <option value="Cash on Delivery">Cash on Delivery</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<?php $conn->close(); ?>
