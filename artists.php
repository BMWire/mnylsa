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
    header('Location: signin.php');
}

?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Artists | Moneylisa</title>

    <!-- Styling imports -->
    <link rel='stylesheet' href='styles/main.css'>
    <link rel='stylesheet' href='styles/utility.css'>

    <!-- Bootstrap Icons imports -->
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css'>

</head>

<body class='background-cultured'>
    <?php include __DIR__ . '/navbar.php'; ?>

    <!-- Start of main -->
    <main>
        <div class='container-cart'>
            <div class='row p-2'>

                <!-- Fetch all the artist record entries that have entries in the artist_details page -->
                <!-- Render a card for each gallery -->
                <?php
                $mysqli = require __DIR__ . '/database.php';

                $fetch_stmt = "SELECT * FROM artist_details ORDER BY artist_name ASC";

                $result = $mysqli->query($fetch_stmt);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $artist_id = $row['artist_id'];
                        $artist_name = $row['artist_name'];
                        $artist_county = $row['county'];
                        $profile_image = $row['profile_image'];
                ?>
                            <div class='col-lg-6 col-md-12 p-3'>
                                <div class='card mb-3'>
                                    <div class='row'>
                                        <div class='col-md-4'>
                                            <img src='<?= $profile_image ?>' class='card-img-top' alt='<? $artist_name ?>'>
                                        </div>
                                        <div class='col-md-8 px-5'>
                                            <div class='card-body'>
                                                <h3 class='space-cadet cadet-underlined'><?= $artist_name ?></h3>
                                                <p class='card-text'>
                                                    <i class='bi bi-geo-fill manatee' style='font-size:22px;'></i>
                                                    <?= $artist_county ?>
                                                </p>
                                                <center>
                                                    <a href='artist-portfolio.php?id=<?= $artist_id ?>' class='btn btn-imperial'>
                                                        View portfolio
                                                    </a>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                <?php
                    }
                } else {
                    echo "<center class='fs-5 mt-6 imperial-red'>No galleries found. Come back later. </center>";
                }
                ?>

            </div>
        </div>
    </main>
    <!-- End of main -->


</body>

</html>