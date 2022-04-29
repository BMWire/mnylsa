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
<!-- Fetch the details for the art_order for the user whose id is in the URL
<?php
$fetch_art_session = "SELECT * FROM art_orders WHERE user_id = {$_GET['id']}";

$result = $mysqli->query($fetch_art_session);

$art_order = $result->fetch_assoc();


// fetch the additional details for the art piece that is in the order
$fetch_art_piece = "SELECT * FROM art WHERE id = {$art_order['piece_id']}";

$piece_result = $mysqli->query($fetch_art_piece);

$art = $piece_result->fetch_assoc();
?>

<!-- Fetch the order id from the art_orders table-->

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title> <?= substr($user['name'], 0, strpos($user['name'], ' ')) . '\'s Orders' ?> </title>

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
        <div class='container-cart'>
            <div class='row mt-6'>
                <div class='col-lg-8 col-md-8 col-sm-12'>
                    <!-- <span>User Id: <?= $user['id'] ?></span>
                    <br />
                    <span>User Name: <?= $user['name'] ?></span>
                    <br />
                    <span>Piece Id: <?= $art_order['piece_id'] ?></span>
                    <br />
                    <span>Piece Title: <?= $art_order['piece_title'] ?></span>
                    <br />
                    <span>Piece Artist: <?= $art['artist_name'] ?></span>
                    <br />
                    <span>Piece Artist Id: <?= $art['artist_id'] ?></span>
                    <br />
                    <span>Piece Price: <?= $art_order['piece_price'] ?></span> -->

                    <div class='col-lg-12 col-md-8 px-2'>
                        <!-- Shipping address -->
                        <div class='row'>
                            <div class='card card-short col-lg-12 col-md-12 p-3'>
                                <h3>Collection Address</h3>
                                <p>Street: <?= $art_order['street'] ?></p>
                                <p>City: <?= $art_order['city'] ?></p>
                                <p>County: <?= $art_order['county'] ?></p>
                                <p>Country: <?= $art_order['country'] ?></p>
                            </div>
                        </div>

                        <div class='card card-short mt-6'>
                            <div class='row'>
                                <!-- Render the image for the order -->
                                <div class='col-lg-3 col-md-8 col-sm-12'>
                                    <img src='<?= $art['img_path'] ?>' style='max-height: 20vh !important;' alt='<?= $art['title'] ?>' class='p-4'>
                                </div>

                                <!-- Render the details for the piece -->
                                <div class='col-lg-9 col-md-4 col-sm-12 ps-3 py-3'>
                                    <div class='card-body'>
                                        <div class='row'>
                                            <div class='col-5 col-md-5 col-sm-12'>
                                                <h2 class='space-cadet'><?= $art_order['piece_title'] ?></h2>
                                            </div>
                                            <div class='col-lg-6 col-md-6 col-sm-12'>
                                                <h3 class=''><?= $art['artist_name'] ?></h3>
                                            </div>
                                        </div>
                                        <span class='card-text fs-5'>
                                            Ksh <?= number_format($art_order['piece_price'], 2) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class='col-lg-4 col-md-4 col-sm-12 px-2'>
                    <div class='card card-checkout p-2'>
                        <center>
                            <h2>Checkout</h2>
                        </center>

                        <!-- Paypal Implementation -->
                    </div>
                </div>
            </div>


    </main>
    <!-- End of main -->


</body>

</html>