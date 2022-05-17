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
    <title>Gallery Orders | <?= $user['name'] ?>
    </title>

    <!-- Styling imports -->
    <link rel='stylesheet' href='styles/main.css'>
    <link rel='stylesheet' href='styles/utility.css'>

    <!-- Bootstrap Icons imports -->
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css'>

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
                            <a class='nav-link' href='enthusiast-art-orders.php'>
                                <i class='bi bi-postage-heart-fill' style='font-size: 22px;'></i>&nbsp;
                                Art Orders
                            </a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link active' aria-current='page' href='#'>
                                <i class='bi bi-ticket-perforated-fill rotate' style='font-size: 22px;'></i>&nbsp;
                                Gallery Tickets
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End of aside navbar -->

            <!-- Start of main -->
            <main class='col-md-9 col-lg-10'>

                <div class='d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom'>
                    <h1 class='fs-2'>Gallery Ticket Orders</h1>
                    <p class='fs-6 ps-4 space-cadet'>
                        Have a look at all the gallery tickets that you have bought.
                    </p>
                </div>

                <hr class='mobile-hide hr' />

                <center>
                    <div class='table-responsive mt-6'>
                        <table class='table table-striped table-sm'>
                            <thead>
                                <tr>
                                    <th scope='col'>Order Number</th>
                                    <th scope='col'>Gallery Title</th>
                                    <!-- <th scope='col'>Gallery Location</th> -->
                                    <th scope='col'>Gallery Fee</th>
                                    <th scope='col'>Artist Name</th>
                                    <th scope='col'>Paid yet</th>
                                    <th scope='col'>Collected yet</th>
                                    <th scope='col'>Created at</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Get the data to fill the table from art_orders table -->
                                <?php
                                $sql = "SELECT * FROM gallery_orders
                                        WHERE user_id = {$user['id']}";

                                $result = $mysqli->query($sql);

                                // if there are no gallery orders, display a message
                                if ($result->num_rows == 0) {
                                    echo "<tr><td colspan='7' class='text-center'>You have no gallery orders yet.</td></tr>";
                                } else {

                                    // fetch the data on the artist name from art table
                                    while ($row = $result->fetch_assoc()) {
                                        $sql = "SELECT * FROM galleries
                                            WHERE id = {$row['gallery_id']}";

                                        $gallery_result = $mysqli->query($sql);

                                        $gallery = $gallery_result->fetch_assoc();

                                        $sql = "SELECT * FROM users
                                            WHERE id = {$gallery['artist_id']}";

                                        $artist_result = $mysqli->query($sql);
                                        $artist = $artist_result->fetch_assoc();

                                        $paid = $row['paid'] ? 'Yes' : 'No';
                                        $collected = $row['collected'] ? 'Yes' : 'No';
                                ?>
                                        <tr>
                                            <td><?= 'G' . 20000 + $row['id'] ?></td>
                                            <td><?= $gallery['title'] ?></td>
                                            <!-- <td><?= $gallery['location'] ?></td> -->
                                            <td>Kshs. <?= number_format($gallery['fee'], 0) ?></td>
                                            <td><?= $artist['name'] ?></td>
                                            <td><?= $paid ?></td>
                                            <td><?= $collected ?></td>
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