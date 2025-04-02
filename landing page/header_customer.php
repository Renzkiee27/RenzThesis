<?php
session_start();
include 'db_connection.php';

// Redirect to login if the user is not logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$search = "";
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $sql = "SELECT * FROM inventory_db WHERE (name LIKE '%$search%' OR description LIKE '%$search%') AND is_archived = 0";
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
    <title>Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="index.css">
    <style>
        body {
            background: url('../images/renz.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .product-card {
            transition: transform 0.2s, box-shadow 0.2s;
            height: 100%;   
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px 8px 0 0;
        }
        .search-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }
        .search-container input {
            width: 60%;
            padding: 10px;
            border: 2px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }
        .search-container button {
            padding: 10px 15px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .search-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<header class="p-3 bg-dark text-white d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <img src="../images/SUNDE LGO.png" alt="Logo" width="60px" class="me-3">
    </div>
    <nav class="d-flex align-items-center">
        <ul class="nav me-4">
            <li class="nav-item">
                <a class="nav-link text-white" href="menu.php">Menu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="order_now.php">Orders</a>
            </li>
        </ul>
        <div class="nav2 d-flex align-items-center">
            <i class="bi bi-person-circle user-icon me-2" style="font-size: 1.5rem;"></i>
            <span class="me-3"><?php echo htmlspecialchars($_SESSION["username"]); ?></span>
            <a href="logout.php" class="logout-link btn btn-outline-light btn-sm">Logout</a>
        </div>
    </nav>
</header>

<div class="container mt-4">
    <h1 class="text-center mb-4 text-white">Menu</h1>
    <form method="GET" class="search-container">
        <input type="text" name="search" class="form-control" placeholder="Search menu..." value="<?php echo isset($search) ? htmlspecialchars($search) : ''; ?>">
        <button type="submit"><i class="bi bi-search"></i> Search</button>
    </form>
</div>
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
                            <p class="card-text"><?php echo htmlspecialchars($prod['description']); ?></p>
                            
                            <!-- Size Dropdown -->
                            <select class="form-control mb-2 size-select" data-id="<?php echo $prod['id']; ?>">
                                <option value="">Select Size</option>
                                <option value="small" data-price="0">Small</option>
                                <option value="medium" data-price="10">Medium (+₱20)</option>
                                <option value="large" data-price="15">Large (+₱40)</option>
                            </select>
                            
                            <!-- Add-ons Dropdown -->
                            <select class="form-control mb-2 addon-select" data-id="<?php echo $prod['id']; ?>">
                                <option value="">Select Add-on (Optional)</option>
                                <option value="extra_cheese" data-price="20">Extra Nata (+₱20)</option>
                                <option value="extra_sauce" data-price="15">Extra Boba (+₱15)</option>
                                <option value="double_meat" data-price="30">Extra Syrup (+₱15)</option>
                            </select>

                            <button class="btn btn-primary add-to-cart" 
                                    data-id="<?php echo $prod['id']; ?>" 
                                    data-name="<?php echo $prod['name']; ?>" 
                                    data-price="<?php echo $prod['price']; ?>" 
                                    <?php echo ($prod['quantity'] <= 0) ? 'disabled' : ''; ?>>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center text-light">No menu items found.</p>
        <?php endif; ?>
    </div>
</div>

<script>
    document.querySelectorAll('.addon-select, .size-select').forEach(select => {
        select.addEventListener('change', function() {
            let selectedOption = this.options[this.selectedIndex];
            let addToCartButton = this.parentElement.querySelector('.add-to-cart'); 
            let basePrice = parseFloat(addToCartButton.getAttribute('data-price'));
            let extraPrice = selectedOption.dataset.price ? parseFloat(selectedOption.dataset.price) : 0;
            let totalPrice = basePrice + extraPrice;
            addToCartButton.setAttribute('data-price', totalPrice);
        });
    });
</script>


</body>
</html>
