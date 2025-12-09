<?php
require __DIR__ . "/../../lib/db.php";
require __DIR__ . "/../../lib/auth.php";
require_admin();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_valid_csrf();
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $question = $_POST['question'] ?? '';

    try {
        $stmt = $pdo->prepare("INSERT INTO questions (username, email, question) VALUES (:username, :email, :question)");
        $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':question' => $question
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
  <title>Create Questions</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php">Admin Dashboard</a>
    <a href="index.php" class="btn btn-outline-light btn-sm">Back to Questions</a>
  </div>
</nav>

<div class="container">
  <h1 class="h3 mb-3">Create Question</h1>

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
      <label class="form-label">Email</label>
      <input type="text" class="form-control" name="email" value="<?php if(isset($record)) echo htmlspecialchars($record['email']); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Question</label>
      <input type="text" class="form-control" name="question" value="<?php if(isset($record)) echo htmlspecialchars($record['question']); ?>" required>
    </div>

    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
    <button class="btn btn-primary">Save</button>
  </form>
</div>
</body>
</html>
