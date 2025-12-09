<?php
require_once __DIR__ . "/lib/db.php";
require_once __DIR__ . "/lib/auth.php";
require_user();



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["title"];
    $created_by = $_POST["created_by"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $image = $_POST["image"]; 

    $sql = "INSERT INTO listing (title, created_by, description, price, image)
            VALUES (:title, :created_by, :description, :price, :image)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":title" => $title,
        ":created_by" => $created_by,
        ":description" => $description,
        ":price" => $price,
        ":image" => $image
    ]);

    header("Location: listings.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Create Listing</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="home.php">BoardSell</a>

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
      <h3 class="card-title mb-3">Create Listing</h3>

      <form method="post">
        <div class="mb-3">
          <label class="form-label">Title</label>
          <input type="text" class="form-control" name="title" required>
        </div>

        
        <div class="mb-3">
          <label class="form-label">Created By</label>
          <input type="text" class="form-control" name="created_by" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea class="form-control" name="description" rows="3" required></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Price</label>
          <input type="number" class="form-control" name="price" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Image Path</label>
          <input type="text" class="form-control" name="image" required>
        </div>

        <button class="btn btn-success">Create Listing</button>
      </form>
    </div>
  </div>
</div>

</body>
</html>


