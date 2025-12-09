<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>

    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous"
  />

    <style>
        body {
            background-color: #f8f9fa;
        }

        .hero {
            background: #0d6efd;
            color: white;
            padding: 3rem 0;
            text-align: center;
        }

        .overview {
            margin: 2rem 0;
        }

        .quick-links a {
            text-decoration: none;
        }

        .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
        }
    </style>
</head>

<body>
    <header class="hero">
        <div class="container">
            <a href="logout.php" class="btn btn-outline-light position-absolute top-0 end-0 m-3">Log Out</a>
            <h1 class="display-5 fw-bold">Welcome to the BoardSell Website </h1>
        </div>
    </header>


    <main class="container my-5">
        <section class="overview text-center mb-5">
            <h2 class="fw-bold mb-3">Our Mission</h2>
            <p class="text-muted"> We seek to cultivate a site where board game hobbyists can sell and buy board games. </p>
        </section>


        <section class="quick-links">
            <div class="row g-4 text-center">
                <div class="col-md-3 col-sm-6">
                    <a href="create_listing.php">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-primary">Make a Listing</h5>
                                <p class="card-text text-muted">Sell your board games.</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 col-sm-6">
                    <a href="listings.php">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-primary">Browse Board Games</h5>
                                <p class="card-text text-muted">View all available listings of board games.</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 col-sm-6">
                    <a href="edit_user.php">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-primary">Update Information</h5>
                                <p class="card-text text-muted">Edit your account information.</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 col-sm-6">
                    <a href="ask_question.php">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-primary">Questions</h5>
                                <p class="card-text text-muted">Ask a question or contact support.</p>
                            </div>
                        </div>
                    </a>
                </div>
                                
            </div>
        </section>
    </main>

    <footer class="text-center text-muted py-4 border-top">
        <small> <?php echo date('Y'); ?> My Project. </small>
    </footer>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous">
  </script>
</body>
</html>