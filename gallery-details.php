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
<!-- Fetch the details for the gallery whose id is in the URL -->
<?php
$mysqli = require __DIR__ . '/database.php';

$fetch_stmt = "SELECT * FROM galleries WHERE id = {$_GET['id']}";

$result = $mysqli->query($fetch_stmt);

$gallery = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title> <?= $gallery['title'] ?> | <?= $gallery['artist_name'] ?> </title>

    <!-- Styling imports -->
    <link rel='stylesheet' href='styles/main.css'>
    <link rel='stylesheet' href='styles/utility.css'>

    <!-- Bootstrap Icons imports -->
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css'>

    <!-- <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/water.css@2/out/water.css'> -->
</head>

<body>
    <?php include __DIR__ . '/navbar.php'; ?>

    <!-- Start of main -->
    <main>
        <div class='container-flex'>
            <div class='card card-tall mt-6'>
                <div class='row'>
                    <!-- Render the image for the gallery -->
                    <div class='col-lg-7 col-md-8 col-sm-12'>
                        <center>
                            <img src='<?= $gallery['coverImg'] ?>' style='max-height: 90vh;' alt='<?= $gallery['title'] ?>' class='card-img-lg pt-5'>
                        </center>
                    </div>

                    <!-- Render the details for the gallery -->
                    <div class='col-lg-5 col-md-4 col-sm-12 py-3'>
                        <div class='card-body'>
                            <div class='row'>
                                <div class='col-lg-6 col-md-5 col-sm-12'>
                                    <h1 class=''><?= $gallery['title'] ?></h1>
                                </div>
                                <div class='col-lg-6 col-md-6 col-sm-12'>
                                    <h3 class='pt-3'><?= $gallery['artist_name'] ?></h3>
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col-lg-6 col-md-5 col-sm-12'>
                                    <p class='bold fs-5'>
                                        <i class='bi bi-geo-fill imperial-red' style='font-size:22px;'></i> &nbsp;
                                        <?= $gallery['location'] ?>
                                    </p>
                                </div>
                                <div class='col-lg-6 col-md-6 col-sm-12'>
                                    <p class='bold fs-5'>
                                        <i class='bi bi-calendar-date imperial-red' style='font-size:22px;'></i> &nbsp;
                                        <!-- Show the date in words -->
                                        <?php
                                        $date = date_create($gallery['date']);
                                        echo date_format($date, 'F j, Y');
                                        ?>
                                    </p>
                                </div>
                            </div>

                            <p class='card-text text-spacing'>
                                <?= $gallery['story'] ?>.
                            </p>

                            <span class='card-text fs-4'>Ksh <?= number_format($gallery['fee'], 2) ?></span>
                        </div>

                        <?php if ($user['isArtist'] == 'yes') : ?>

                            <center>
                                <a href='artist-edit-gallery.php?id=<?= $gallery['id'] ?>'>
                                    <button class='btn btn-lg btn-imperial'>
                                        Edit gallery
                                    </button>
                                </a>
                            </center>

                        <?php else : ?>

                            <center>
                                <a href='tickets.php?id=<?= $gallery['id'] ?>'>
                                    <button class='btn btn-lg btn-imperial'>
                                        Buy ticket
                                    </button>
                                </a>
                            </center>

                        <?php endif; ?>

                    </div>
                </div>
            </div>

    </main>
    <!-- End of main -->


</body>

</html>