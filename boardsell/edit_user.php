<?php
require_once __DIR__ . "/lib/db.php";
require_once __DIR__ . "/lib/auth.php";
require_user();



if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$success = "";
$error = "";

$sql = "SELECT username, email, address, city, zip
        FROM user
        WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([":user_id" => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $new_username = trim($_POST["username"]);
    $email = $_POST["email"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $zip = $_POST["zip"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    if ($new_username !== $user["username"]) {
        $check = $pdo->prepare(
            "SELECT user_id FROM user WHERE username = :username"
        );
        $check->execute([":username" => $new_username]);

        if ($check->fetch()) {
            $error = "Username is already taken.";
        }
    }

    if (!$error && $new_password !== "") {
        if ($new_password !== $confirm_password) {
            $error = "Passwords do not match.";
        }
    }

    if (!$error) {
        if ($new_password !== "") {
            $updateSql = "
                UPDATE user SET
                    username = :username,
                    password = :password,
                    email = :email,
                    address = :address,
                    city = :city,
                    zip = :zip
                WHERE user_id = :user_id
            ";

            $params = [
                ":username" => $new_username,
                ":password" => $new_password,
                ":email" => $email,
                ":address" => $address,
                ":city" => $city,
                ":zip" => $zip,
                ":user_id" => $user_id
            ];
        } else {
            $updateSql = "
                UPDATE user SET
                    username = :username,
                    email = :email,
                    address = :address,
                    city = :city,
                    zip = :zip
                WHERE user_id = :user_id
            ";

            $params = [
                ":username" => $new_username,
                ":email" => $email,
                ":address" => $address,
                ":city" => $city,
                ":zip" => $zip,
                ":user_id" => $user_id
            ];
        }

        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->execute($params);

        $_SESSION["username"] = $new_username;

        $stmt->execute([":user_id" => $user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $success = "Profile updated successfully.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="home.php">BoardSell</a>
    <div class="ms-auto">
      <a href="home.php" class="btn btn-outline-light me-2">Home</a>
    </div>
  </div>
</nav>

<div class="container">
  <div class="card shadow">
    <div class="card-body">
      <h3 class="card-title mb-3">Edit Profile</h3>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>

      <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
      <?php endif; ?>

      <form method="post">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input class="form-control"
                 name="username"
                 value="<?= htmlspecialchars($user["username"]) ?>"
                 required>
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input class="form-control"
                 name="email"
                 value="<?= htmlspecialchars($user["email"]) ?>"
                 required>
        </div>

        <div class="mb-3">
          <label class="form-label">Address</label>
          <input class="form-control"
                 name="address"
                 value="<?= htmlspecialchars($user["address"]) ?>"
                 required>
        </div>

        <div class="mb-3">
          <label class="form-label">City</label>
          <input class="form-control"
                 name="city"
                 value="<?= htmlspecialchars($user["city"]) ?>"
                 required>
        </div>

        <div class="mb-3">
          <label class="form-label">ZIP</label>
          <input class="form-control"
                 name="zip"
                 value="<?= htmlspecialchars($user["zip"]) ?>"
                 required>
        </div>

        <hr>

        <h5>Change Password</h5>

        <div class="mb-3">
          <label class="form-label">New Password</label>
          <input type="password" class="form-control" name="new_password">
        </div>

        <div class="mb-3">
          <label class="form-label">Confirm Password</label>
          <input type="password" class="form-control" name="confirm_password">
        </div>

        <button class="btn btn-primary">Save Changes</button>
      </form>
    </div>
  </div>
</div>

</body>
</html>

