<?php
require __DIR__ . "/../../lib/db.php";
require __DIR__ . "/../../lib/auth.php";
require_admin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    die('Invalid ID');
}

$stmt = $pdo->prepare("SELECT * FROM user WHERE user_id = ?");
$stmt->execute([$id]);
$record = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$record) {
    die('Record not found');
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_valid_csrf();
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';
    $address = $_POST['address'] ?? '';
    $city = $_POST['city'] ?? '';
    $zip = $_POST['zip'] ?? '';

    try {
        $stmt = $pdo->prepare("UPDATE user SET username = :username, password = :password, email = :email, address = :address, city = :city, zip = :zip WHERE user_id = :id");
        $stmt->execute([
        ':username' => $username,
        ':password' => $password,
        ':email' => $email,
        ':address' => $address,
        ':city' => $city,
        ':zip' => $zip,
        ':id' => $id
        ]);
        header("Location: index.php");
        exit;
    } catch (Exception $e) {
        $errors[] = $e->getMessage();
    }
}

$csrf = get_csrf_token();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Users</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php">Admin Dashboard</a>
    <a href="index.php" class="btn btn-outline-light btn-sm">Back to Users</a>
  </div>
</nav>

<div class="container">
  <h1 class="h3 mb-3">Edit User</h1>

  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
      <?php foreach ($errors as $err): ?>
        <div><?= htmlspecialchars($err) ?></div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <form method="post">

    <div class="mb-3">
      <label class="form-label">Username</label>
      <input type="text" class="form-control" name="username" value="<?php if(isset($record)) echo htmlspecialchars($record['username']); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="text" class="form-control" name="password" value="<?php if(isset($record)) echo htmlspecialchars($record['password']); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="text" class="form-control" name="email" value="<?php if(isset($record)) echo htmlspecialchars($record['email']); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Address</label>
      <input type="text" class="form-control" name="address" value="<?php if(isset($record)) echo htmlspecialchars($record['address']); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">City</label>
      <input type="text" class="form-control" name="city" value="<?php if(isset($record)) echo htmlspecialchars($record['city']); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Zip</label>
      <input type="text" class="form-control" name="zip" value="<?php if(isset($record)) echo htmlspecialchars($record['zip']); ?>" required>
    </div>

    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
    <button class="btn btn-primary">Save Changes</button>
  </form>
</div>
</body>
</html>
