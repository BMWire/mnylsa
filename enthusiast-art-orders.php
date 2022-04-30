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
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Art Orders | <?= $user['name'] ?>
    </title>

    <!-- Styling imports -->
    <link rel='stylesheet' href='styles/main.css'>
    <link rel='stylesheet' href='styles/utility.css'>

    <!-- Bootstrap Icons imports -->
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css'>

    <!-- <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/water.css@2/out/water.css'> -->
</head>

<body>
    <?php include __DIR__ . '/enthusiast-navbar.php'; ?>

    <!-- Start of main -->
    <div class='container-flex' style='padding-left:7%; padding-right:8%;'>
        <div class='row'>

            <!-- Start of aside navbar -->
            <nav class='col-md-3 col-lg-2 d-md-block'>
                <div class='position-sticky pt-3 background-cultured'>
                    <ul class='nav flex-column'>
                        <li class='nav-item'>
                            <a class='nav-link active' aria-current='page' href='#'>
                                <i class='bi bi-postage-heart-fill' style='font-size: 22px;'></i>&nbsp;
                                Art Orders
                            </a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link' href='enthusiast-gallery-orders.php'>
                                <i class='bi bi-ticket-perforated-fill rotate' style='font-size: 22px;'></i>&nbsp;
                                Gallery Tickets
                            </a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link' href='artist-galleries.php'>
                                <i class='bi bi-brush-fill' style='font-size: 22px;'></i>&nbsp;
                                Account settings
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End of aside navbar -->

            <!-- Start of main -->
            <main class='col-md-9 col-lg-10'>

                <?php if (isset($user)) : ?>
                    My name is <?= $user['name'] ?>.
                    My user id is <?= $user['id'] ?>.
                <?php else : ?>
                    <p class='nav-link'>
                        <a href='signin.php'>Sign In</a>
                        or
                        <a href='signup.html'>Sign Up</a>
                    </p>
                <?php endif; ?>


                <div class='d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom'>
                    <h1 class='fs-2'>Art Orders</h1>
                    <p class='fs-6 ps-4 space-cadet'>
                        Get to see all the orders you've placed.
                    </p>
                </div>

                <hr class='mobile-hide hr' />

                <center>
                    <div class='table-responsive mt-6'>
                        <table class='table table-striped table-sm'>
                            <thead>
                                <tr>
                                    <th scope='col'>Order Number</th>
                                    <th scope='col'>Piece Title</th>
                                    <th scope='col'>Piece Artist</th>
                                    <th scope='col'>Piece Price</th>
                                    <th scope='col'>Paid yet</th>
                                    <th scope='col'>Collected yet</th>
                                    <th scope='col'>Created at</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Get the data to fill the table from art_orders table -->
                                <?php
                                $sql = "SELECT * FROM art_orders
                                        WHERE user_id = {$user['id']}";

                                $result = $mysqli->query($sql);

                                // if there are no art orders, display a message
                                if ($result->num_rows == 0) {
                                    echo "
                                    <tr>
                                    <td colspan='7' class='text-center'>
                                    You have no art orders. <a href='home.php'>Order some art</a>
                                    </td>
                                    </tr>";
                                } else {
                                    // fetch the data on the artist name from art table
                                    while ($row = $result->fetch_assoc()) {
                                        $sql = "SELECT * FROM art
                                            WHERE id = {$row['piece_id']}";

                                        $art_result = $mysqli->query($sql);

                                        $art = $art_result->fetch_assoc();

                                        $sql = "SELECT * FROM users
                                            WHERE id = {$art['artist_id']}";

                                        $artist_result = $mysqli->query($sql);
                                        $artist = $artist_result->fetch_assoc();


                                ?>
                                        <tr>
                                            <td><?= 'A' . 10000 + $row['id'] ?></td>
                                            <td><?= $art['title'] ?></td>
                                            <td><?= $artist['name'] ?></td>
                                            <td>Kshs. <?= number_format($art['price'], 0) ?></td>
                                            <td>
                                                <?php
                                                if ($row['isPaid'] == 1) {
                                                    echo 'Yes';
                                                } else {
                                                    echo 'No';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($row['isCollected'] == 1) {
                                                    echo 'Yes';
                                                } else {
                                                    echo 'No';
                                                }
                                                ?>
                                            </td>
                                            <td><?= date('d M Y, g:i A', strtotime($row['created_at'])); ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                        </table>
                    </div>
                </center>
            </main>
            <!-- End of main -->

        </div>
    </div>


</body>

</html>