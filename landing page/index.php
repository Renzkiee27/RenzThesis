<?php
include 'db_connection.php';

$search = "";
if(isset($_GET["search"])){
    $search = $conn->real_escape_string($_GET["search"]);
    $sql = "SELECT * FROM inventory_db WHERE (description LIKE '%$search%' OR name LIKE '%$search%') AND is_archived = 0";
} else {
    $sql = "SELECT * FROM inventory_db WHERE is_archived = 0";
}

$result = $conn->query($sql);
?>
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
    <style>
        /* Custom CSS for image and card styling */
        .product-card {
            transition: transform 0.2s, box-shadow 0.2s;
            height: 100%; /* Ensure all cards have the same height */
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .product-card img {
            width: 100%; /* Ensure the image takes up the full width of the card */
            height: 200px; /* Set a fixed height for all images */
            object-fit: cover; /* Maintain aspect ratio without distortion */
            border-radius: 8px 8px 0 0; /* Rounded corners for the top of the image */
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin: 1rem 0;
        }

        .card-text {
            margin: 0.5rem 0;
            color: #555;
        }

        .add-to-cart {
            margin-top: 1rem;
            width: 100%;
        }
    </style>
</head>

<body>
    <?php include 'header.php' ?>
    <main>
        <div id="home" class="home">
            <div class="title-cont">
                <h1>
                    <span>S</span>
                    <span>u</span>
                    <span>n</span>
                    <span>d</span>
                    <span>a</span>
                    <span>e</span>
                </h1>
                <h2>Brew</h2>
                <h3>Cafe</h3>
            </div>
            <img src="../images/sundae_cafe-removebg-preview.png">
        </div>
        <hr>
        <div id="menu" class="menu">
            <h1 class="text-center mb-4">New Product</h1>
            <form method="GET" class="search-bar mb-4 d-flex justify-content-center">
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search product..." class="form-control me-2"/>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
            <div class="container mt-5 p-5">
                <div class="row">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($prod = $result->fetch_assoc()): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card product-card">
                                    <img src="../administration page/uploads/<?php echo htmlspecialchars($prod['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($prod['name']); ?>" 
                                         onerror="this.onerror=null; this.src='images/default-placeholder.png';">
                                    <div class="card-body text-center">
                                        <h5 class="card-title"><?php echo htmlspecialchars($prod['name']); ?></h5>
                                        <p class="card-text">₱<?php echo number_format($prod['price'], 2); ?></p>
                                        <button class="btn btn-primary add-to-cart" 
                                                data-id="<?php echo $prod['id']; ?>" 
                                                data-name="<?php echo $prod['name']; ?>" 
                                                data-price="<?php echo $prod['price']; ?>" 
                                                <?php echo ($prod['quantity'] <= 0) ? 'disabled' : ''; ?>>
                                            Sign-up first
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
        </div>
    </main>
</body>
</html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Sundae Brew Cafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .section-container {
            padding: 50px 0;
        }
        .contact-section {
            background-color: #f8f9fa;
            padding: 50px 0;
        }
    </style>
</head>
<body>
    <main>
        <!-- About Us Section -->
        <section id="about" class="section-container text-center">
            <div class="container">
                <h1 class="mb-4">About Us</h1>
                <img src="../images/sssssss.jpg" alt="Sundae Brew Cafe Front" class="img-fluid rounded" style="width: 80%; max-height: 400px; object-fit: cover;">
                <div class="mt-4 text-start">
                    <p>Welcome to <strong>Sundae Brew Cafe</strong>—where every sip and bite is crafted with passion! ☕🍦</p>
                    <p>At Sundae Brew Cafe, we believe that great coffee and delightful treats bring people together. Our cozy space is designed for you to unwind, catch up with friends, or work on your latest project—all while enjoying our expertly brewed beverages and handcrafted desserts.</p>
                    <p>We take pride in using high-quality ingredients, ensuring that every cup and plate is made with love. Our dedicated team is committed to providing excellent service and creating a warm, inviting atmosphere for all.</p>
                    <p>Come visit <strong>Sundae Brew Cafe</strong> and indulge in the perfect blend of flavors, comfort, and community.</p>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="contact-section text-center">
            <div class="container">
                <h1 class="mb-4">Contact Us</h1>
                <p>If you would like to learn more about our services or have any questions, feel free to reach out to us!</p>
                <p><strong>📧 Email:</strong> <a href="mailto:valdezrenzchristian@gmail.com">valdezrenzchristian@gmail.com</a></p>
                <p><strong>📞 Phone:</strong> 0930-956-1713</p>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (window.location.search.includes("search=")) {
                window.location.hash = "#menu"; // Redirects to the menu section after search
            }
        });
    </script>
</body>
</html>