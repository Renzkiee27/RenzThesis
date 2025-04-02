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
    $sql = "SELECT * FROM inventory_db WHERE description LIKE '%$search%' OR name LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM inventory_db";
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .product-card img {
            height: 200px;
            object-fit: cover;
        }
        .search-bar {
            max-width: 400px;
            margin: 0 auto;
        }
    </style>
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
                    <a class="nav-link text-white" href="#">Orders</a>
                </li>
            </ul>
            <div class="nav2">
                <i class="bi bi-person-circle user-icon"></i>
                <span><?php echo htmlspecialchars($_SESSION["username"]); ?></span>
                <a href="#" class="logout-link ms-3" onclick="confirmLogout(event)">Logout</a>
            </div>
        </nav>
    </header>

    <div id="menu" class="menu container mt-5">
        <h1 class="text-center mb-4">Menu</h1>
        <form method="GET" class="search-bar mb-4 d-flex">
            <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search product..." class="form-control me-2"/>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($prod = $result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card product-card shadow-sm">
                            <img src="../uploads/<?php echo htmlspecialchars($prod['image']); ?>" class="card-img-top" 
                                 alt="<?php echo htmlspecialchars($prod['name']); ?>" 
                                 onerror="this.onerror=null; this.src='images/default-placeholder.png';">
                            <div class="card-body text-center">
                                <h5 class="card-title"><?php echo htmlspecialchars($prod['name']); ?></h5>
                                <p class="card-text text-success fw-bold">₱<?php echo number_format($prod['price'], 2); ?></p>
                                <p class="card-text text-muted"><?php echo htmlspecialchars($prod['description']); ?></p>
                                <button class="btn btn-primary add-to-cart" 
                                        data-id="<?php echo $prod['id']; ?>" 
                                        data-name="<?php echo $prod['name']; ?>" 
                                        data-price="<?php echo $prod['price']; ?>">
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

    <script>
        function confirmLogout(event) {
            event.preventDefault();
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = "logout.php";
            }
        }
    </script>
</body>
</html>
