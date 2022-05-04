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

    <!-- <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/water.css@2/out/water.css'> -->
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
                            <a class='nav-link active' aria-current='page' href='#'>
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
                            <a class='nav-link' href='artist-profile.php'>
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
                <div class='row'>
                    <div class='col-lg-6 col-md-6 pt-3 pb-2 mb-3'>
                        <h1 class='fs-2'>Pieces.</h1>
                        <p class='fs-6 ps-4 space-cadet'>
                            All the pieces that you have posted and the engagement on them.
                        </p>
                    </div>
                    <div class='col-lg-6 col-md-6 mt-6'>
                        <center>
                            <!-- check to see if the logged in user has an entry in artist_details table -->
                            <?php
                            $sql = "SELECT * FROM artist_details
                                    WHERE artist_id = {$_SESSION['user_id']}";

                            $result = $mysqli->query($sql);

                            // if the logged user has an entry, show the add a piece button, else, direct them to the profile page
                            if ($result->num_rows > 0) {
                            ?>
                                <a href='artist-add-piece.php' class='btn btn-lg btn-imperial'>Add a piece</a>

                            <?php } else { ?>

                                <a href='artist-create-art.php' class='btn btn-lg btn-disabled disabled'>Add a piece</a>
                                <a href='artist-profile.php' class='btn btn-lg btn-imperial'>Create your profile first</a>

                            <?php } ?>

                        </center>
                    </div>
                </div>
                <hr class='mobile-hide hr' />


                <!-- Fetch all the art entries by the artist who is logged in -->
                <!-- Render a card for each piece -->
                <?php
                $mysqli = require __DIR__ . '/database.php';

                $fetch_stmt = "SELECT * FROM art WHERE artist_id = {$_SESSION['user_id']}";

                $result = $mysqli->query($fetch_stmt);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $piece_id = $row['id'];
                        $piece_title = $row['title'];
                        $artist_name = $row['artist_name'];
                        $piece_story = $row['story'];
                        $piece_price = $row['price'];
                        $piece_dir = $row['img_path'];
                ?>
                        <div class='row mt-5 justify-content-center'>
                            <div class='col-lg-8 col-md-6'>
                                <div class='card mb-3'>
                                    <div class='row'>
                                        <div class='col-md-4'>
                                            <img src='<?= $piece_dir ?>' class='card-img-top' alt='<? $piece_title ?>'>
                                        </div>
                                        <div class='col-md-8 px-5'>
                                            <div class='card-body'>
                                                <div class='row'>
                                                    <div class='col-lg-5'>
                                                        <p class='fs-5 bold space-cadet cadet-underlined'><?= $piece_title ?></p>
                                                    </div>
                                                    <div class='col-lg-7'>
                                                        <p class='fs-5'><?= $artist_name ?></p>
                                                    </div>
                                                </div>

                                                <p class='card-text'><?= $piece_story ?></p>

                                                <p class='card-text bold'>
                                                    <i class='bi bi-cash-coin manatee' style='font-size:22px;'></i>
                                                    Kshs <?= $piece_price ?>
                                                </p>
                                                <div class='row'>
                                                    <div class='col-6'>
                                                        <a href='art-piece-details.php?id=<?= $piece_id ?>' class='btn btn-imperial'>
                                                            View piece
                                                        </a>
                                                    </div>
                                                    <!-- <span><?= $piece_id ?></span> -->
                                                    <!-- add delete piece button -->
                                                    <div class='col-6'>
                                                        <form action='process-delete-art.php' method='POST'>
                                                            <input type='hidden' name='piece_id' value='<?= $piece_id ?>'>
                                                            <button type='submit' class='btn btn-imperial mb-2'>Delete piece</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                    }
                } else {
                    echo "<center class='fs-5 mt-6'>No pieces found. Try <a href='artist-create-art.php'>uploading one.</a> </center>";
                }
                        ?>

            </main>
            <!-- End of main -->

        </div>
    </div>


</body>

</html>