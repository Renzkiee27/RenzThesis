<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Administration</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-lg" style="width: 350px;">
            <form action="login.php" method="POST">
            <h3 class="text-center mb-3">Login</h3>

<!-- Username Input -->
<div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control" name="username" id="username" placeholder="Enter your username">
</div>

<!-- Password Input -->
<div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password">
</div>

<!-- Login Button -->
<button class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
</body>

</html>