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

// Check if there is no order matching the user id or if the order is empty
if (!$art_order || empty($art_order)) {
    header("Location: home.php");
}


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
    <title> <?= substr($user['name'], 0, strpos($user['name'], ' ')) . '\'s Art Orders' ?> </title>

    <!-- Styling imports -->
    <link rel='stylesheet' href='styles/main.css'>
    <link rel='stylesheet' href='styles/utility.css'>

    <!-- Bootstrap Icons imports -->
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css'>

</head>

<body>
    <?php include __DIR__ . '/navbar.php'; ?>

    <!-- Start of main -->
    <main>
        <div class='container-cart'>
            <div class='row mt-6'>
                <div class='col-lg-8 col-md-8 col-sm-12'>

                    <div class='col-lg-12 col-md-8 px-2'>
                        <div class='row'>
                            <!-- Fetch all the orders whose isPaid = 0 made by the user whose id is in the URL -->
                            <?php
                            $fetch_orders = "SELECT * FROM art_orders WHERE user_id = {$_GET['id']} AND isPaid = 0";

                            $result = $mysqli->query($fetch_orders);

                            while ($order = $result->fetch_assoc()) {
                                $fetch_art = "SELECT * FROM art WHERE id = {$order['piece_id']}";

                                $piece_result = $mysqli->query($fetch_art);

                                $art = $piece_result->fetch_assoc();

                                $art_price = number_format($art['price'], 2);

                                // get the total cart price by adding all the individual art prices
                                $cart_price = $cart_price + $art['price'];
                            ?>
                                <!-- Start of order -->
                                <div class='row'>
                                    <div class='col-lg-12 col-md-8 col-sm-12 px-2'>
                                        <div class='card card-short mb-5'>
                                            <div class='row'>
                                                <div class='col-lg-3 col-md-8 col-sm-12'>
                                                    <img src='<?= $art['img_path'] ?>' style='max-height: 20vh !important;' alt='<?= $art['title'] ?>' class='p-4'>
                                                </div>
                                                <div class='col-lg-9 col-md-4 col-sm-12 ps-3 py-3'>
                                                    <div class='card-body'>
                                                        <div class='row'>
                                                            <div class='col-5 col-md-5 col-sm-12'>
                                                                <h2 class='card-title'><?= $art['title'] ?></h2>
                                                            </div>
                                                            <div class='col-lg-6 col-md-6 col-sm-12'>
                                                                <h3 class='card-text'><?= $art['artist_name'] ?></>
                                                            </div>
                                                            <div class='row pt-4'>
                                                                <div class='col-4'>
                                                                    <span class='card-text fs-5 pt-3'>Kshs.&nbsp;<?= $art_price ?></span>
                                                                </div>
                                                                <div class='col-4'>
                                                                    <span class='card-text fs-5 pt-3'><?= date('d M Y, g:i A', strtotime($order['created_at'])); ?></span>
                                                                </div>
                                                                <div class='col-4'>
                                                                    <!-- implement delete art order button -->
                                                                    <form action='process-delete-art-order.php' method='POST'>
                                                                        <input type='hidden' name='art_id' value='<?= $art['id'] ?>'>
                                                                        <input type='hidden' name='user_id' value='<?= $user['id'] ?>'>
                                                                        <button type='submit' class='btn btn-sm btn-imperial mb-2'>Delete</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- show the total cart price -->
                            <div class='card card-short mb-6'>
                                <center>
                                    <div class='row'>
                                        <div class='col-lg-3 col-md-3 col-sm-12 ps-3 py-2'>
                                            <h1>Total Price</h1>
                                        </div>
                                        <div class='col-lg-9 col-md-4 col-sm-12 ps-3 py-2'>
                                            <div class='card-body'>
                                                <span class='card-text fs-2 pt-3'>Kshs.&nbsp;<?= number_format($cart_price, 2) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </center>
                            </div>

                        </div>
                    </div>
                </div>

                <div class='col-lg-4 col-md-4 col-sm-12 px-2'>
                    <div class='card card-checkout p-2'>
                        <center>
                            <h2>Checkout</h2>
                        </center>
                        <p class='px-4'>
                            There is an option - more preferred where you can pay on piece collection
                        </p>

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