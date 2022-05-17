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
    <title> <?= substr($user['name'], 0, strpos($user['name'], ' ')) . '\'s Piece Collection' ?> </title>

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
                <div class='col-lg-6 col-md-4 col-sm-12 px-2'>
                    <div class='card p-2'>
                        <center>
                            <h2>Collection point</h2>
                            
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.8332266053517!2d36.80274791533132!3d-1.273235635972611!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f1738049f49e3%3A0xbb1b3bf04c4f84d6!2sUniversity%20Of%20Nairobi%20-%20Chiromo%20Campus!5e0!3m2!1sen!2ske!4v1652812488504!5m2!1sen!2ske" width="750" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </center>


                    </div>
                </div>
                <div class='col-lg-6 col-md-8 col-sm-12'>

                    <div class='col-lg-12 col-md-8 px-2'>
                        <div class='row'>
                            <!-- Fetch all the orders whose isPaid = 0 made by the user whose id is in the URL -->
                            <?php
                            $fetch_orders = "SELECT * FROM art_orders WHERE user_id = {$_GET['id']} AND isPaid = 0";

                            $result = $mysqli->query($fetch_orders);

                            // if there are no orders, redirect to home
                            if ($result->num_rows == 0) {
                                header("Location: home.php");
                            }
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
                                    <div class='col-lg-12 col-md-8 col-sm-12 px-1'>
                                        <div class='card card-short mb-5'>
                                            <div class='row'>
                                                <div class='col-lg-3 col-md-8 col-sm-12'>
                                                    <img src='<?= $art['img_path'] ?>' style='max-height: 20vh !important;' alt='<?= $art['title'] ?>' class='p-4'>
                                                </div>
                                                <div class='col-lg-9 col-md-4 col-sm-12 ps-1 py-3'>
                                                    <div class='card-body'>
                                                        <div class='row'>
                                                            <div class='col-5 col-md-5 col-sm-12'>
                                                                <a href='art-piece-details.php?id=<?= $art['id'] ?>' target='_blank' class='text-dark'>
                                                                    <h2 class='card-title'><?= $art['title'] ?></h2>
                                                                </a>
                                                            </div>
                                                            <div class='col-lg-6 col-md-6 col-sm-12'>
                                                                <h3 class='card-text'><?= $art['artist_name'] ?></>
                                                            </div>
                                                            <div class='row pt-4'>
                                                                <div class='col-4'>
                                                                    <span class='card-text fs-6 pt-3'>Kshs.&nbsp;<?= $art_price ?></span>
                                                                </div>
                                                                <div class='col-4'>
                                                                    <span class='card-text fs-6 pt-3'><?= date('d M Y, g:i A', strtotime($order['created_at'])); ?></span>
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
                                            <h2>Total Price</h2>
                                        </div>
                                        <div class='col-lg-9 col-md-4 col-sm-12 ps-3 py-2'>
                                            <div class='card-body'>
                                                <span class='card-text fs-4 pt-3'>Kshs.&nbsp;<?= number_format($cart_price, 2) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </center>
                            </div>

                        </div>
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