<?php

session_start();

if (isset($_SESSION['user_id'])) {
    // create a database connection 
    $mysqli = require __DIR__ . '/database.php';

    // get the logged in user's id
    $fetch_user_session = "SELECT * FROM users
            WHERE id = {$_SESSION['user_id']}";

    $result = $mysqli->query($fetch_user_session);

    $user = $result->fetch_assoc();
} else {
    header('Location: home.php');
}
?>
<!-- Fetch the details for the gallery whose id is in the URL -->
<?php
$fetch_art_session = "SELECT * FROM galleries WHERE id = {$_GET['id']}";

$result = $mysqli->query($fetch_art_session);

$gallery = $result->fetch_assoc();

?>

<!-- Fetch the order id from the art_orders table-->

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title> <?= substr($user['name'], 0, strpos($user['name'], ' ')) . '\'s Tickets' ?> </title>

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
        <div class='container'>
            <div class='card card-short mt-6'>
                <div class='row'>
                    <!-- Render the image for the gallery -->
                    <div class='col-lg-4 col-md-8 col-sm-12'>
                        <img src='<?= $gallery['coverImg'] ?>' style='max-height: 20vh !important;' alt='<?= $gallery['title'] ?>' class='p-4'>
                    </div>

                    <!-- Render the details for the gallery -->
                    <div class='col-lg-8 col-md-4 col-sm-12 ps-2 py-2'>
                        <div class='card-body'>
                            <div class='row'>
                                <div class='col-5 col-md-5 col-sm-12'>
                                    <h2 class='manatee'><?= $gallery['title'] ?></h2>
                                </div>
                                <div class='col-lg-6 col-md-6 col-sm-12'>
                                    <h2 class=''><?= $gallery['artist_name'] ?></h2>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-lg-6 col-md-6 col-sm-12'>
                                    <span class='card-text fs-5' id='ticket-cost'>
                                        Ksh <?= number_format($gallery['fee'], 2) ?>
                                    </span>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <center class='mt-4'>
                <form action='process-create-gallery-order.php' method='POST'>
                    <input type='hidden' name='user_id' value='<?= $user['id'] ?>'>
                    <input type='hidden' name='user_name' value='<?= $user['name'] ?>'>
                    <input type='hidden' name='gallery_id' value='<?= $gallery['id'] ?>'>
                    <input type='hidden' name='gallery_artist_id' value='<?= $gallery['artist_id'] ?>'>
                    <input type='hidden' name='gallery_title' value='<?= $gallery['title'] ?>'>
                    <input type='hidden' name='gallery_fee' value='<?= $gallery['fee'] ?>'>

                    <button type='submit' class='btn btn-lg btn-imperial'>Create Order</button>

                </form>

            </center>

        </div>


    </main>
    <!-- End of main -->


</body>

</html>