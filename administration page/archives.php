<?php
include 'db_connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archived Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
       body {
    font-family: Arial, sans-serif;
    display: flex;
}

.sidebar {
    background-color: #343a40;
    color: white;
    width: 200px; /* Set a fixed width for proper spacing */
    min-height: 100vh;
    padding: 15px;
    position: fixed;
    left: 0;
    top: 0;
    bottom: 0;
}

.sidebar a {
    color: #f8f9fa;
    text-decoration: none;
    padding: 10px;
    display: block;
}

.sidebar a:hover {
    background-color: #495057;
}

.main-content {
    margin-left: 270px; /* Adjust this based on sidebar width */
    padding: 20px;
    width: calc(100% - 270px); /* Ensure proper spacing */
}

.table th, .table td {
    vertical-align: middle;
}

    </style>
</head>
<body>
<div class="container mt-4">
    <div class="row">
<nav class="col-md-3 col-lg-2 d-md-block sidebar p-3">
            <h4 class="text-center">Sundae Brew</h4>
            <ul class="nav flex-column">
                <li><a href="#" class="nav-link"><i class="bi-house"></i> Home</a></li>
                <li><a href="#" class="nav-link"><i class="bi-speedometer2"></i> Dashboard</a></li>
                <li><a href="point_of_sale2.php" class="nav-link"><i class="bi-table"></i> Orders</a></li>
                <li>
                    <a href="#submenuInventory" class="nav-link" data-bs-toggle="collapse"><i class="bi-grid"></i> Inventory</a>
                    <div class="collapse" id="submenuInventory">
                        <a href="inventory.php" class="nav-link ps-4"><i class="bi-plus-square"></i> Add New Product</a>
                        <a href="ingridients.php" class="nav-link ps-4"><i class="bi-basket"></i> Add Ingredients</a>
                        <a href="#" class="nav-link ps-4"><i class="bi-book"></i> Reports</a>
                    </div>
                </li>
                <li>
                    <a href="#submenuUtilities" class="nav-link" data-bs-toggle="collapse"><i class="bi-wrench"></i> Utilities</a>
                    <div class="collapse" id="submenuUtilities">
                        <a href="activity_logs.php" class="nav-link ps-4"><i class="bi-list-check"></i> Activity Log</a>
                        <a href="users.php" class="nav-link ps-4"><i class="bi-people"></i> Accounts</a>
                        <a href="archives.php" class="nav-link ps-4"><i class="bi bi-archive"></i> Archives
                       </a>
                    </div>
                </li>
                <li><a href="index.php" class="nav-link"><i class="bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </nav>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
    <h2>Archived Products</h2>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Product Name</th>
                <th>Size</th>
                <th>Category</th>
                <th>Description</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT * FROM inventory_db WHERE is_archived = 1"; // Show only archived products
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $count = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $count . "</td>";
                echo "<td><img src='uploads/" . htmlspecialchars($row['image']) . "' width='50' height='50' onerror=\"this.onerror=null; this.src='images/default-placeholder.png';\"></td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['size']) . "</td>";
                echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                echo "<td>₱" . number_format($row['price'], 2) . "</td>";
                echo "<td>
                        <form method='POST' action='product_status.php' style='display:inline-block;'>
                            <input type='hidden' name='product_id' value='" . $row['id'] . "'>
                            <input type='hidden' name='action' value='restore'>
                            <button type='submit' class='btn btn-success btn-sm'>Restore</button>
                        </form>
                        <a href='delete_product.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this product permanently?\")'>Delete</a>
                      </td>";
                echo "</tr>";
                $count++;
            }            
        } else {
            echo "<tr><td colspan='8' class='text-center'>No archived products.</td></tr>";
        }
        ?>
        </tbody>
    </table>
        </main>
</div>
</div>
</body>
</html>
