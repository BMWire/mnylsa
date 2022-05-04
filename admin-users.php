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
$sql = "SELECT COUNT(*) AS user_count FROM users";

$user_count_result = $mysqli->query($sql);

$user_count = $user_count_result->fetch_assoc();

// fetch the number of artists from the users table
$sql = "SELECT COUNT(*) AS artist_count FROM users
        WHERE isArtist = 'yes'";

$artist_count_result = $mysqli->query($sql);

$artist_count = $artist_count_result->fetch_assoc();

// fetch the number of admins from the users table
$sql = "SELECT COUNT(*) AS admin_count FROM users
        WHERE isAdmin = 'yes'";

$admin_count_result = $mysqli->query($sql);

$admin_count = $admin_count_result->fetch_assoc();

$enth_count = $user_count['user_count'] - ($artist_count['artist_count'] + $admin_count['admin_count']);
?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Moneylisa Users | <?= $user['name'] ?>
    </title>

    <!-- Styling imports -->
    <link rel='stylesheet' href='styles/main.css'>
    <link rel='stylesheet' href='styles/utility.css'>

    <!-- Bootstrap Icons imports -->
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css'>

    <!-- <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/water.css@2/out/water.css'> -->
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
                            <a class='nav-link active' aria-current='page' href='admin-users.php'>
                                <i class='bi bi-people-fill imperial-red' style='font-size: 22px;'></i>
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
                            <a class='nav-link' href='admin-galleries.php'>
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

                <div class='row'>
                    <div class='col-lg-6 col-md-6 pt-3 pb-2 mb-3'>
                        <h1 class='fs-2'>Users.</h1>
                        <p class='fs-6 ps-4 space-cadet'>
                            All the users having Moneylisa accounts at the moment.
                        </p>
                    </div>
                    <div class='col-lg-6 col-md-6 pt-3 pb-2 mb-3'>
                        <div class='row'>
                            <span class='col-lg-3 badge badge-imperial mr-3'>
                                <?= $user_count['user_count'] ?> <?= $user_count['user_count'] == 1 ? " User" : " Users" ?>
                            </span>
                            <span class='col-lg-3 badge badge-imperial mr-3'>
                                <?= $artist_count['artist_count'] ?> <?= $artist_count['artist_count'] == 1 ? " Artist" : " Artists" ?>
                            </span>
                            <span class='col-lg-3 badge badge-imperial mr-3'>
                                <?= $enth_count ?> <?= $enth_count == 1 ? " Enthusiast" : " Enthusiasts" ?>
                            </span>
                        </div>
                    </div>
                </div>

                <hr class='mobile-hide hr' />

                <!-- Get and display the Users from users table -->
                <div class='table-responsive'>
                    <table class='table table-striped table-sm'>
                        <thead>
                            <tr>
                                <th scope='col'>User Id</th>
                                <th scope='col'>Name</th>
                                <th scope='col'>Email</th>
                                <th scope='col'>Role</th>
                                <th scope='col'>Created At</th>
                                <th scope='col'>Suspend</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // get the details from user table of the pieces made by the logged in user
                            $user_sql = "SELECT * FROM users";

                            $user_result = $mysqli->query($user_sql);

                            while ($user = $user_result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?= 'U00' . $user['id'] ?></td>
                                    <td><?= $user['name'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td>
                                        <?php
                                        if ($user['isArtist'] == 'yes') {
                                            echo 'Artist';
                                        } else if ($user['isAdmin'] == 'yes') {
                                            echo 'Admin';
                                        } else {
                                            echo 'Enthusiast';
                                        }
                                        ?>
                                    </td>
                                    <td><?= date('d M Y, g:i A', strtotime($user['created_at'])) ?></td>
                                    <td>
                                        <?php
                                        if ($user['isCollected'] == 1) {
                                            echo 'Yes';
                                        } else {
                                            // implement button to update isCollected to 1
                                        ?>
                                            <center>
                                                <form action='process-delete-user.php' method='POST'>
                                                    <input type='hidden' name='user_id' value='<?= $user['id'] ?>'>
                                                    <button type='submit' class='btn btn-sm mb-2'>Suspend</button>
                                                </form>
                                            </center>
                                        <?php
                                        }
                                        ?>
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