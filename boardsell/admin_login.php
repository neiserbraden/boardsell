<?php
require __DIR__ . "/lib/db.php";
require __DIR__ . "/lib/auth.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? "";
    $password = $_POST['password'] ?? "";

    $stmt = $pdo->prepare(
        "SELECT * FROM admin WHERE username = ? AND password = ?"
    );
    $stmt->execute([$username, $password]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['admin_username'] = $admin['username'];
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        header("Location: admin/index.php");
        exit;
    } else {
        $error = "Invalid admin username or password";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
          <h4 class="mb-0 text-center">Admin Login</h4>
        </div>
        <div class="card-body">
          <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
          <?php endif; ?>
          <form method="post">
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input class="form-control" name="username" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" class="form-control" name="password" required>
            </div>
            <button class="btn btn-primary w-100">Login</button>
          </form>
        </div>
        <div class="card-footer text-center">
          <a href="home.php" class="small">Back to site</a>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
