<?php

require_once "config.php";

if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $stmt = $pdo->prepare(
        "SELECT * FROM admins WHERE username = ?"
    );

    $stmt->execute([$username]);

    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && hash('sha256', $password) === $admin['password']) {

        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['username'] = $admin['username'];

        header("Location: dashboard.php");
        exit;

    } else {

        $error = "Invalid username or password.";

    }
}

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1">

<title>Login | eSports Manager</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link rel="stylesheet"
href="assets/css/style.css">

</head>

<body>

<div class="login-page">

<div class="login-box">

<div class="logo-icon mb-3">
🎮
</div>

<h2 class="text-center fw-bold">
eSports Manager
</h2>

<p class="text-center text-secondary mb-4">
Admin Login
</p>

<?php if ($error): ?>

<div class="alert alert-danger">
<?= htmlspecialchars($error) ?>
</div>

<?php endif; ?>

<form method="POST">

<div class="mb-3">

<label class="form-label">
Username
</label>

<input
type="text"
name="username"
class="form-control"
placeholder="Enter username"
required>

</div>

<div class="mb-4">

<label class="form-label">
Password
</label>

<input
type="password"
name="password"
class="form-control"
placeholder="Enter password"
required>

</div>

<button
class="btn btn-primary w-100 py-2">

<i class="bi bi-box-arrow-in-right"></i>
Login

</button>

</form>

<div class="text-center mt-4 text-secondary">

Small Project Admin Panel

</div>

</div>

</div>

</body>
</html>