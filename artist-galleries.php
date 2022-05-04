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
<?php

?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Galleries | <?= $user['name'] ?>
    </title>

    <!-- Styling imports -->
    <link rel='stylesheet' href='styles/main.css'>
    <link rel='stylesheet' href='styles/utility.css'>

    <!-- Bootstrap Icons imports -->
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css'>

    <!-- <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/water.css@2/out/water.css'> -->
</head>

<body class='background-cultured'>
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
                        <h1 class='fs-2'>Galleries.</h1>
                        <p class='fs-6 ps-4 space-cadet'>
                            All the galleries that you have hosted and how people engaged with them.
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
                                <a href='artist-create-gallery.php' class='btn btn-lg btn-imperial'>Create a gallery</a>

                            <?php } else { ?>

                                <a href='artist-create-gallery.php' class='btn btn-lg btn-disabled disabled'>Create a gallery</a>
                                <a href='artist-profile.php' class='btn btn-lg btn-imperial'>Create your profile first</a>

                            <?php } ?>

                        </center>
                    </div>
                </div>
                <hr class='mobile-hide hr' />

                <!-- Fetch all the gallery record entries by the artist who is logged in -->
                <!-- Render a card for each gallery -->
                <?php
                $mysqli = require __DIR__ . '/database.php';

                $fetch_stmt = "SELECT * FROM galleries WHERE artist_id = {$_SESSION['user_id']}";

                $result = $mysqli->query($fetch_stmt);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $gallery_id = $row['id'];
                        $gallery_name = $row['title'];
                        $gallery_location = $row['location'];
                        $gallery_story = $row['story'];
                        $gallery_fee = $row['fee'];
                        $gallery_date = $row['date'];
                        $gallery_imgDir = $row['coverImg'];
                ?>
                        <div class='row mt-5 justify-content-center'>
                            <div class='col-lg-8 col-md-6'>
                                <div class='card mb-3'>
                                    <div class='row'>
                                        <div class='col-md-4'>
                                            <img src='<?= $gallery_imgDir ?>' class='card-img-top' alt='<? $gallery_name ?>'>
                                        </div>
                                        <div class='col-md-8 px-5'>
                                            <div class='card-body'>
                                                <h3 class='space-cadet cadet-underlined'><?= $gallery_name ?></h3>
                                                <p class='card-text'>
                                                    <i class='bi bi-geo-fill manatee' style='font-size:22px;'></i>
                                                    <?= $gallery_location ?>
                                                </p>
                                                <p class='card-text'>
                                                    <i class='bi bi-lightbulb-fill manatee' style='font-size:22px;'></i>
                                                    <?= $gallery_story ?>
                                                </p>
                                                <p class='card-text'>
                                                    <i class='bi bi-cash-coin manatee' style='font-size:22px;'></i>
                                                    Kshs <?= $gallery_fee ?>
                                                </p>
                                                <p class='card-text'>
                                                    <i class='bi bi-calendar-date manatee' style='font-size:22px;'></i>
                                                    <?= substr($gallery_date, 0, strpos($gallery_date, ' ')) ?>
                                                </p>
                                                <div class='row'>
                                                    <div class='col-6'>
                                                        <a href='artist-edit-gallery.php?id=<?= $gallery_id ?>' class='btn btn-imperial'>
                                                            View gallery
                                                        </a>
                                                    </div>
                                                    <div class='col-6'>
                                                        <form action='process-delete-gallery.php' method='POST'>
                                                            <input type='hidden' name='gallery_id' value='<?= $gallery_id ?>'>
                                                            <button type='submit' class='btn btn-imperial mb-2'>Cancel gallery</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<center class='fs-5 mt-6'>No galleries found. Try <a href='artist-create-galleries.php'>creating one.</a> </center>";
                }
                ?>

            </main>
            <!-- End of main -->

        </div>
    </div>


</body>

</html>