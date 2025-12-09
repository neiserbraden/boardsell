<?php
session_start();
require_once __DIR__ . "/lib/db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM user WHERE username = :username AND password = :password";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":username" => $username,
        ":password" => $password
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["username"] = $user["username"];

        header("Location: home.php");
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="home.php">BoardSell</a>
  </div>
</nav>

<div class="container">
  <div class="card shadow">
    <div class="card-body">
      <h3 class="card-title">Login</h3>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>

      <form method="post">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>

        <button class="btn btn-primary">Login</button>
        <p class="text-center mt-3 mb-0">
                        Don't have an account? <a href="signup.php">Sign up</a>
                    </p>
                    <p class="text-center mt-3 mb-0">
                        Public Login <a href="listings.php">Temporary Login</a>
                    </p>
      </form>
    </div>
  </div>
</div>

</body>
</html>
