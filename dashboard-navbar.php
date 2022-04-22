<!-- Start of navigation -->

<!-- Start of md navigation -->
<nav class='navbar mobile-hide'>
    <div class='container'>
        <a href='home.php' class='nav-header mr-5'>
            MONEYLISA <span class='fs-6'>Artist</span>
        </a>
        <ul class='navbar-nav'>
            <li class='nav-item'>
                <!-- Check to see if there is a user session -->
                <?php if (isset($user)) : ?>
                    <p>
                        Hey
                        <a href='client-dashboard.php'>
                            <?= substr($user['name'], 0, strpos($user['name'], ' ')) ?>
                        </a>
                        |
                        <a href='logout.php' class='space-cadet'>Log out</a>
                    </p>

                    <p></p>

                <?php else : ?>

                    <div class='col-lg-12'>
                        <p><a href='signin.php'>Sign In</a> or <a href='signup.html'>Sign Up</a></p>
                    </div>

                <?php endif; ?>
            </li>
        </ul>
    </div>
</nav>
<hr class='mobile-hide hr' />
<!-- End of md navigation -->

<!-- Start of mobile navigation -->
<div class='mobile-show'>
    <div class='container'>
        <a href='home.php' class='nav-header center'>
            <center>MONEYLISA</center>
        </a>
        <hr class='hr-mobile' />

        <ul class='nav justify-content-center'>
            <li class='nav-item'>
                <a href='home.php' class='nav-link'>Galleries</a>
            </li>
            <!-- <li class='nav-item'>
                <a href='/home.php' class='nav-link'>Artists</a>
            </li> -->
            <!-- <li class='nav-item'>
                <a href='/home.php' class='nav-link'>Trending</a>
            </li> -->
            <!-- Check to see if there is a user session -->
            <?php if (isset($user)) : ?>
                <li class='nav-item'>
                    <a href='#' class='nav-link imperial-red'>
                        <?= substr($user['name'], 0, strpos($user['name'], ' ')) ?>
                    </a>
                    <a href='logout.php' class='nav-link space-cadet'>Log out</a>
                </li>
                <li class='nav-item'>
                <?php else : ?>

                    <p class='nav-link'>
                        <a href='signin.php'>Sign In</a>
                        or
                        <a href='signup.html'>Sign Up</a>
                    </p>
                </li>

            <?php endif; ?>
        </ul>
        <hr class='hr-mobile' />
    </div>
</div>

<!-- End of mobile navigation -->

<!-- End of navigation -->
<!-- -------------------------------------------------------------------------------------------- -->