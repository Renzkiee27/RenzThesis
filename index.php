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
    <title>Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'?>
    <main>
        <div class="cover">
            <img src="images/sundae cafe front.jpg" alt="" width="100%" height="650px">
        </div>
        <div class="container mt-5 p-5">
            <div class="row">
                <?php if($result->num_rows > 0): ?>
                    <?php while($prod = $result->fetch_assoc()): ?>
                        <div class="col-md-4 mb-3">
                            <div class="card product-card">
                                <img src="uploads/<?php echo ($prod['image'] ?: 'default.png'); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($prod['name']); ?>" style="height: 200px">
                                <div class="card-body text-center">
                                    <h5 class="card-title"> <?php echo htmlspecialchars($prod['name']); ?> </h5>
                                    <p class="card-text">₱<?php echo number_format($prod['price'], 2); ?></p>
                                    <p class="card-text"> <?php echo htmlspecialchars($prod['description']); ?> </p>
                                    <p class="card-text"> <?php echo htmlspecialchars($prod['unit_measurement']); ?> </p>
                                    <p class="card-text"> <?php echo htmlspecialchars($prod['size']); ?> </p>
                                    <button class="btn btn-primary add-to-cart" data-id="<?php echo $prod['id']; ?>" data-name="<?php echo $prod['name']; ?>" data-price="<?php echo $prod['price']; ?>" <?php echo ($prod['quantity'] <= 0) ? 'disabled' : ''; ?>>
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center">No products found.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <script>
        $(document).ready(function(){
            $(".add-to-cart").click(function(){
                var productId = $(this).data("id");
                var name = $(this).data("name");
                var price = $(this).data("price");

                $.ajax({
                    url: "add_to_cart.php",
                    type: "POST",
                    data: { product_id: productId, name: name, price: price, quantity: 1 },
                    success: function(response) {
                        alert(response);
                    }
                });
            });
        });
    </script>
</body>
</html>
