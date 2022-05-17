<?php

session_start();

if (isset($_SESSION["user_id"])) {
    // create a database connection 
    $mysqli = require __DIR__ . "/database.php";

    // get the user's email address
    $sql = "SELECT * FROM users
            WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if ($user["isArtist"] == "yes") {
        $_SESSION["isArtist"] = true;
        $_SESSION["user_id"] = $user["id"];


        header("Location: artist-dashboard.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Home</title>

    <!-- Styling imports -->
    <link rel='stylesheet' href='styles/main.css'>
    <link rel='stylesheet' href='styles/utility.css'>

    <!-- Bootstrap Icons imports -->
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css'>

</head>

<body>
    <?php include __DIR__ . "/navbar.php"; ?>

    <!-- Start of main -->
    <main>
        <div class='container'>
            <div class='col-12 bg-imperial-light'>
                <div class='row'>
                    <div class='col-8 p-3 border-right'>
                        <h1 class='cultured'>One stop store for paintings and photographs.</h1>
                        <p class='cultured fs-5'>
                            4 simple steps.
                        </p>
                    </div>

                    <div class='col-4 p-3'>
                        <p class='cultured'>
                            1. Create your account then sign in.
                            <br>
                            <br>
                            2. Browse through the art - paintings and photographs.
                            <br>
                            <br>
                            3.Select a piece.
                            <br>
                            <br>
                            4. Checkout then collect your order.
                        </p>
                    </div>
                </div>
            </div>
            <div class='row'>
                <!-- Render a card for each piece in the art table start with the pieces that are not sold -->

                <?php
                $mysqli = require __DIR__ . '/database.php';

                $fetch_stmt = "SELECT * FROM art ORDER BY created_at DESC";

                $result = $mysqli->query($fetch_stmt);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $artist_id = $row['artist_id'];
                        $piece_id = $row['id'];
                        $piece_title = $row['title'];
                        $artist_name = $row['artist_name'];
                        $piece_story = $row['story'];
                        $piece_price = $row['price'];
                        $piece_dir = $row['img_path'];
                ?>
                        <div class='col-lg-4 col-md-6 col-sm-12 px-3 py-4'>
                            <div class='card'>
                                <!-- check if the piece_id is in the art_orders table -->
                                <?php
                                $mysqli = require __DIR__ . '/database.php';
                                
                                $check_stmt = "SELECT * FROM art_orders WHERE piece_id = {$piece_id}";

                                $check_result = $mysqli->query($check_stmt);

                                if ($check_result->num_rows > 0) {
                                ?>
                                    <img src='<?= $piece_dir ?>' class='card-img-top' alt='<? $piece_title ?>'>
                                    <div class='card-body'>
                                        <div class='row ml-1'>
                                            <div class='col-5 pe-2'>
                                                <a href='art-piece-details.php?id=<?= $piece_id ?>'>
                                                    <h4 class='space-cadet cadet-underlined'><?= $piece_title ?></h4>
                                                </a>
                                            </div>
                                            <div class='col-6'>
                                                <a href='artist-details.php?id=<?= $artist_id ?>' class='plain'>
                                                    <h4 class='card-title manatee'><?= $artist_name ?></h4>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <button class='btn btn-outline-danger btn-sm' disabled>Sold</button>
                                <?php } else { ?>
                                    <img src='<?= $piece_dir ?>' class='card-img-top' alt='<? $piece_title ?>'>
                                    <div class='card-body'>
                                        <div class='row ml-1'>
                                            <div class='col-5 pe-2'>
                                                <a href='art-piece-details.php?id=<?= $piece_id ?>'>
                                                    <h4 class='space-cadet cadet-underlined'><?= $piece_title ?></h4>
                                                </a>
                                            </div>
                                            <div class='col-6'>
                                                <a href='artist-details.php?id=<?= $artist_id ?>' class='plain'>
                                                    <h4 class='card-title manatee'><?= $artist_name ?></h4>
                                                </a>
                                            </div>
                                        </div>
                                        <div class='row ml-1 pt-2'>
                                            <div class='col-12'>
                                                <span class='imperial-red fs-6 bold'>Kshs <?= number_format($piece_price, 2) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<center class='fs-5 mt-6'>Nothing uploaded yet. Come back soon. </center>";
                }
                ?>
            </div>
        </div>

    </main>
    <!-- End of main -->


</body>

</html>