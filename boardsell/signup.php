<?php
session_start();
require_once __DIR__ . "/lib/db.php";


$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST['password'];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $zip = $_POST["zip"];

    // Check if username already exists
    $checkSql = "SELECT user_id FROM user WHERE username = :username";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->execute([":username" => $username]);

    if ($checkStmt->fetch()) {
        $error = "Username already exists.";
    } else {
        $sql = "INSERT INTO user (username, password, email, address, city, zip)
                VALUES (:username, :password, :email, :address, :city, :zip)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":username" => $username,
            ":password" => $password, // plain text (class project)
            ":email" => $email,
            ":address" => $address,
            ":city" => $city,
            ":zip" => $zip
        ]);

        $success = "Account created successfully! You can now log in.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Sign Up</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="home.php">BoardSell</a>

    <div class="ms-auto">
      <a href="login.php" class="btn btn-outline-light">
        Back to Login
      </a>
    </div>
  </div>
</nav>

<div class="container">
  <div class="card shadow">
    <div class="card-body">
      <h3 class="card-title mb-3">Create an Account</h3>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>

      <?php if ($success): ?>
        <div class="alert alert-success">
          <?= $success ?> <br>
          <a href="login.php">Click here to log in</a>
        </div>
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

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" name="email" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Address</label>
          <input class="form-control" name="address" required>
        </div>

        <div class="mb-3">
          <label class="form-label">City</label>
          <input class="form-control" name="city" required>
        </div>

        <div class="mb-3">
          <label class="form-label">ZIP Code</label>
          <input class="form-control" name="zip" required>
        </div>

        <button class="btn btn-success">Sign Up</button>
      </form>

      <p class="mt-3">
        Already have an account?
        <a href="login.php">Log in</a>
      </p>
    </div>
  </div>
</div>

</body>
</html>
