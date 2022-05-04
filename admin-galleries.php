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

<?php
// fetch the number of total users from the users table
$sql = "SELECT COUNT(*) AS gallery_count FROM art";

$gallery_count_result = $mysqli->query($sql);

$gallery_count = $gallery_count_result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Moneylisa Galleries | <?= $user['name'] ?>
    </title>

    <!-- Styling imports -->
    <link rel='stylesheet' href='styles/main.css'>
    <link rel='stylesheet' href='styles/utility.css'>

    <!-- Bootstrap Icons imports -->
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css'>

</head>

<body>
    <?php include __DIR__ . '/admin-navbar.php'; ?>

    <!-- Start of main -->
    <div class='container-flex' style='padding-left:7%; padding-right:8%;'>
        <div class='row'>

            <!-- Start of aside navbar -->
            <nav class='col-md-3 col-lg-2 d-md-block'>
                <div class='position-sticky pt-3 background-cultured'>
                    <ul class='nav flex-column'>
                        <li class='nav-item'>
                            <a class='nav-link' href='admin-dashboard.php'>
                                <i class='bi bi-bar-chart' style='font-size: 22px;'></i>
                                Dashboard
                            </a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link' href='admin-users.php'>
                                <i class='bi bi-people-fill' style='font-size: 22px;'></i>
                                Users
                            </a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link' href='admin-pieces.php'>
                                <i class='bi bi-box-seam' style='font-size: 22px;'></i>
                                Pieces
                            </a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link active' aria-current='page' href='admin-galleries.php'>
                                <i class='bi bi-building imperial-red' style='font-size: 22px;'></i>
                                Galleries
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End of aside navbar -->

            <!-- Start of main -->
            <main class='col-md-9 col-lg-10'>

                <div class='row'>
                    <div class='col-lg-6 col-md-6 pt-3 pb-2 mb-3'>
                        <h1 class='fs-2'>Galleries.</h1>
                        <p class='fs-6 ps-4 space-cadet'>
                            All the galleries that users can attend.
                        </p>
                    </div>
                    <div class='col-lg-6 col-md-6 pt-3 pb-2 mb-3'>
                        <center>
                            <span class='col-lg-5 badge badge-imperial mr-3'>
                                <?= $gallery_count['gallery_count'] ?> <?= $gallery_count['gallery_count'] == 1 ? " Gallery" : " Galleries" ?>
                            </span>
                        </center>
                    </div>
                </div>

                <hr class='mobile-hide hr' />

                <!-- Get and display the Users from users table -->
                <div class='table-responsive'>
                    <table class='table table-striped table-sm'>
                        <thead>
                            <tr>
                                <th scope='col'>Gallery Id</th>
                                <th scope='col'>Artist Name</th>
                                <th scope='col'>Title</th>
                                <th scope='col'>Ticket Fee</th>
                                <th scope='col'>Start Date</th>
                                <th scope='col'>Created At</th>
                                <th scope='col'>Close</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // get the details from user table of the pieces made by the logged in user
                            $gallery_sql = "SELECT * FROM galleries";

                            $gallery_result = $mysqli->query($gallery_sql);

                            while ($gallery = $gallery_result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?= 'G00' . $gallery['id'] ?></td>
                                    <td>
                                        <a target='_blank' href='artist-portfolio.php?id=<?= $gallery['artist_id'] ?>'>
                                            <?= $gallery['artist_name'] ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href='gallery-details.php?id=<?= $gallery['id'] ?>'>
                                            <?= $gallery['title'] ?>
                                        </a>
                                    </td>
                                    <td>Kshs. <?= number_format($gallery['fee']) ?></td>
                                    <td><?= date('d M Y', strtotime($gallery['date'])) ?></td>
                                    <td><?= date('d M Y, g:i A', strtotime($gallery['created_at'])) ?></td>
                                    <td>
                                        <center>
                                            <form action='process-close-gallery.php' method='POST'>
                                                <input type='hidden' name='gallery_id' value='<?= $gallery['id'] ?>'>
                                                <button type='submit' class='btn btn-sm mb-2'>Close</button>
                                            </form>
                                        </center>
                                    </td>
                                </tr>
                            <?php  } ?>
                        </tbody>
                    </table>
                </div>




            </main>
            <!-- End of main -->

        </div>
    </div>


</body>

</html>