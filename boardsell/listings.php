<?php
require_once __DIR__ . "/lib/db.php";


$stmt = $pdo->query("SELECT * FROM listing ORDER BY created_at DESC");
$listings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Listings</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="/home.php">BoardSell</a>
  </div>
</nav>

<div class="container">
  <h2 class="mb-4">Available Listings</h2>

  <div class="row">
    <?php foreach ($listings as $listing): ?>
      <div class="col-md-4">
        <div class="card mb-4 shadow-sm">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($listing["title"]) ?></h5>
            <p class="card-text"><?= htmlspecialchars($listing["description"]) ?></p>
            <p><strong>$<?= htmlspecialchars($listing["price"]) ?></strong></p>
            <small class="text-muted">
              Seller: <?= htmlspecialchars($listing["created_by"]) ?>
            </small>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

</body>
</html>

