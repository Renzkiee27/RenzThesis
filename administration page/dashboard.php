<?php
include 'db_connection.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Inventory Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            padding: 10px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .main-content {
            margin-left: 260px;
            padding: 20px;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="text-center">Sundae Brew Cafe</h4>
    <a href="dashboard.php"><i class="bi-speedometer2"></i> Dashboard</a>
    <a href="inventory.php"><i class="bi-box"></i> Inventory</a>
    <a href="orders.php"><i class="bi-cart"></i> Orders</a>
    <a href="logout.php"><i class="bi-box-arrow-right"></i> Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">
    <h2>Dashboard</h2>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">Add New Product</div>
                <div class="card-body">
                    <form action="inventory_db.php" method="POST" enctype="multipart/form-data">
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
                                    <option value="dessert">Dessert</option>
                                    <option value="Milktea">Milktea</option>
                                    <option value="Soda Drinks">Soda Drinks</option>
                                    <option value="Donuts">Donuts</option>
                                    <option value="Waffle">Waffle</option>
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
        </div>
    </div>
</div>

<?php $conn->close(); ?>
</body>
</html>
