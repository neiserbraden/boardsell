<?php
require __DIR__ . "/../../lib/db.php";
require __DIR__ . "/../../lib/auth.php";
require_admin();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_valid_csrf();
    $title = $_POST['title'] ?? '';
$created_by = $_POST['created_by'] ?? '';
$description = $_POST['description'] ?? '';
$price = $_POST['price'] ?? '';
$image = $_POST['image'] ?? '';

    try {
        $stmt = $pdo->prepare("INSERT INTO listing (title, created_by, description, price, image) VALUES (:title, :created_by, :description, :price, :image)");
        $stmt->execute([
        ':title' => $title,
        ':created_by' => $created_by,
        ':description' => $description,
        ':price' => $price,
        ':image' => $image
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
  <title>Create Listings</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php">Admin Dashboard</a>
    <a href="index.php" class="btn btn-outline-light btn-sm">Back to Listings</a>
  </div>
</nav>

<div class="container">
  <h1 class="h3 mb-3">Create Listing</h1>

  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
      <?php foreach ($errors as $err): ?>
        <div><?= htmlspecialchars($err) ?></div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <form method="post">

    <div class="mb-3">
      <label class="form-label">Title</label>
      <input type="text" class="form-control" name="title" value="<?php if(isset($record)) echo htmlspecialchars($record['title']); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Created By</label>
      <input type="text" class="form-control" name="created_by" value="<?php if(isset($record)) echo htmlspecialchars($record['created_by']); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea class="form-control" name="description" required><?php if(isset($record)) echo htmlspecialchars($record['description']); ?></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Price</label>
      <input type="text" class="form-control" name="price" value="<?php if(isset($record)) echo htmlspecialchars($record['price']); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Image</label>
      <input type="text" class="form-control" name="image" value="<?php if(isset($record)) echo htmlspecialchars($record['image']); ?>" required>
    </div>

    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
    <button class="btn btn-primary">Save</button>
  </form>
</div>
</body>
</html>
