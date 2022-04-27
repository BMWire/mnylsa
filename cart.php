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

/* Get the id of the piece from the session */
$_SESSION['piece_id'] = $piece['id'];
$piece_id = $_SESSION['piece_id'];
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title> <?= substr($user['name'], 0, strpos($user['name'], ' ')) . '\'s Art bag' ?> </title>

    <!-- Styling imports -->
    <link rel='stylesheet' href='styles/main.css'>
    <link rel='stylesheet' href='styles/utility.css'>

    <!-- Bootstrap Icons imports -->
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css'>

    <!-- <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/water.css@2/out/water.css'> -->
</head>

<body>
    <?php include __DIR__ . '/navbar.php'; ?>

    <!-- Start of main -->
    <main>
        <div class='container'>

            <div class='card card-short mt-6'>
                <div class='row'>
                    <!-- Render the image for the piece -->
                    <div class='col-lg-4 col-md-8 col-sm-12'>
                        <img src='<?= $piece['img_path'] ?>' style='max-height: 20vh !important;' alt='<?= $piece['title'] ?>' class='p-4'>
                    </div>

                    <!-- Render the details for the piece -->
                    <div class='col-lg-8 col-md-4 col-sm-12 ps-3 py-4'>
                        <div class='card-body'>
                            <div class='row'>
                                <div class='col-5 col-md-5 col-sm-12'>
                                    <h2 class='manatee'><?= $piece['title'] ?></h2>
                                </div>
                                <div class='col-lg-6 col-md-6 col-sm-12'>
                                    <h2 class=''><?= $piece['artist_name'] ?></h2>
                                </div>
                            </div>
                            <span class='card-text fs-5'>
                                Ksh <?= number_format($piece['price'], 2) ?></span>
                        </div>

                    </div>
                </div>
            </div>


            <?php if ($user['isArtist'] == 'yes') : ?>
                <center class='mt-4>
                    <a href=' piece-orders.php?id=<?= $piece['id '] ?>'>
                    <button class='btn btn-lg btn-imperial mt-6'>
                        View Orders
                    </button>
                    </a>
                </center>

            <?php else : ?>
                <center class='mt-4'>
                    <!-- <a href='order.php?id=<?= $piece['id'] ?>'> -->
                    <form action='process-create-order.php' name='create_order' method='POST'>
                        <button class='btn btn-lg btn-imperial mt-6'>
                            Create Order
                        </button>
                    </form>
                    <!-- </a> -->
                </center>
            <?php endif; ?>

        </div>


    </main>
    <!-- End of main -->


</body>

</html>