<?php

session_start();

if (isset($_SESSION['user_id'])) {
    // create a database connection 
    $mysqli = require __DIR__ . '/database.php';

    // get the user's email address
    $sql = "SELECT * FROM users
            WHERE id = {$_SESSION['user_id']}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
} else {
    header('Location: home.php');
}

?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Pieces | <?= $user['name'] ?>
    </title>

    <!-- Styling imports -->
    <link rel='stylesheet' href='styles/main.css'>
    <link rel='stylesheet' href='styles/utility.css'>

    <!-- Bootstrap Icons imports -->
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css'>

    <!-- Validation -->
    <script src='https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js' defer></script>
    <script src='js/gallery-validation.js' defer></script>
</head>

<body>
    <?php include __DIR__ . '/dashboard-navbar.php'; ?>

    <div class='container-flex' style='padding-left:7%; padding-right:8%;'>
        <div class='row'>
            <!-- Start of aside navbar -->
            <nav class='col-md-3 col-lg-2 d-md-block'>
                <div class='position-sticky pt-3 background-cultured'>
                    <ul class='nav flex-column'>
                        <li class='nav-item'>
                            <a class='nav-link' href='artist-dashboard.php'>
                                <i class='bi bi-bar-chart' style='font-size: 22px;'></i>
                                Dashboard
                            </a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link' href='artist-orders.php'>
                                <i class='bi bi-card-checklist' style='font-size: 22px;'></i>
                                Orders
                            </a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link' href='artist-pieces.php'>
                                <i class='bi bi-box-seam' style='font-size: 22px;'></i>
                                Pieces
                            </a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link active' aria-current='page' href='artist-galleries.php'>
                                <i class='bi bi-building' style='font-size: 22px;'></i>
                                Galleries
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End of aside navbar -->

            <!-- Start of main -->
            <main class='col-md-9 col-lg-10'>
                <div class='row'>
                    <div class='col-lg-6 col-md-6 pt-3 pb-2 mb-3'>
                        <h1 class='fs-2'>Create Gallery</h1>
                        <p class='fs-6 ps-4 space-cadet'>
                            Follow through the form to create a gallery.
                        </p>
                    </div>
                </div>

                <div class='container-fluid'>
                    <form action='process-create-gallery.php' method='post' id='create_gallery' enctype='multipart/form-data' novalidate>
                        <div class='col-lg-12 mb-4'>
                            <label for='title'>Title</label>
                            <input class='form-control mb-2' type='text' name='title' id='title' placeholder='Mental Health Week'>
                        </div>

                        <div class='col-lg-12 mb-4'>
                            <label for='title'>Location</label>
                            <input class='form-control mb-2' type='text' name='location' id='location' placeholder='Alliance Francais'>
                        </div>

                        <div class='col-lg-12 mb-4'>
                            <label for='img'>Select image</label>
                            <input class='form-control mb-2 mt-2' type='file' id='img' name='img'>
                        </div>

                        <div class='col-lg-12 mb-4'>
                            <label for='piece-story'>Story</label>
                            <!-- Fix the text in the textarea -->
                            <textarea class='form-control mb-2 mt-2' type='file' id='story' name='story' placeholder='Story behind the piece'></textarea>
                        </div>

                        <div class='col-lg-12 mb-6'>
                            <label for='price'>Entrance fee (in Ksh)</label>
                            <input class='form-control mb-2 mt-2' type='number' min='0' step='500' id='price' name='price'>
                            <!-- Add validation for positive values only -->
                        </div>

                        <button class='btn btn-lg btn-imperial' type='submit' name='create-gallery' value='Create Account'>
                            Create Gallery
                        </button>
                    </form>
                </div>

            </main>
            <!-- End of main -->

        </div>
    </div>


</body>

</html>