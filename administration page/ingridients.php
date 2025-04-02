<?php
session_start();
include 'db_connection.php'; // Ensure this file contains the database connection

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $unit = $_POST['unit'];
    $cost = $_POST['cost'];

    if (!empty($name) && !empty($quantity) && !empty($unit) && !empty($cost)) {
        $sql = "INSERT INTO ingredients (name, quantity, unit, cost) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdss", $name, $quantity, $unit, $cost);
        if ($stmt->execute()) {
            $message = "Ingredient added successfully!";
        } else {
            $error = "Error adding ingredient.";
        }
    } else {
        $error = "All fields are required.";
    }
}

// Fetch ingredients
$result = $conn->query("SELECT * FROM ingredients ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Ingredients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
    <div class="container mt-4">
        <h2 class="text-center">Manage Ingredients</h2>
        <?php if (isset($message)) echo "<div class='alert alert-success'>$message</div>"; ?>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        
        <form action="" method="POST" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="name" class="form-control" placeholder="Ingredient Name" required>
                </div>
                <div class="col-md-2">
                    <input type="number" step="0.01" name="quantity" class="form-control" placeholder="Quantity" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="unit" class="form-control" placeholder="Unit (e.g., kg, ml)" required>
                </div>
                <div class="col-md-2">
                    <input type="number" step="0.01" name="cost" class="form-control" placeholder="Cost" required>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Add Ingredient</button>
                </div>
            </div>
        </form>

        <h4>Ingredient List</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Cost</th>
                    <th>Added On</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['quantity'] ?></td>
                    <td><?= $row['unit'] ?></td>
                    <td><?= $row['cost'] ?></td>
                    <td><?= $row['created_at'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
        </main>
    </div>
</body>
</html>
