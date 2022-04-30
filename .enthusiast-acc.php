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
    <title>Account Settings | <?= $user['name'] ?>
    </title>

    <!-- Styling imports -->
    <link rel='stylesheet' href='styles/main.css'>
    <link rel='stylesheet' href='styles/utility.css'>

    <!-- Bootstrap Icons imports -->
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css'>

</head>

<body>
    <?php include __DIR__ . '/enthusiast-navbar.php'; ?>

    <!-- Start of main -->
    <div class='container-flex' style='padding-left:7%; padding-right:8%;'>
        <div class='row'>

            <!-- Start of aside navbar -->
            <nav class='col-md-3 col-lg-2 d-md-block'>
                <div class='position-sticky pt-3 background-cultured'>
                    <ul class='nav flex-column'>
                        <li class='nav-item'>
                            <a class='nav-link' href='enthusiast-art-orders.php'>
                                <i class='bi bi-postage-heart-fill' style='font-size: 22px;'></i>&nbsp;
                                Art Orders
                            </a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link' href='enthusiast-gallery-orders.php'>
                                <i class='bi bi-ticket-perforated-fill rotate' style='font-size: 22px;'></i>&nbsp;
                                Gallery Tickets
                            </a>
                        </li>
                        <!-- <li class='nav-item'>
                            <a class='nav-link active' aria-current='page' href='#'>
                                <i class='bi bi-brush-fill' style='font-size: 22px;'></i>&nbsp;
                                Account settings
                            </a>
                        </li> -->
                    </ul>
                </div>
            </nav>
            <!-- End of aside navbar -->

            <!-- Start of main -->
            <main class='col-md-9 col-lg-10'>

                <?php if (isset($user)) : ?>
                    My name is <?= $user['name'] ?>.
                    My user id is <?= $user['id'] ?>.
                <?php else : ?>
                    <p class='nav-link'>
                        <a href='signin.php'>Sign In</a>
                        or
                        <a href='signup.html'>Sign Up</a>
                    </p>
                <?php endif; ?>


                <div class='d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom'>
                    <h1 class='fs-2'>Account Settings</h1>
                    <p class='fs-6 ps-4 space-cadet'>
                        Update some of the settings in your account.
                    </p>
                </div>

                <hr class='mobile-hide hr' />

                <!-- create account update form -->
                    <div class='col-6'>
                        <form action='process-signup.php' method='post' id='signup' novalidate>
                            <div class='col-lg-12 mb-4' style='width:94%;'>
                                <label for='name'>Name</label>
                                <input class='form-control mb-2' type='text' id='name' name='name' placeholder='Pablo Picasso'>
                            </div>

                            <div class='col-lg-12 mb-4' style='width:94%;'>
                                <label for='email'>Email</label>
                                <input class='form-control mb-2' type='email' id='email' name='email' placeholder='picasso@venice.com'>
                            </div>

                            <div class='row mb-4'>
                                <div class='col-lg-5 col-sm-12 col-md-6'>
                                    <label for='password'>Password</label>
                                    <input class='form-control mb-2' type='password' id='password' name='password' placeholder='SuperPablo1894.'>
                                </div>

                                <div class='col-lg-5 col-sm-12 col-md-6'>
                                    <label for='password_confirmation'>Confirm password</label>
                                    <input class='form-control mb-2' type='password' id='password_confirmation' name='password_confirmation' placeholder='SuperPablo1894.'>
                                </div>
                            </div>

                            <div class='row mb-4'>
                                <span>
                                    I want to:
                                </span>
                                <div class='col-lg-5 col-sm-12 col-md-6 mb-4'>
                                    <input class='mt-3' type='radio' id='isArtist' name='isArtist' value='no' autocomplete='off' checked>
                                    <label for='isArtist'>Buy art</label>
                                </div>

                                <div class='col-lg-5 col-sm-12 col-md-6 mb-4'>
                                    <input class='mt-3' type='radio' id='isArtist' name='isArtist' value='yes' autocomplete='off'>
                                    <label for='isArtist'>Create art</label>
                                </div>
                            </div>


                            <p>
                                Already have an account? <a class='inline-link' href='signin.php'>Sign In</a>
                            </p>

                            <button class='btn btn-lg btn-imperial'>Sign up</button>
                        </form>
                    </div>

            </main>
            <!-- End of main -->

        </div>
    </div>


</body>

</html>