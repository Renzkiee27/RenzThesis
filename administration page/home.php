<?php
// Include database connection
include 'db_connection.php';

// Fetch total sales
$salesQuery = "SELECT SUM(total_amount) AS total_sales FROM orders";
$salesResult = $conn->query($salesQuery);
$totalSales = ($salesResult && $salesResult->num_rows > 0) ? $salesResult->fetch_assoc()['total_sales'] : 0;

// Fetch total inventory count
$inventoryQuery = "SELECT COUNT(*) AS total_items FROM inventory_db WHERE is_archived = 0";
$inventoryResult = $conn->query($inventoryQuery);
$totalItems = ($inventoryResult && $inventoryResult->num_rows > 0) ? $inventoryResult->fetch_assoc()['total_items'] : 0;

// Fetch recent orders
$ordersQuery = "SELECT * FROM orders ORDER BY order_date DESC LIMIT 5";
$ordersResult = $conn->query($ordersQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Sundae Brew</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .dashboard-card {
            min-height: 150px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include 'sidebar.php'; ?> <!-- Sidebar navigation -->

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <h2>Dashboard</h2>

            <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-primary dashboard-card">
                        <div class="card-body">
                            <h5 class="card-title">Total Sales</h5>
                            <p class="card-text">₱<?php echo number_format($totalSales, 2); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success dashboard-card">
                        <div class="card-body">
                            <h5 class="card-title">Total Products</h5>
                            <p class="card-text"><?php echo $totalItems; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">Recent Orders</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer Name</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($ordersResult && $ordersResult->num_rows > 0) {
                            $count = 1;
                            while ($row = $ordersResult->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $count . "</td>";
                                echo "<td>" . htmlspecialchars($row['customer_name']) . "</td>";
                                echo "<td>₱" . number_format($row['total_amount'], 2) . "</td>";
                                echo "<td>" . $row['order_date'] . "</td>";
                                echo "</tr>";
                                $count++;
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center'>No recent orders.</td></tr>";
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
