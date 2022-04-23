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

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css"> -->
</head>

<body>
    <?php include __DIR__ . "/navbar.php"; ?>

    <!-- Start of main -->
    <main>
        <div class='container'>
            
            <?php if (isset($user)) : ?>
                My name is <?= $user['name'] ?>.
                My user id is <?= $user['id'] ?>.
            <?php endif; ?>

            <div class='row'>
                <div class='col-lg-4 col-md-6 col-sm-12 px-3 py-4'>
                    <div class='card'>
                        <img src='assets/art/american-gothic-grant.webp' class='card-img-top' alt='American Gothic Grant Wood'>
                        <div class='card-body'>
                            <div class='row ml-1'>
                                <div class='col-5'>
                                    <a href='/art-page.php'>
                                        <h4 class='space-cadet cadet-underlined'>
                                            American Gothic
                                        </h4>
                                    </a>
                                </div>
                                <div class='col-4'>
                                    <a href='/artist-page.php' class='plain'>
                                        <h4 class='card-title manatee'>Grant Wood</h4>
                                    </a>
                                </div>
                            </div>
                            <div class='row ml-1'>
                                <div class='col-6'>
                                    <i class='bi bi-palette-fill manatee ml-1'></i>
                                    <span class='space-cadet fs-6'>53 palettes</span>
                                </div>
                                <div class='col-6'>
                                    <span class='imperial-red fs-6 bold'>Ksh. 30, 000</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class='col-lg-4 col-md-6 col-sm-12 px-3 py-4'>
                    <div class='card'>
                        <img src="assets/art/grevy's-zebra-warhol.webp" class='card-img-top' alt="Grevy's Zebra Andy Warhol">
                        <div class='card-body'>
                            <div class='row ml-1'>
                                <div class='col-5'>
                                    <a href='/art/grevys-zebra.php'>
                                        <h4 class='space-cadet cadet-underlined'>
                                            Grevy's Zebra
                                        </h4>
                                    </a>
                                </div>
                                <div class='col-4'>
                                    <a href='/artist-page.php' class='plain'>
                                        <h4 class='card-title manatee'>Andy Warhol</h4>
                                    </a>
                                </div>
                            </div>
                            <div class='row ml-1'>
                                <div class='col-6'>
                                    <i class='bi bi-palette-fill manatee ml-1'></i>
                                    <span class='space-cadet fs-6'>109 palettes</span>
                                </div>
                                <div class='col-6'>
                                    <span class='imperial-red fs-6 bold'>Ksh. 50, 000</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class='col-lg-4 col-md-6 col-sm-12 px-3 py-4'>
                    <div class='card'>
                        <img src='assets/art/soup-cans-larger-warhol.jpg' class='card-img-top' alt='Soup Cans Andy Warhol'>
                        <div class='card-body'>
                            <div class='row ml-1'>
                                <div class='col-4'>
                                    <a href='/art/soup-cans-warhol.php'>
                                        <h4 class='space-cadet cadet-underlined'>
                                            Soup Cans
                                        </h4>
                                    </a>
                                </div>
                                <div class='col-4'>
                                    <a href='/artist-page.php' class='plain'>
                                        <h4 class='card-title manatee'>Andy Warhol</h4>
                                    </a>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-6'>
                                    <i class='bi bi-palette-fill manatee ml-1'></i>
                                    <span class='space-cadet fs-6'>23 palettes</span>
                                </div>
                                <div class='col-6'>
                                    <span class='imperial-red fs-6 bold'>Ksh. 100, 000</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class='col-lg-12 col-md-12 col-sm-12 px-3 py-4'>
                <div class='card'>
                    <div class='row'>
                        <div class='col-lg-8 col-md-8 col-sm-12'>
                            <img src='assets/art/macro-bubble-ashley-smith.jpg' class='card-img-top' alt='Macro Bubble Ashley Smith'>
                        </div>
                        <div class='col-lg-4 col-md-4 col-sm-12'>
                            <div class='card-body'>
                                <span class='badge badge-imperial'>
                                    Piece of the day
                                </span>
                                <div class='row ml-1'>
                                    <div class='col-7'>
                                        <a href='/art/macro-bubble'>
                                            <h4 class='space-cadet cadet-underlined'>
                                                Macro Bubble
                                            </h4>
                                        </a>
                                    </div>
                                    <div class='col-5'>
                                        <a href='/artist-page.php' class='plain'>
                                            <h3 class='card-title manatee'>Ashley Smith</h3>
                                        </a>
                                    </div>
                                </div>
                                <p class='card-text'>
                                    This is a piece of art that Ashley Smith has created for the MoneyLisa gallery.
                                    She tries to depict the beauty of the world in a way that is not seen by most.
                                    The piece is a macro bubble that is made of a transparent plastic.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <!-- End of main -->


</body>

</html>