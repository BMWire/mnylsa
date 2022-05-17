<?php

session_start();

if (isset($_SESSION["user_id"])) {
    // create a database connection 
    $mysqli = require __DIR__ . "/database.php";

    // get the user's email address
    $sql = "SELECT * FROM users
            WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if ($user["isArtist"] == "yes") {
        $_SESSION["isArtist"] = true;
        $_SESSION["user_id"] = $user["id"];


        header("Location: artist-dashboard.php");
    }
}

?>

<?php
// fetch the details of the user whose id is in the URL from users table
$sql = "SELECT * FROM users
        WHERE id = {$_GET["id"]}";

$result = $mysqli->query($sql);

$artist = $result->fetch_assoc();

// fetch the artist details of the artist whose id is in the URL from artist_details table
$sql = "SELECT * FROM artist_details
        WHERE artist_id = {$_GET["id"]}";

$detail_result = $mysqli->query($sql);

$artist_details = $detail_result->fetch_assoc();

// fetch the number of art entries of the artist whose id is in the URL from art table
$sql = "SELECT COUNT(*) AS art_count FROM art
        WHERE artist_id = {$_GET["id"]}";

$art_count_result = $mysqli->query($sql);

$art_count = $art_count_result->fetch_assoc();


// fetch the number of gallery entries of the artist whose id is in the URL from art table
$sql = "SELECT COUNT(*) AS gallery_count FROM galleries
        WHERE artist_id = {$_GET["id"]}";

$gallery_count_result = $mysqli->query($sql);

$gallery_count = $gallery_count_result->fetch_assoc();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title><?= $artist['name'] ?>'s Portfolio</title>

    <!-- Styling imports -->
    <link rel='stylesheet' href='styles/main.css'>
    <link rel='stylesheet' href='styles/utility.css'>

    <!-- Bootstrap Icons imports -->
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css'>

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css"> -->
</head>

<body>
    <?php include __DIR__ . "/navbar.php"; ?>

    <!-- Start of main -->
    <main>
        <div class='container-cart'>
            <div class='row'>
                <div class='col-md-12 col-lg-12'>

                    <div class='d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom'>
                        <!-- display the artist's profile image in a row with the artist name -->
                        <div class='row'>
                            <div class='col-md-3 col-lg-3 p-3'>
                                <img src='<?= $artist_details['profile_image'] ?>' alt='<?= $artist['name'] ?>' class='card-img-top'>
                            </div>
                            <div class='col-md-9 col-lg-9'>
                                <div class='row px-2'>
                                    <div class='col-md-5 col-lg-5'>
                                        <h1 class='fs-1 p-2'>
                                            <?= $artist['name'] ?>
                                        </h1>
                                        <div class='row justify-content-between'>
                                            <span class='col-5 badge badge-imperial'>
                                                <?= $art_count['art_count'] ?> <?= $art_count['art_count'] == 1 ? " Art Piece" : "Art Pieces" ?>
                                            </span>

                                            <span class='col-5 badge badge-imperial'>
                                                <?= $gallery_count['gallery_count'] ?> <?= $gallery_count['gallery_count'] == 1 ? "Gallery" : "Galleries" ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class='col-md-7 col-lg-7 px-3'>
                                        <p class='fs-6'>
                                            <?= $artist_details['story'] ?>
                                            <?= $artist_details['story'] ?>
                                        </p>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                    <hr class='mobile-hide hr' />

                </div>

            </div>
        </div>

        <div class='container-flex' style='padding-left:7%; padding-right:8%;'>
            <div class='row'>
                <!-- Start of aside navbar -->
                <nav class='col-md-3 col-lg-2 d-md-block'>
                    <div class='position-sticky pt-3 background-cultured'>
                        <ul class='nav flex-column'>
                            <li class='nav-item'>
                                <a class='nav-link' href='artist-portfolio.php?id=<?= $artist['id'] ?>'>
                                    <i class='bi bi-postage-heart-fill' style='font-size: 22px;'></i>
                                    Art
                                </a>
                            </li>
                            <li class='nav-item'>
                                <a class='nav-link active' aria-current='page' href='#'>
                                    <i class='bi bi-ticket-perforated-fill' style='font-size: 22px;'></i>
                                    Galleries
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- End of aside navbar -->

                <div class='col-md-9 col-lg-10'>
                    <div class='row p-2'>

                        <!-- Fetch all the gallery record entries by the artist who is logged in -->
                        <!-- Render a card for each gallery -->
                        <?php
                        $mysqli = require __DIR__ . '/database.php';

                        $fetch_stmt = "SELECT * FROM galleries WHERE artist_id = {$artist['id']}";

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
                                <div class='col-lg-6 col-md-12 p-3'>
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
                                                    <center>
                                                        <a href='gallery-details.php?id=<?= $gallery_id ?>' class='btn btn-imperial'>
                                                            View gallery
                                                        </a>
                                                    </center>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo "<center class='fs-5 mt-6 imperial-red'>No galleries yet. Come back later. </center>";
                        }
                        ?>

                    </div>
                </div>
            </div>

        </div>

    </main>
    <!-- End of main -->


</body>

</html>