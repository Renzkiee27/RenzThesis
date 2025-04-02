<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sundae Brew Cafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <?php include 'header.php'; ?>
    
    <main class="container my-5">
        <!-- Home Section -->
        <section id="home" class="text-center py-5">
            <h1 class="display-3 fw-bold">Sundae Brew Cafe</h1>
            <img src="../images/sundae-removebg-preview.png" class="img-fluid" alt="Sundae Brew Logo">
        </section>
        
        <hr>
        
        <!-- Menu Section -->
        <section id="menu" class="py-5">
            <h1 class="text-center mb-4">New Products</h1>
            <div class="row">
                <?php 
                include 'db_connection.php';
                $sql = "SELECT * FROM inventory_db";
                $result = $conn->query($sql);
                if ($result->num_rows > 0):
                    while ($prod = $result->fetch_assoc()): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="uploads/<?php echo ($prod['image'] ?: 'default.png'); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($prod['name']); ?>">
                                <div class="card-body text-center">
                                    <h5 class="card-title"> <?php echo htmlspecialchars($prod['name']); ?> </h5>
                                    <p class="card-text">₱<?php echo number_format($prod['price'], 2); ?></p>
                                    <button class="btn btn-primary add-to-cart" data-id="<?php echo $prod['id']; ?>" data-name="<?php echo $prod['name']; ?>" data-price="<?php echo $prod['price']; ?>" <?php echo ($prod['quantity'] <= 0) ? 'disabled' : ''; ?>>
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile;
                else: ?>
                    <p class="text-center">No products found.</p>
                <?php endif; ?>
            </div>
        </section>
        
        <hr>
        
        <!-- Contact Section -->
        <section id="contact" class="py-5">
            <h1 class="text-center mb-4">Contact</h1>
            <p class="text-center">If you have any questions, feel free to reach out to us!</p>
            <p class="text-center">Email: <a href="mailto:bibim_buzz@gmail.com">bibim_buzz@gmail.com</a></p>
            <p class="text-center">Phone: 09309561713</p>
        </section>
        
        <hr>
        
        <!-- Cart Section -->
        <section class="container my-5">
            <h2 class="my-4 text-center">Your Cart</h2>
            <table class="table table-bordered text-center">
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
                    $sql = "SELECT * FROM cart";
                    $result = $conn->query($sql);
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
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#checkoutModal">Checkout</button>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </section>
    </main>
    
    <script>
        $(document).ready(function() {
            $(".add-to-cart").click(function() {
                var productId = $(this).data("id");
                var name = $(this).data("name");
                var price = $(this).data("price");

                $.ajax({
                    url: "add_to_cart.php",
                    type: "POST",
                    data: {
                        product_id: productId,
                        name: name,
                        price: price,
                        quantity: 1
                    },
                    success: function(response) {
                        alert(response);
                    }
                });
            });
        });
    </script>
</body>

</html>
