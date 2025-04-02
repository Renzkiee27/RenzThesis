<?php
include 'db_connection.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 30px;
        }
        .table th {
            background-color: #343a40;
            color: white;
            text-align: center;
        }
        .table td {
            vertical-align: middle;
            text-align: center;
        }
        .btn-remove {
            background-color: #dc3545;
            color: white;
        }
        .btn-update {
            background-color: #007bff;
            color: white;
        }
        .btn-checkout, .btn-receipt {
            width: 150px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4 text-center">Customer Orders</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Item</th>
                        <th>Size</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Address</th>
                        <th>Contact No.</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db_connection.php';
                    $sql = "SELECT * FROM cart";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>N/A</td>
                                <td>{$row['name']}</td>
                                <td>Regular</td>
                                <td>&#8369;" . number_format($row['price'], 2) . "</td>
                                <td>{$row['quantity']}</td>
                                <td>&#8369;" . number_format($row['total_price'], 2) . "</td>
                                <td>N/A</td>
                                <td>N/A</td>
                                <td>
                                    <select class='form-select'>
                                        <option>Pending</option>
                                        <option>Completed</option>
                                        <option>Cancelled</option>
                                    </select>
                                </td>
                                <td>
                                    <button class='btn btn-update btn-sm'>Update</button>
                                    <form action='remove_from_cart.php' method='POST' class='d-inline'>
                                        <input type='hidden' name='cart_id' value='{$row['id']}'>
                                        <button type='submit' name='remove_item' class='btn btn-remove btn-sm'>Remove</button>
                                    </form>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10' class='text-center'>Cart is empty</td></tr>";
                    }
                    if ($conn) {
                        $conn->close();
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="text-center mt-3">
            <button class="btn btn-primary btn-checkout" data-bs-toggle="modal" data-bs-target="#checkoutModal">Checkout</button>
            <button class="btn btn-secondary btn-receipt">View Receipt</button>
        </div>
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
                            <input type="text" class="form-control" name="customerName" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="customerAddress" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" class="form-control" name="customerPhone" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Payment Method</label>
                            <select name="paymentMethod" class="form-control" required>
                                <option value="Cash on Delivery">Cash on Delivery</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Submit Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
