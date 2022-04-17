<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf(
        "SELECT * FROM users
                    WHERE email = '%s'",
        $mysqli->real_escape_string($_POST["email"])
    );

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if ($user) {

        if (password_verify($_POST["password"], $user["password_hash"])) {

            session_start();

            session_regenerate_id();

            $_SESSION["user_id"] = $user["id"];

            header("Location: home.php");
            exit;
        }
    }

    $is_invalid = true;
}

?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moneylisa | Sign In</title>

    <!-- Styling imports -->
    <link rel='stylesheet' href='styles/main.css'>
    <link rel='stylesheet' href='styles/utility.css'>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css"> -->
</head>

<body>

    <main>

        <div class='row'>
            <!-- Image div -->
            <div class='col-lg-6 col-sm-12 col-md-6 mobile-hide'>
                <div class='container-fluid'>
                    <img class='img-lg' style='height: 90vh;' src='assets/images/paddleboard.jpg' alt='Welcome back'>
                    <p class='manatee'> Levi Vaagenes &nbsp; - &nbsp;
                        <a class='inline-link' href='https://www.pexels.com/photo/woman-paddleboarding-on-lake-at-sunset-11504431/'>
                            Paddleboarding
                        </a>
                    </p>
                </div>
            </div>

            <!-- Form div -->
            <div class='col-lg-6 col-sm-12 col-md-6'>
                <div class='header'>
                    <h1>MoneyLisa</h1>
                </div>
                <h2>Welcome back</h2>

                <?php if ($is_invalid) : ?>
                    <em class='imperial-red mb-2'>Invalid login</em>
                <?php endif; ?>

                <form method="post">
                    <div class='col-lg-6 mb-4'>
                        <label for="email">Email</label>
                        <input class='form-control mb-2' type="email" name="email" id="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
                    </div>

                    <div class='col-lg-6 col-sm-12 col-md-6 mb-4'>
                        <label for="password">Password</label>
                        <input class='form-control mb-2' type="password" name="password" id="password">
                    </div>

                    <p>
                        Don't have an account yet?
                        <a class='inline-link' href='signup.html'>
                            Create an account
                        </a>
                    </p>

                    <button class='btn btn-lg btn-imperial mt-6'>
                        Sign In
                    </button>
                </form>
            </div>
        </div>
    </main>
</body>

</html>