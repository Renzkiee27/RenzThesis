<?php
// Include database connection
include 'db_connection.php';

// Perform a SELECT query to get all inventory items
$sql = "SELECT * FROM inventory_db WHERE is_archived = 0"; // Only show active products
$result = $conn->query($sql);
$sql = "SELECT * FROM inventory_db WHERE is_archived = 0"; // Show only non-archived products
$result = $conn->query($sql);


// Check if the query was successful
if (!$result) {
    die("Query failed: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
            background-color: #343a40;
            color: white;
            min-height: 100vh;
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
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>
<div class="container-fluid">
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
    <h2>Inventory</h2>
    <div class="card mb-4">
    <div class="card-header">Add New Product</div>
    <div class="card-body">
        <form action="inventory_db.php" method="POST" enctype="multipart/form-data"> <!-- Corrected form action -->
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Item Name</label>
                    <input type="text" class="form-control" name="name" required>   
                </div>
                <div class="col-md-6">
                    <label class="form-label">Price</label>
                    <input type="number" class="form-control" name="price" required step="0.01">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label class="form-label">Quantity</label>
                    <select class="form-select" name="quantity" required>
                        <option value="" selected>Select Quantity</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Size</label>
                    <select class="form-select" name="size" required>
                        <option value="" selected>Select Size</option>
                        <option value="Small">Small</option>
                        <option value="Medium">Medium</option>
                        <option value="Large">Large</option>
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <select class="form-select" name="category" required>
                        <option value="" selected>Select Category</option>
                        <option value="dessert">dessert</option>
                        <option value="Milktea">milktea</option>
                        <option value="Soda Drinks">Soda-Drinks</option>
                        <option value="Donuts">donuts</option>
                        <option value="Waffle">waffle</option>
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <label class="form-label">Item Description</label>
                    <textarea class="form-control" name="description" required></textarea>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <label class="form-label">Image</label>
                    <input type="file" class="form-control" name="image" required>
                </div>
            </div>
            <button type="submit" name="add_item" class="btn btn-primary mt-3">Add Product</button>
        </form>
    </div>
</div>

</main>


            <div class="card">
                <div class="card-header">Product Items</div>
                <div class="card-body">
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
    $sql = "SELECT * FROM inventory_db WHERE is_archived = 0"; // Show only active products
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
                        <input type='hidden' name='action' value='archive'>
                        <button type='submit' class='btn btn-warning btn-sm'>Archive</button>
                    </form>
                  </td>";
            echo "</tr>";
            $count++;
        }
    } else {
        echo "<tr><td colspan='8' class='text-center'>No products found.</td></tr>";
    }
    ?>
    </tbody>
</table>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>
<?php $conn->close(); ?>