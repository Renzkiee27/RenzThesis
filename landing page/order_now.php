<?php
include 'db_connection.php';

// Fetch cart items
$sql = "SELECT * FROM cart";
$result = $conn->query($sql);   
?>
<?php
session_start(); // Start the session
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
<header class="p-3 bg-dark text-white d-flex justify-content-between align-items-center">
        <img src="../images/SUNDE LGO.png" alt="Logo" width="50px">
        <nav class="d-flex align-items-center">
            <ul class="nav me-4">
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="order_now.php">Orders</a>
                </li>
            </ul>
            <div class="nav2">
                <i class="bi bi-person-circle user-icon"></i> <!-- User Icon -->
                <span><?php echo htmlspecialchars($_SESSION["username"]); ?></span>
                <a href="logout.php" class="logout-link ms-3">Logout</a> <!-- Logout -->
            </div>
        </nav>
    </header>
<div class="container">
    <h2 class="my-4">Carts</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item</th>
                <th>Size</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Status</th>
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
                    $status = isset($row['status']) ? $row['status'] : 'Pending';
                    echo "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['size']}</td>
                        <td>&#8369; ".number_format($row['price'], 2)."</td>
                        <td>{$row['quantity']}</td>
                        <td>&#8369; ".number_format($itemTotal, 2)."</td>
                        <td>{$status}</td>
                        <td>
                            <form action='remove_from_cart.php' method='POST' class='d-inline'>
                                <input type='hidden' name='cart_id' value='{$row['id']}'>
                                <button type='submit' name='remove_item' class='btn btn-danger btn-sm'>Remove</button>
                            </form>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>Cart is empty</td></tr>";
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Total Amount</th>
                <th>&#8369; <?php echo number_format($totalAmount, 2); ?></th>
                <th colspan="2">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#checkoutModal">Checkout</button>
                </th>
            </tr>
        </tfoot>
    </table>
</div>
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkoutModalLabel">Checkout</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="submit_order.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="customerName" name="customerName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" id="customerAddress" name="customerAddress" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="customerPhone" name="customerPhone" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Method</label>
                        <select name="paymentMethod" id="paymentMethod" class="form-control">
                            <option value="Cash on Delivery">Cash on Delivery</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Submit Order</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<?php $conn->close(); ?>