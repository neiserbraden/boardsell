<?php
require __DIR__ . "/../lib/db.php";
require __DIR__ . "/../lib/auth.php";
require_admin();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Admin Dashboard</a>
    <div class="d-flex">
      <span class="navbar-text text-white me-3">
        Logged in as <?= htmlspecialchars($_SESSION['admin_username'] ?? 'admin') ?>
      </span>
      <a href="../admin_logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="container">
  <h1 class="mb-4">Manage Data</h1>
  <div class="row g-3">
    <div class="col-md-3">
      <a href="listings/index.php" class="btn btn-primary w-100">Listings</a>
    </div>
    <div class="col-md-3">
      <a href="users/index.php" class="btn btn-primary w-100">Users</a>
    </div>
    <div class="col-md-3">
      <a href="questions/index.php" class="btn btn-primary w-100">Questions</a>
    </div>
    <div class="col-md-3">
      <a href="admins/index.php" class="btn btn-primary w-100">Admins</a>
    </div>
  </div>
</div>
</body>
</html>
