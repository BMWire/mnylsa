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
    <title>Profile | <?= $user['name'] ?>
    </title>

    <!-- Styling imports -->
    <link rel='stylesheet' href='styles/main.css'>
    <link rel='stylesheet' href='styles/utility.css'>

    <!-- Bootstrap Icons imports -->
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css'>

    <!-- Validation -->
    <script src='https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js' defer></script>
    <script src='js/profile-validation.js' defer></script>

</head>

<body>
    <?php include __DIR__ . '/dashboard-navbar.php'; ?>

    <!-- Start of main -->
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
                            <a class='nav-link' href='artist-galleries.php'>
                                <i class='bi bi-building' style='font-size: 22px;'></i>
                                Galleries
                            </a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link active' aria-current='page' href='#'>
                                <i class='bi bi-emoji-smile' style='font-size: 22px;'></i>
                                Profile
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End of aside navbar -->

            <!-- Start of main -->
            <main class='col-md-9 col-lg-10'>

                <?php if (isset($user)) : ?>
                    My name is <?= $user['name'] ?>.
                    My artist id is <?= $user['id'] ?>.
                <?php else : ?>
                    <p class='nav-link'>
                        <a href='signin.php'>Sign In</a>
                        or
                        <a href='signup.html'>Sign Up</a>
                    </p>
                <?php endif; ?>


                <div class='d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom'>
                    <h1 class='fs-2'>Profile</h1>
                    <p class='fs-6 ps-4 space-cadet'>
                        Tell people who you are and what you do.
                    </p>
                </div>

                <hr class='mobile-hide hr' />

                <div class='container-fluid pt-4'>
                    <form action='process-create-profile.php' method='post' id='create_profile' enctype='multipart/form-data' novalidate>

                        <h3>Profile Picture</h3>
                        <hr class='mobile-hide hr-max' />

                        <div class='col-lg-12 mt-5 mb-6'>
                            <label for=' img'>Select image</label>
                            <p class='fs-6'>A profile picture that people can identify you and your art with is very important</s>
                                <input class='form-control mb-2 mt-2' type='file' id='img' name='img'>
                        </div>
                        <div class='col-lg-12 mb-4'>
                            <label for='piece-story'>Story</label>
                            <!-- Fix the text in the textarea -->
                            <textarea class='form-control mb-2 mt-2' id='story' name='story' placeholder='Why did <?= $user['name'] ?> get into art?'></textarea>
                        </div>


                        <h3 class='pt-5'>Location</h3>
                        <hr class='mobile-hide hr-max' />

                        <div class='row mb-6'>
                            <div class='col-lg-5 col-md-5'>
                                <label for='building'>Building</label>
                                <input class='form-control mb-2' type='text' name='building' id='building' placeholder='Alliance Francaise BLDG'>
                            </div>
                            <div class='col-lg-5 col-md-5'>
                                <label for='street'>Street</label>
                                <input class='form-control mb-2' type='text' name='street' id='street' placeholder='Loita Street'>
                            </div>
                            <div class='col-lg-5 col-md-5'>
                                <label for='town'>Town</label>
                                <input class='form-control mb-2' type='text' name='town' id='town' placeholder='Nairobi'>
                            </div>
                            <div class='col-lg-5 col-md-5'>
                                <label for='county'>County</label>
                                <input class='form-control mb-2' type='text' name='county' id='county' placeholder='Nairobi'>
                            </div>

                        </div>
                        <!-- submit button -->
                        <div class='col-lg-12 mb-4'>
                            <button class='btn btn-lg btn-imperial'>Create Profile</button>
                        </div>

                    </form>
                </div>

            </main>
            <!-- End of main -->

        </div>
    </div>


</body>

</html>