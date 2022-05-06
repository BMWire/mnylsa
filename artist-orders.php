<?php

session_start();

if (isset($_SESSION['user_id'])) {
    // create a database connection 
    $mysqli = require __DIR__ . '/database.php';

    // get the user's email address
    $enth = "SELECT * FROM users
            WHERE id = {$_SESSION['user_id']}";

    $art_result = $mysqli->query($enth);

    $user = $art_result->fetch_assoc();
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
    <title>Orders | <?= $user['name'] ?>
    </title>

    <!-- Styling imports -->
    <link rel='stylesheet' href='styles/main.css'>
    <link rel='stylesheet' href='styles/utility.css'>

    <!-- Bootstrap Icons imports -->
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css'>

    <!-- <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/water.css@2/out/water.css'> -->
</head>

<body>
    <!-- if the logged in user is an artist, show the artist navbar -->
    <?php if ($user['isAdmin'] == 'yes') { ?>
        <?php include __DIR__ . '/admin-navbar.php'; ?>
    <?php } else if ($user['isArtist'] == 'yes') { ?>
        <?php include __DIR__ . '/dashboard-navbar.php'; ?>
    <?php } else { ?>
        <?php include __DIR__ . '/navbar.php'; ?>
    <?php } ?>

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
                            <a class='nav-link active' aria-current='page' href='#'>
                                <i class='bi bi-card-checklist imperial-red' style='font-size: 22px;'></i>
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
                            <a class='nav-link' href='artist-galleries.php'>
                                <i class='bi bi-building' style='font-size: 22px;'></i>
                                Galleries
                            </a>
                        </li>
                        <li class='nav-item'>
                            <!-- check to see if the logged in user has an entry in artist_details table -->
                            <?php
                            $sql = "SELECT * FROM artist_details
                                    WHERE artist_id = {$_SESSION['user_id']}";

                            $result = $mysqli->query($sql);

                            // if the logged user has an entry, show the add a piece button, else, direct them to the profile page
                            if ($result->num_rows > 0) {
                            ?>
                                <!-- show nothing -->
                            <?php
                            } else {
                            ?>
                                <a class='nav-link' href='artist-profile.php'>
                                    <i class='bi bi-plus' style='font-size: 22px;'></i>
                                    Profile
                                </a>
                            <?php
                            }
                            ?>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End of aside navbar -->

            <!-- Start of main -->
            <main class='col-md-9 col-lg-10'>
                <div class='row'>
                    <div class='col-lg-8 col-md-6 pt-3 pb-2 mb-3'>
                        <h1 class='fs-2'><?= $user['name'] ?>'s Orders.</h1>
                        <p class='fs-6 ps-4 space-cadet'>
                            Get to view the orders that were made by people who bought your art or bought tickets to your galleries.
                        </p>
                    </div>
                    <div class='col-lg-4 col-md-6 pt-3 pb-2 mb-3'>
                        <span class='col-lg-8 badge badge-imperial mr-3 mb-1'>
                            <!-- sum all the piece_price fields from art_orders -->
                            <?php
                            $art_orders = "SELECT SUM(piece_price) AS total_art_price FROM art_orders WHERE artist_id = {$_SESSION['user_id']}";

                            $art_result = $mysqli->query($art_orders);

                            $art_price = $art_result->fetch_assoc();

                            $art_sales = $art_price['total_art_price'];
                            $lisa_art_sales = $art_sales * 0.9;
                            ?>
                            Kshs <?= number_format($lisa_art_sales) ?> from Art Sales.
                        </span>
                        <span class='col-lg-8 badge badge-imperial mr-3 mb-1'>
                            <!-- sum all the gallery_fee fields from gallery_orders -->
                            <?php
                            $gallery_orders = "SELECT SUM(gallery_fee) AS total_gallery_fee FROM gallery_orders WHERE artist_id = {$_SESSION['user_id']}";

                            $gallery_result = $mysqli->query($gallery_orders);

                            $gallery_price = $gallery_result->fetch_assoc();

                            $gallery_sales = $gallery_price['total_gallery_fee'];
                            $lisa_gallery_sales = $gallery_sales * 0.9;
                            ?>
                            Kshs <?= number_format($lisa_gallery_sales) ?> from Ticket Sales.
                        </span>
                    </div>
                </div>
                <hr class='mobile-hide hr' />

                <!-- Get and display the Art Orders from art_orders table -->
                <div class='row'>
                    <div class='col-lg-3 col-md-6 pt-3 pb-2 mb-3'>
                        <h2>Art Orders</h2>
                    </div>
                    <div class='col-lg-9 col-md-6 pt-3 pb-2 mb-3'>
                        <!-- sum all the piece_price fields from art_orders -->
                        <?php
                        $art_orders = "SELECT SUM(piece_price) AS total_art_price FROM art_orders WHERE artist_id = {$_SESSION['user_id']}";

                        $art_result = $mysqli->query($art_orders);

                        $art_price = $art_result->fetch_assoc();

                        $art_sales = $art_price['total_art_price'];
                        $lisa_art_sales = $art_sales * 0.9;
                        ?>
                        <span class='col-3'>
                            <span class='col-1 mr-6'>
                                Gross Income:
                            </span>
                            <span class='col-2 badge badge-imperial mr-2 mb-1'>
                                Kshs <?= number_format($art_sales) ?>
                            </span>
                        </span>
                        <!-- count the number of sold pieces -->
                        <?php
                        $art_orders = "SELECT * FROM art_orders WHERE artist_id = {$_SESSION['user_id']}";

                        $art_result = $mysqli->query($art_orders);

                        $art_count = $art_result->num_rows;
                        ?>
                        <span class='col-3'>
                            <span class='col-3 mr-6'>
                                Net Income:
                            </span>
                            <span class='col-2 badge badge-imperial mr-2 mb-1'>
                                Kshs <?= number_format($lisa_art_sales) ?>
                            </span>
                        </span>
                        <span class='col-3'>
                            <span class='col-1'>
                                Net Commission:
                            </span>
                            <span class='col-2 badge badge-imperial mr-2 mb-1'>
                                Kshs <?= number_format($art_sales) ?>
                            </span>
                        </span>
                        <span class='col-2 badge badge-imperial ml-6 mr-2 mb-1'>
                            <?= $art_count ?> <?= $art_count == 1 ? " Piece" : " Pieces" ?>
                        </span>
                    </div>
                </div>
                <div class='table-responsive'>
                    <table class='table table-striped table-sm'>
                        <thead>
                            <tr>
                                <th scope='col'>Order Number</th>
                                <th scope='col'>Piece Title</th>
                                <th scope='col'>Piece Price</th>
                                <th scope='col'>Sales Commission</th>
                                <th scope='col'>Enthusiast Name</th>
                                <th scope='col'>Paid Yet</th>
                                <th scope='col'>Collected Yet</th>
                                <th scope='col'>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Get the orders from art_orders where artist_id for the piece_id is the same as the id for the logged in user -->
                            <?php
                            // get the details from art table of the pieces made by the logged in user
                            $art_sql = "SELECT * FROM art
                                        WHERE artist_id = {$_SESSION['user_id']}";

                            $art_result = $mysqli->query($art_sql);

                            while ($art = $art_result->fetch_assoc()) {
                                // get the details from art_orders table of the logged in user
                                $order_sql = "SELECT * FROM art_orders
                                            WHERE piece_id = {$art['id']}";

                                $order_result = $mysqli->query($order_sql);

                                while ($order = $order_result->fetch_assoc()) {
                                    // get the details from users table of the logged in user
                                    $enth = "SELECT * FROM users
                                                WHERE id = {$order['user_id']}";

                                    $enth_result = $mysqli->query($enth);

                                    while ($enth = $enth_result->fetch_assoc()) {
                            ?>
                                        <tr>
                                            <td><?= 'A' . 10000 + $order['id'] ?></td>
                                            <td><?= $art['title'] ?></td>
                                            <td>Kshs. <?= number_format($art['price'], 0) ?></td>
                                            <td>Kshs. <?= number_format($art['price'] * 0.1, 0) ?></td>
                                            <td><?= $enth['name'] ?></td>
                                            <td>
                                                <?php
                                                if ($order['isPaid'] == 1) {
                                                    echo 'Yes';
                                                } else {
                                                    // implement button to update isPaid to 1
                                                ?>
                                                    <center>
                                                        <form action='process-mark-art-paid.php' method='POST'>
                                                            <input type='hidden' name='order_id' value='<?= $order['id'] ?>'>
                                                            <button type='submit' class='btn btn-sm btn-imperial mb-2'>Mark as Paid</button>
                                                        </form>
                                                    </center>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($order['isCollected'] == 1) {
                                                    echo 'Yes';
                                                } else {
                                                    // implement button to update isCollected to 1
                                                ?>
                                                    <center>
                                                        <form action='process-mark-art-collected.php' method='POST'>
                                                            <input type='hidden' name='order_id' value='<?= $order['id'] ?>'>
                                                            <button type='submit' class='btn btn-sm btn-imperial mb-2'>Mark as Collected</button>
                                                        </form>
                                                    </center>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td><?= date('d M Y, g:i A', strtotime($order['created_at'])) ?></td>
                                        </tr>
                                    <?php  } ?>
                                <?php  } ?>
                            <?php  } ?>
                            <tr>
                                <td colspan='5'>
                                    <h2 class='fs-5'>
                                        Total Sales:
                                        </h>
                                </td>
                                <td colspan='3'>
                                    <h2 class='fs-6 imperial-red cultured-underlined'>
                                        Kshs. <?= number_format($lisa_art_sales, 2) ?>
                                    </h2>
                                </td>
                            </tr>
                            <tr>
                                <td colspan='5'>
                                    <h2 class='fs-5'>
                                        Total Commission:
                                        </h>
                                </td>
                                <td colspan='3'>
                                    <h2 class='fs-6 imperial-red cultured-underlined'>
                                        Kshs. <?= number_format($art_sales * 0.1, 2) ?>
                                    </h2>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Get and display the Gallery Ticket Orders from gallery_orders table -->
                <!-- Get and display the Art Orders from art_orders table -->
                <div class='row mt-6'>
                    <div class='col-lg-3 col-md-6 pt-3 pb-2 mb-3'>
                        <h2>Gallery Ticket Orders</h2>
                    </div>
                    <div class='col-lg-9 col-md-6 pt-3 pb-2 mb-3'>
                        <!-- sum all the gallery_fee fields from gallery_orders -->
                        <?php
                        $gallery_orders = "SELECT SUM(gallery_fee) AS total_gallery_fee FROM gallery_orders WHERE artist_id = {$_SESSION['user_id']}";

                        $gallery_result = $mysqli->query($gallery_orders);

                        $gallery_price = $gallery_result->fetch_assoc();

                        $gallery_sales = $gallery_price['total_gallery_fee'];
                        $lisa_gallery_sales = $gallery_sales * 0.9;
                        ?>
                        <span>
                            <span class='col-5'>
                                Gross Income:
                            </span>
                            <span class='col-2 badge badge-imperial ml-2 mr-2 mb-1'>
                                Kshs <?= number_format($gallery_sales) ?>
                            </span>
                        </span>

                        <!-- count the number of sold gallery tickets -->
                        <?php
                        $gallery_orders = "SELECT * FROM gallery_orders WHERE artist_id = {$_SESSION['user_id']}";

                        $gallery_result = $mysqli->query($gallery_orders);

                        $gallery_count = $gallery_result->num_rows;
                        ?>
                        <span>
                            <span class='col-3 mr-3'>
                                Net Income:
                            </span>
                            <span class='col-2 badge badge-imperial ml-2 mr-2 mb-1'>
                                Kshs <?= number_format($lisa_gallery_sales) ?>
                            </span>
                        </span>
                        <span>
                            <span class='col-3 mr-3'>
                                Net Commission:
                            </span>
                            <span class='col-2 badge badge-imperial ml-2 mr-2 mb-1'>
                                Kshs <?= number_format($gallery_sales * 0.1) ?>
                            </span>
                        </span>
                        <span class='col-2 badge badge-imperial ml-6 mb-1'>
                            <?= $gallery_count ?> <?= $gallery_count == 1 ? " Ticket" : " Tickets" ?>
                        </span>
                    </div>
                </div>
                <div class='table-responsive'>
                    <table class='table table-striped table-sm'>
                        <thead>
                            <tr>
                                <th scope='col'>Order Number</th>
                                <th scope='col'>Gallery Title</th>
                                <th scope='col'>Gallery Fee</th>
                                <th scope='col'>Sales Commission</th>
                                <th scope='col'>Enthusiast Name</th>
                                <th scope='col'>Paid Yet</th>
                                <th scope='col'>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Get the orders from art_orders where artist_id for the piece_id is the same as the id for the logged in user -->
                            <?php
                            // get the details from art table of the pieces made by the logged in user
                            $gallery_sql = "SELECT * FROM galleries
                                        WHERE artist_id = {$_SESSION['user_id']}";

                            $gallery_result = $mysqli->query($gallery_sql);

                            while ($gallery = $gallery_result->fetch_assoc()) {
                                // get the details from art_orders table of the logged in user
                                $order_sql = "SELECT * FROM gallery_orders
                                            WHERE gallery_id = {$gallery['id']}";

                                $order_result = $mysqli->query($order_sql);

                                while ($order = $order_result->fetch_assoc()) {
                                    // get the details from users table of the logged in user
                                    $enth = "SELECT * FROM users
                                                WHERE id = {$order['user_id']}";

                                    $enth_result = $mysqli->query($enth);

                                    while ($enth = $enth_result->fetch_assoc()) {
                            ?>
                                        <tr>
                                            <td><?= 'A' . 10000 + $order['id'] ?></td>
                                            <td><?= $gallery['title'] ?></td>
                                            <td>Kshs. <?= number_format($gallery['fee'], 0) ?></td>
                                            <td>Kshs. <?= number_format($gallery['fee'] * 0.1, 0) ?></td>
                                            <td><?= $enth['name'] ?></td>
                                            <td>
                                                <?php
                                                if ($order['isPaid'] == 1) {
                                                    echo 'Yes';
                                                } else {
                                                ?>
                                                    <center>
                                                        <form action='process-mark-gallery-paid.php' method='POST'>
                                                            <input type='hidden' name='order_id' value='<?= $order['id'] ?>'>
                                                            <button type='submit' class='btn btn-sm btn-imperial mb-2'>Mark as Paid</button>
                                                        </form>
                                                    </center>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td><?= date('d M Y, g:i A', strtotime($order['created_at'])) ?></td>
                                        </tr>
                                    <?php  } ?>
                                <?php  } ?>
                            <?php  } ?>
                            <tr>
                                <td colspan='5'>
                                    <h2 class='fs-5'>
                                        Total Ticket Sales:
                                        </h>
                                </td>
                                <td colspan='3'>
                                    <h2 class='fs-6 imperial-red cultured-underlined'>
                                        Kshs. <?= number_format($lisa_gallery_sales, 2) ?>
                                    </h2>
                                </td>
                            </tr>
                            <tr>
                                <td colspan='5'>
                                    <h2 class='fs-5'>
                                        Total Commission:
                                        </h>
                                </td>
                                <td colspan='3'>
                                    <h2 class='fs-6 imperial-red cultured-underlined'>
                                        Kshs. <?= number_format($gallery_sales * 0.1, 2) ?>
                                    </h2>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </main>
            <!-- End of main -->


        </div>
    </div>


</body>

</html>