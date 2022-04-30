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
    <title>Dashboard | <?= $user['name'] ?>
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

    <!-- Start of main -->
    <div class='container-flex' style='padding-left:7%; padding-right:8%;'>
        <div class='row'>

            <!-- Start of aside navbar -->
            <nav class='col-md-3 col-lg-2 d-md-block'>
                <div class='position-sticky pt-3 background-cultured'>
                    <ul class='nav flex-column'>
                        <li class='nav-item'>
                            <a class='nav-link active' aria-current='page' href='#'>
                                <i class='bi bi-bar-chart imperial-red' style='font-size: 22px;'></i>
                                Dashboard
                            </a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link' href='artist-orders.php'>
                                <i class='bi bi-card-checklist' style='font-size: 22px;'></i>
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

                <?php if (isset($user)) : ?>
                    My name is <?= $user['name'] ?>.
                    My artist id is <?= $user['id'] ?>.
                <?php else : ?>
                    <p class='nav-link'>
                        <a href='signin.php'>Sign In</a>
                        or
                        <a href='signup.html'>Sign Up</a>
                    </p>
                <?php endif; ?>


                <div class='d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom'>
                    <h1 class='fs-2'>Dashboard</h1>
                    <p class='fs-6 ps-4 space-cadet'>
                        What picture does your recent numbers paint? Get it here.
                    </p>
                </div>

                <hr class='mobile-hide hr' />
                <center>
                    <div class='col-lg-10 col-md-6 p-3'>
                        <div class='row'>
                            <!-- Recent art and gallery orders -->
                            <div class='col-lg-6 col-md-6 p-3'>
                                <div class='card border-dark mb-3'>
                                    <div class='card-header'>
                                        <h2 class='card-title'>
                                            <i class='bi bi-postage-heart-fill imperial-red' style='font-size: 32px;'></i>&nbsp;
                                            Recent Orders
                                        </h2>
                                    </div>
                                    <div class='card-body'>
                                        <p class='card-text'>
                                            <?php
                                            $sql = "SELECT * FROM art_orders
                                            WHERE artist_id = {$user['id']}
                                            ORDER BY id DESC
                                            LIMIT 5";

                                            $result = $mysqli->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                        <div class='row'>
                                            <div class='col-md-2'>
                                                <p class='card-text'>
                                                    <?= 'A' . 10000 + $row['id'] ?>
                                                </p>
                                            </div>
                                            <div class='col-md-6'>
                                                <p class='card-text'>
                                                    <?= $row['piece_title'] ?>
                                                </p>
                                            </div>
                                            <div class='col-md-4'>
                                                <p class='card-text'>
                                                    Kshs. <?= number_format($row['piece_price']) ?>
                                                </p>
                                            </div>
                                        </div>
                                <?php
                                                }
                                            } else {
                                                echo "<p>No recent orders.</p>";
                                            }
                                ?>
                                </p>
                                    </div>

                                    
                                </div>

                                <div class='card border-dark mb-3'>
                                    <div class='card-header'>
                                        <h2 class='card-title'>
                                            <i class='bi bi-ticket-perforated-fill imperial-red' style='font-size: 32px;'></i>&nbsp;
                                            Recent Orders
                                        </h2>
                                    </div>
                                    <div class='card-body'>
                                        <p class='card-text'>
                                            <?php
                                            $sql = "SELECT * FROM gallery_orders
                                            WHERE artist_id = {$user['id']}
                                            ORDER BY id DESC
                                            LIMIT 5";

                                            $result = $mysqli->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                        <div class='row'>
                                            <div class='col-md-2'>
                                                <p class='card-text'>
                                                    <?= 'B' . 10000 + $row['id'] ?>
                                                </p>
                                            </div>
                                            <div class='col-md-6'>
                                                <p class='card-text'>
                                                    <?= $row['gallery_title'] ?>
                                                </p>
                                            </div>
                                            <div class='col-md-4'>
                                                <p class='card-text'>
                                                    Kshs. <?= number_format($row['gallery_fee']) ?>
                                                </p>
                                            </div>
                                        </div>
                                <?php
                                                }
                                            } else {
                                                echo "<p>No recent orders.</p>";
                                            }
                                ?>
                                </p>
                                    </div>

                                    
                                </div>  
                            </div>

                            
                            
                            <!-- Recent posted pieces -->
                            <div class='col-lg-6 col-md-6 p-3'>
                                <div class='card border-dark mb-3'>
                                    <div class='card-header'>
                                        <h2 class='card-title'>
                                            <i class='bi bi-box-seam imperial-red' style='font-size: 32px;'></i>&nbsp;
                                            Recent Pieces
                                        </h2>
                                    </div>
                                    <div class='card-body'>
                                        <p class='card-text'>
                                            <?php
                                            $sql = "SELECT * FROM art
                                            WHERE artist_id = {$user['id']}
                                            ORDER BY id DESC
                                            LIMIT 5
                                            ";

                                            $result = $mysqli->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                        <div class='row'>
                                            <div class='col-md-6'>
                                                <h4 class='card-text'>
                                                    <?= $row['title'] ?>
                                                </h4>
                                            </div>
                                            <div class='col-md-6'>
                                                <p class='card-text'>
                                                    Kshs <?= number_format($row['price']) ?>
                                                </p>
                                            </div>
                                        </div>
                                <?php
                                                }
                                            } else {
                                                echo "<p>No recent pieces.</p>";
                                            }
                                ?>
                                </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </center>



            </main>
            <!-- End of main -->

        </div>
    </div>


</body>

</html>