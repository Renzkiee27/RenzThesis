<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Dashboard - Sundae Brew Cafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Orders Dashboard</h2>

        <!-- Notification Alert -->
        <div id="alertBox" class="alert alert-success d-none" role="alert"></div>

        <table class="table table-bordered mt-4">
            <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Items</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="ordersTable">
                <!-- Orders will be dynamically inserted here -->
            </tbody>
        </table>
    </div>

    <script>
        let orders = [
            { id: 1, name: "renz", items: "Latte, Croissant", price: "100", status: "Pending" },
            { id: 2, name: "gian", items: "Cappuccino, Muffin", price: "500", status: "Completed" },
            { id: 3, name: "jerome", items: "Espresso, Brownie", price: "300", status: "Preparing" }
        ];

        function renderOrders() {
            const tableBody = document.getElementById("ordersTable");
            tableBody.innerHTML = "";
            orders.forEach(order => {
                tableBody.innerHTML += `
                    <tr>
                        <td>${order.id}</td>
                        <td>${order.name}</td>
                        <td>${order.items}</td>
                        <td>${order.price}</td>
                        <td>
                            <select onchange="updateStatus(${order.id}, this.value)" class="form-select">
                                <option value="Pending" ${order.status === 'Pending' ? 'selected' : ''}>Pending</option>
                                <option value="Preparing" ${order.status === 'Preparing' ? 'selected' : ''}>Preparing</option>
                                <option value="Completed" ${order.status === 'Completed' ? 'selected' : ''}>Completed</option>
                            </select>
                        </td>
                        <td><button class="btn btn-danger" onclick="deleteOrder(${order.id})">Delete</button></td>
                    </tr>`;
            });
        }

        function updateStatus(orderId, newStatus) {
            const order = orders.find(o => o.id === orderId);
            if (order) {
                order.status = newStatus;
            }
        }

        function deleteOrder(orderId) {
            const order = orders.find(o => o.id === orderId);
            orders = orders.filter(o => o.id !== orderId);
            renderOrders();
            showNotification(`Order ${orderId} (${order.name}) has been deleted.`);
        }

        function showNotification(message) {
            const alertBox = document.getElementById("alertBox");
            alertBox.textContent = message;
            alertBox.classList.remove("d-none");
            setTimeout(() => {
                alertBox.classList.add("d-none");
            }, 3000);
        }

        renderOrders();
    </script>
</body>
</html>
