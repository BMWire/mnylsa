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
<!-- Fetch the details for the piece whose id is in the URL -->
<?php
$mysqli = require __DIR__ . '/database.php';

$fetch_stmt = "SELECT * FROM art WHERE id = {$_GET['id']}";

$result = $mysqli->query($fetch_stmt);

$piece = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title> <?= $piece['title'] ?> | <?= $piece['artist_name'] ?> </title>

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

    <!-- Start of main -->
    <main>
        <div class='container-flex'>
            <div class='card card-tall mt-6'>
                <div class='row'>
                    <!-- Render the image for the piece -->
                    <div class='col-lg-7 col-md-8 col-sm-12'>
                        <center>
                            <img src='<?= $piece['img_path'] ?>' style='max-height: 90vh;' alt='<?= $piece['title'] ?>' class='card-img-lg pt-5'>
                        </center>
                    </div>

                    <!-- Render the details for the piece -->
                    <div class='col-lg-5 col-md-4 col-sm-12 py-3'>
                        <div class='card-body'>
                            <div class='row'>
                                <div class='col-5 col-md-5 col-sm-12'>
                                    <h1 class=''><?= $piece['title'] ?></h1>
                                </div>
                                <div class='col-lg-6 col-md-6 col-sm-12'>
                                    <a target='_blank' href='artist-portfolio.php?id=<?= $piece['artist_id'] ?>' class='imperial-red'>
                                        <h3 class='pt-3'><?= $piece['artist_name'] ?></h3>
                                    </a>
                                </div>
                            </div>

                            <p class='card-text text-spacing fs-5'>
                                <?= $piece['story'] ?>
                            </p>

                            <span class='card-text fs-3'>Ksh <?= number_format($piece['price'], 2) ?></span>
                        </div>

                        <?php if ($user['isArtist'] == 'yes') : ?>
                            <center>
                                <a class='btn btn-lg btn-imperial btn-disabled disabled' href='artist-edit-piece.php?id=<?= $piece['id'] ?>'>
                                    Edit Piece
                                </a>
                                Coming Soon!
                            </center>

                        <?php else : ?>
                            <center>
                                <!-- Check if the user already had the piece in art_orders and redirect them elsewhere -->
                                <?php
                                $check_stmt = "SELECT * FROM art_orders
                                                WHERE piece_id = {$piece['id']}";

                                $result = $mysqli->query($check_stmt);

                                if ($result->num_rows > 0) {
                                    echo "Piece has been sold";
                                    echo "<br>";
                                    echo "<br>";
                                    echo "More by <a href='artist-portfolio.php?id={$piece['artist_id']}'>{$piece['artist_name']}</a>";
                                } else {
                                    echo "<a href='cart.php?id={$piece['id']}'>
                                            <button class='btn btn-lg btn-imperial'>
                                                Purchase Piece
                                            </button>
                                        </a>";
                                }
                                ?>
                            </center>

                        <?php endif; ?>

                    </div>
                </div>
            </div>

    </main>
    <!-- End of main -->


</body>

</html>