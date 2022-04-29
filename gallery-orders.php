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
<!-- Fetch the details for the gallery_order for the user whose id is in the URL -->
<?php
$fetch_gallery_session = "SELECT * FROM gallery_orders WHERE user_id = {$_GET['id']}";

$result = $mysqli->query($fetch_gallery_session);

$gallery_order = $result->fetch_assoc();

// Check if there is no order matching the user id or if the order is empty
if (!$gallery_order || empty($gallery_order)) {
    header("Location: home.php");
}


// fetch the additional details for the art piece that is in the order
$fetch_gallery = "SELECT * FROM galleries WHERE id = {$gallery_order['gallery_id']}";

$gallery_result = $mysqli->query($fetch_gallery);

$gallery = $gallery_result->fetch_assoc();
?>

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
                    <span>User Id: <?= $user['id'] ?></span>
                    <br />
                    <span>User Name: <?= $user['name'] ?></span>
                    <br />
                    <span>Piece Id: <?= $gallery_order['piece_id'] ?></span>
                    <br />
                    <span>Piece Title: <?= $gallery_order['piece_title'] ?></span>
                    <br />
                    <span>Piece Artist: <?= $gallery['artist_name'] ?></span>
                    <br />
                    <span>Piece Artist Id: <?= $gallery['artist_id'] ?></span>
                    <br />
                    <span>Piece Price: <?= $gallery_order['piece_price'] ?></span>

                    <div class='col-lg-12 col-md-8 px-2'>
                        <div class='row'>

                            <!-- Fetch all the orders whose isPaid = 0 made by the user whose id is in the URL -->
                            <?php
                            $fetch_orders = "SELECT * FROM gallery_orders WHERE user_id = {$_GET['id']} AND isPaid = 0";

                            $result = $mysqli->query($fetch_orders);

                            while ($order = $result->fetch_assoc()) {
                                $fetch_gallery = "SELECT * FROM galleries WHERE id = {$order['gallery_id']}";

                                $gallery_result = $mysqli->query($fetch_gallery);

                                $gallery = $gallery_result->fetch_assoc();

                                $gallery_fee = number_format($gallery['fee'], 2);

                                echo "<div class='row'>
                                <div class='col-lg-12 col-md-8 col-sm-12 px-2'>
                                    <div class='card card-short mt-6'>
                                            <div class='row'>
                                                <div class='col-lg-3 col-md-8 col-sm-12'>
                                                    <img src='{$gallery['coverImg']}' style='max-height: 20vh !important;' alt='{$gallery['title']}' class='p-4'>
                                                </div>
                                                <div class='col-lg-9 col-md-4 col-sm-12 ps-3 py-3'>
                                                    <div class='card-body'>
                                                    <div class='row'>
                                                    <div class='col-5 col-md-5 col-sm-12'>
                                                        <h2 class='card-title'>{$gallery['title']}</h2>
                                                    </div>
                                                    <div class='col-lg-6 col-md-6 col-sm-12'>
                                                        <h3 class='card-text'>{$gallery['artist_name']}</>
                                                    </div>
                                                    <span class='card-text fs-5 pt-3'>Kshs.&nbsp;{$gallery_fee}</span>
                                                </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>";
                            }
                            ?>


                        </div>
                    </div>
                </div>

                <div class='col-lg-4 col-md-4 col-sm-12 px-2'>
                    <div class='card card-checkout p-2'>
                        <center>
                            <h2>Checkout</h2>
                        </center>

                        <!-- Paypal Implementation -->
                        <div id='paypal-button-container' class='p-4'></div>
                    </div>
                </div>
            </div>


    </main>
    <!-- Paypal Scripts addtion -->
    <script src='https://www.paypal.com/sdk/js?client-id=AQ1dYNCw-E-XfDrHWhe1BZ5-90Y1e4c0Ut7C7lTH_LPT33dXt0ma70l75mWT1QEdbAOZHacxMlbNzSyk'></script>
    <script src='js/payments.js'></script>

    <!-- End of main -->


</body>

</html>