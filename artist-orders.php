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
                    </ul>
                </div>
            </nav>
            <!-- End of aside navbar -->

            <!-- Start of main -->
            <main class='col-md-9 col-lg-10'>
                <div class='d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom'>
                    <h1 class='fs-2'>Orders.</h1>
                    <p class='fs-6 ps-4 space-cadet'>
                        Get to view the orders that were made by people who bought your art or bought tickets to your galleries.
                    </p>
                </div>
                <hr class='mobile-hide hr' />

                <div class='row'>
                    <div class='col-lg-6 col-md-12'>
                        <!-- Get and display the Art Orders from art_orders table -->
                        <h2>Art Orders</h2>
                        <div class='table-responsive'>
                            <table class='table table-striped table-sm'>
                                <thead>
                                    <tr>
                                        <th scope='col'>Order Number</th>
                                        <th scope='col'>Piece Title</th>
                                        <th scope='col'>Piece Price</th>
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
                                                    <td><?= $enth['name'] ?></td>
                                                    <td>
                                                        <?php
                                                        if ($order['isPaid'] == 1) {
                                                            echo 'Yes';
                                                        } else {
                                                            echo 'No';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($order['isCollected'] == 1) {
                                                            echo 'Yes';
                                                        } else {
                                                            echo 'No';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?= date('d M Y, g:i A', strtotime($order['created_at'])) ?></td>
                                                </tr>
                                            <?php  } ?>
                                        <?php  } ?>
                                    <?php  } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class='col-lg-6 col-md-12'>
                        <!-- Get and display the Gallery Ticket Orders from gallery_orders table -->
                        <h2>Gallery Ticket Orders</h2>
                        <div class='table-responsive'>
                            <table class='table table-striped table-sm'>
                                <thead>
                                    <tr>
                                        <th scope='col'>Order Number</th>
                                        <th scope='col'>Gallery Title</th>
                                        <th scope='col'>Gallery Fee</th>
                                        <th scope='col'>Artist Name</th>
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
                                                    <td><?= $enth['name'] ?></td>
                                                    <td>
                                                        <?php
                                                        if ($order['isPaid'] == 1) {
                                                            echo 'Yes';
                                                        } else {
                                                            echo 'No';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?= date('d M Y, g:i A', strtotime($order['created_at'])) ?></td>
                                                </tr>
                                            <?php  } ?>
                                        <?php  } ?>
                                    <?php  } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </main>
            <!-- End of main -->


        </div>
    </div>


</body>

</html>