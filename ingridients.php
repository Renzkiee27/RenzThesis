<?php
// Include database connection
include 'db_connection.php';

// Perform a SELECT query to get all inventory items
$sql = "SELECT * FROM ingredients"; // Ensure the table name is correct
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Change color of anchor tags in the sidebar */
        #menu .nav-link {
            color: #f0f0f0; /* Change this to your preferred color */
        }

        #menu .nav-link:hover {
            color: yellow; /* Change this to your preferred hover color */
        }
        #top img{
            margin-left: 1.8rem;
        }
    </style>
    <title>Document</title>
</head>
<body>
<div class="container-fluid">
    
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-secondary">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <a href="ingridients.php" id="top" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <img src="images/SUNDE LGO.png" alt="" width="100px">
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item">
                        <a href="#" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span> </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Orders</span></a>
                    </li>
                    <li>
                        <a href="#submenu3" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">Inventory</span> </a>
                            <div class="row">
                            <a href="inventory.php" class="nav-link px-4 align-middle">
                            <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">Add New Product</span> </a>
                            <a href="ingridients.php" class="nav-link px-4 align-middle">
                            <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">Add New Ingridient</span> </a>
                            </div>
                    </li>
                    <li>
                        <a href="#submenu3"  class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">Utilities</span> </a>
                            <div class="row">
                            <a href="activity_logs.php" class="nav-link px-4 align-middle">
                            Activity Log</a>
                            <a href="users.php" class="nav-link px-4 align-middle">
                           Accounts </a>
                            </div>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Customers</span> </a>
                    </li>
                    <li>
                        <a href="index.php" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Logout</span> </a>
                    </li>
                </ul>
                <hr>
            </div>
        </div>
    <div class="col py-3">

 <!-- Add Item Form -->
 <div class="card mb-4">
    <h2>Inventory</h2>
                    <div class="card-header">Add New Ingredients</div>
                    <div class="card-body">
                        <form action="add_ingridients.php" method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Item Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Item Description</label>
                                <textarea class="form-control" id="description" name="description" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Item Price</label>
                                <input type="number" class="form-control" id="price" name="price" required step="0.01">
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Item Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required>
                            </div>
                                                        <div class="mb-3">
                                <label for="expiration_date" class="form-label">Expiration Date</label>
                                <input type="date" class="form-control" id="expiration_date" name="expiration_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="unit_measurement" class="form-label">Unit of Measurement</label>
                                <select name="unit_measurement" id="unit_measurement" class="form-control">
                                    <option value="piece">Piece(pc)</option>
                                    <option value="pack">Pack(Pack)</option>
                                    <option value="box">Box(bx)</option>
                                    <option value="set">Set(set)</option>
                                </select>
                            </div>
                            <button type="submit" name="add_item" class="btn btn-primary">Add Ingredients</button>
                        </form>
                    </div>
                </div>
                                    <!-- Ingredients Table -->
                <div class="card">
                    <div class="card-header">Ingredients Items</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Ingredient Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Unit of Measurement</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result->num_rows > 0): ?>
                                    <?php while($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['description']; ?></td>
                                        <td>&#8369; <?php echo number_format($row['price'], 2); ?></td>
                                        <td><?php echo $row['quantity']; ?></td>
                                        <td><?php echo $row['unit_measurement']; ?></td>
                                        
                                        <td>
                                        <form action="delete_ingridients.php" method="post">
                                            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" name="delete_product" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>

                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No items found in inventory.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

    </div>
                
</body>
</html>