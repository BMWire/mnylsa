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
    <title> <?= substr($user['name'], 0, strpos($user['name'], ' ')) . '\'s Gallery Orders' ?> </title>

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
                            $fetch_orders = "SELECT * FROM gallery_orders WHERE user_id = {$_GET['id']} AND isPaid = 0";

                            $result = $mysqli->query($fetch_orders);

                            // if there are no orders, redirect to home
                            if ($result->num_rows == 0) {
                                header("Location: home.php");
                            }
                            while ($order = $result->fetch_assoc()) {
                                $fetch_gallery = "SELECT * FROM galleries WHERE id = {$order['gallery_id']}";

                                $gallery_result = $mysqli->query($fetch_gallery);

                                $gallery = $gallery_result->fetch_assoc();

                                $gallery_fee = number_format($gallery['fee'], 2);

                                // get the total fee by adding all the individual fees
                                $total_fee += $gallery['fee'];

                            ?>
                                <div class='row'>
                                    <div class='col-lg-12 col-md-8 col-sm-12 px-2'>
                                        <div class='card card-short mb-6'>
                                            <div class='row'>
                                                <div class='col-lg-3 col-md-8 col-sm-12'>
                                                    <img src='<?= $gallery['coverImg'] ?>' style='max-height: 20vh !important;' alt='<?= $gallery['title'] ?>' class='p-4'>
                                                </div>
                                                <div class='col-lg-9 col-md-4 col-sm-12 ps-3 py-2'>
                                                    <div class='card-body'>
                                                        <div class='row'>
                                                            <div class='col-5 col-md-5 col-sm-12'>
                                                                <a href='gallery-details.php?id=<?= $gallery['id'] ?>' target='_blank' class='text-dark'>
                                                                    <h2 class='card-title'><?= $gallery['title'] ?></h2>
                                                                </a>
                                                            </div>
                                                            <div class='col-lg-6 col-md-6 col-sm-12'>
                                                                <h3 class='card-text'><?= $gallery['artist_name'] ?></>
                                                            </div>
                                                            <div class='row pt-4'>
                                                                <div class='col-4'>
                                                                    <span class='card-text fs-5 pt-3'>Kshs.&nbsp;<?= $gallery_fee ?></span>
                                                                </div>
                                                                <div class='col-4'>
                                                                    <span class='card-text fs-5 pt-3'><?= date('d M Y, g:i A', strtotime($order['created_at'])); ?></span>
                                                                </div>
                                                                <!-- implement delete button -->
                                                                <div class='col-4'>
                                                                    <form action='process-delete-gallery-order.php' method='POST'>
                                                                        <input type='hidden' name='gallery_id' value='<?= $gallery['id'] ?>'>
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
                        </div>
                        <!-- show the total price -->
                        <div class='card card-short mb-6'>
                            <center>
                                <div class='row'>
                                    <div class='col-lg-3 col-md-3 col-sm-12 ps-3 py-2'>
                                        <h1>Total Fees</h1>
                                    </div>
                                    <div class='col-lg-9 col-md-4 col-sm-12 ps-3 py-2'>
                                        <div class='card-body'>
                                            <span class='card-text fs-2 pt-3'>Kshs.&nbsp;<?= number_format($total_fee, 2) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </center>
                        </div>
                    </div>
                </div>

                <div class='col-lg-4 col-md-4 col-sm-12 px-2'>
                    <div class='card card-checkout p-2'>
                        <center>
                            <h2>Checkout</h2>
                        </center>
                        <p class='px-4'>
                            Having created the ticket order, your spot is saved and you can access the gallery.
                            <br />
                            The ticket will be paid for at the entrance.
                        </p>

                        <a href='enthusiast-gallery-orders.php?id=<?= $_GET['id'] ?>' class='btn btn-imperial btn-checkout'>Pay at the entrance</a>

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