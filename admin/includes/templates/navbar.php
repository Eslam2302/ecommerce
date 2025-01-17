<nav class="navbar navbar-expand-lg bg-body-tertiary navbar-inverse bg-dark border-bottom border-body" data-bs-theme="dark">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php"><?php echo lang('Home') ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="app-nav">
        <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                <a class="nav-link" aria-current="page" href="categories.php"><?php echo lang('Categories'); ?></a>
                <a class="nav-link" aria-current="page" href="items.php"><?php echo lang('Items'); ?></a>
                <a class="nav-link" aria-current="page" href="members.php"><?php echo lang('Members'); ?></a>
                <a class="nav-link" aria-current="page" href="comments.php"><?php echo lang('Comments'); ?></a>
                <a class="nav-link" aria-current="page" href="#"><?php echo lang('Statistics'); ?></a>
                <a class="nav-link" aria-current="page" href="#"><?php echo lang('Logs'); ?></a>

            </li>
        </ul>
        <ul class="navbar-nav  navbar-nav-scroll" style="--bs-scroll-height: 100px;">
            <li class="nav-item d-flex dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Eslam
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="../index.php">Visit Shop</a></li>
                <li><a class="dropdown-item" href="members.php?do=Edit&userid=<?php echo $_SESSION['ID'] ?>"><?php echo lang('Edit') . ' ' . lang('Profile'); ?></a></li>
                <li><a class="dropdown-item" href="#"><?php echo lang('Setting'); ?></a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php"> <?php echo lang('Logout'); ?> </a></li>
            </ul>
            </li>
        </ul>
    </div>
  </div>
</nav>