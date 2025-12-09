<?php
require __DIR__ . "/../../lib/db.php";
require __DIR__ . "/../../lib/auth.php";
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    require_valid_csrf();
    $id = (int)$_POST['delete_id'];

    if ($id === (int)($_SESSION['admin_id'] ?? 0)) {
        die('You cannot delete your own admin account.');
    }

    $stmt = $pdo->prepare("DELETE FROM admin WHERE admin_id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM admin ORDER BY admin_id DESC");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$csrf = get_csrf_token();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin - Admins</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php">Admin Dashboard</a>
    <div class="d-flex">
      <a href="../listings/index.php" class="btn btn-outline-light btn-sm me-2">Listings</a>
      <a href="../users/index.php" class="btn btn-outline-light btn-sm me-2">Users</a>
      <a href="../questions/index.php" class="btn btn-outline-light btn-sm me-2">Questions</a>
      <a href="../admins/index.php" class="btn btn-outline-light btn-sm me-2">Admins</a>
      <a href="../../admin_logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="container">
  <div class="d-flex justify-content-between mb-3">
    <h1 class="h3">Manage Admins</h1>
    <a href="create.php" class="btn btn-primary">Create New</a>
  </div>

  <table class="table table-bordered table-striped">
    <thead class="table-light">
      <tr>
        <?php foreach (array_keys($rows[0] ?? []) as $col): ?>
          <th><?= htmlspecialchars($col) ?></th>
        <?php endforeach; ?>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $row): ?>
        <tr>
          <?php foreach ($row as $value): ?>
            <td><?= htmlspecialchars((string)$value) ?></td>
          <?php endforeach; ?>
          <td style="white-space: nowrap;">
            <a href="edit.php?id=<?= (int)$row['admin_id'] ?>" class="btn btn-sm btn-secondary">Edit</a>
            <form method="post" class="d-inline">
              <input type="hidden" name="delete_id" value="<?= (int)$row['admin_id'] ?>">
              <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
              <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this admin?')">Delete</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

</body>
</html>


