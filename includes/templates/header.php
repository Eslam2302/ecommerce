<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php getTitle() ?></title>
        <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $css; ?>all.min.css">
        <link rel="stylesheet" href="<?php echo $css; ?>front.css">
    </head>
    <body>
        <div class="upper-bar">
            <div class="container upper-bar-cont">
                <?php 
                    if (isset($_SESSION['user'])) { ?>
                        
                        <img class="my-image img-responsive img-thumbnail center-block rounded-circle" src="mcro.png" alt="image">
                        <div class="btn-group dropdown my-info">
                            <div class="btn dropdown-toggle text" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $sessionUser; ?>
                            </div>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
                                <li><a class="dropdown-item" href="newad.php">New Item</a></li>
                                <li><a class="dropdown-item" href="profile.php#my-ads">My Items</a></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </div>

                        <?php
                    } else {

                ?>
                <a href="login.php" class="nav-container">
                    <span class="btn btn-primary nav-login">Login/Signup</span>
                </a>
                <?php } ?>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg bg-body-tertiary navbar-inverse bg-dark border-bottom border-body" data-bs-theme="dark">
            <div class="container">
                <a class="navbar-brand" href="index.php">Homepage</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="app-nav">
                    <ul class=" me-auto my-2 my-lg-0"></ul>
                    <ul class="navbar-nav navbar-nav-scroll" style="--bs-scroll-height: 100px;">

                        <?php 
                            foreach(getAllFrom('*','categories','ID','','','ASC') as $cat) {
                                echo '<li><a class="nav-link" href="categories.php?pageid=' . $cat['ID'] . '"/>' . $cat['Name'] . '</a></li>';
                            }
                        ?>

                    </ul>
                </div>
            </div>
    </nav>
            