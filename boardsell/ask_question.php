<?php
require_once __DIR__ . "/lib/db.php";
require_once __DIR__ . "/lib/auth.php";
require_user();



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $question = $_POST["question"];

    $sql = "INSERT INTO questions (username, email, question)
            VALUES (:username, :email, :question)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":username" => $username,
        ":email" => $email,
        ":question" => $question
    ]);

    $success = "Question submitted successfully!";
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Ask a Question</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="/home.php">BoardSell</a>

    <div class="ms-auto">
      <a href="home.php" class="btn btn-outline-light">
       Home
      </a>
    </div>
  </div>
</nav>


<div class="container">
  <div class="card shadow">
    <div class="card-body">
      <h3 class="card-title mb-3">Ask a Question</h3>

      <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
      <?php endif; ?>

      <form method="post">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" class="form-control" name="username" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" name="email" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Question</label>
          <textarea class="form-control" name="question" rows="4" required></textarea>
        </div>

        <button class="btn btn-primary">Submit Question</button>
      </form>
    </div>
  </div>
</div>

</body>
</html>

