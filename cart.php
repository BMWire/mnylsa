<?php

session_start();

if (isset($_SESSION['user_id'])) {
    // create a database connection 
    $mysqli = require __DIR__ . '/database.php';

    // get the logged in user's id
    $fetch_user_session = "SELECT * FROM users
            WHERE id = {$_SESSION['user_id']}";

    $result = $mysqli->query($fetch_user_session);

    $user = $result->fetch_assoc();
} else {
    header('Location: home.php');
}
?>
<!-- Fetch the details for the piece whose id is in the URL -->
<?php
$fetch_art_session = "SELECT * FROM art WHERE id = {$_GET['id']}";

$result = $mysqli->query($fetch_art_session);

$piece = $result->fetch_assoc();

?>

<!-- Fetch the order id from the art_orders table-->

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
            <span>User Id: <?= $user['id'] ?></span>
            <br />
            <span>User Name: <?= $user['name'] ?></span>
            <br />
            <span>Piece Id: <?= $piece['id'] ?></span>
            <br />
            <span>Piece Title: <?= $piece['title'] ?></span>
            <br />
            <span>Piece Artist: <?= $piece['artist_name'] ?></span>
            <br />
            <span>Piece Artist Id: <?= $piece['artist_id'] ?></span>
            <br />
            <span>Piece Price: <?= $piece['price'] ?></span>

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

            <center class='mt-4'>

                <form action='process-create-art-order.php' method='POST'>
                    <input type='hidden' name='user_id' value='<?= $user['id'] ?>'>
                    <input type='hidden' name='user_name' value='<?= $user['name'] ?>'>
                    <input type='hidden' name='piece_id' value='<?= $piece['id'] ?>'>
                    <input type='hidden' name='piece_title' value='<?= $piece['title'] ?>'>
                    <input type='hidden' name='piece_artist' value='<?= $piece['artist_name'] ?>'>
                    <input type='hidden' name='piece_artist_id' value='<?= $piece['artist_id'] ?>'>
                    <input type='hidden' name='piece_price' value='<?= $piece['price'] ?>'>

                    <!-- Check to see if the user has already submitted the order -->
                    <?php
                    $fetch_order_session = "SELECT * FROM art_orders
                            WHERE piece_id = {$piece['id']}";

                    $result = $mysqli->query($fetch_order_session);

                    if ($result->num_rows > 0) {
                        echo "<p class='text-danger'>An order has already been placed for this piece. There still are lots of awesome art.</p>";

                        // Take the user back to the art page or to their orders page
                        echo "<a href='home.php' class='btn btn-lg btn-imperial'>Back to Art</a>";
                    } else {
                        echo "<button type='submit' class='btn btn-lg btn-imperial'>Create Order</button>";
                    }
                    ?>


                </form>

            </center>

        </div>


    </main>
    <!-- End of main -->


</body>

</html>