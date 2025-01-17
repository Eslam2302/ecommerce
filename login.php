<?php include 'init.php'; ?>


<div class="container login-page">
    <h1 class="text-center h1-login">
        <span class="selected" data-class="login-card">Login</span> | <span data-class="signup-card">SignUp</span>
    </h1>
    <div class="div-login d-flex justify-content-center align-items-center">
        <div class="card login-card">
            <div class="card-header text-center">Login To Discover The Best Offers</div>
            <div class="card-body">
                <form action="" class="login d-grid gap-2">
                    <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Type Username">
                    <input class="form-control" type="password" name="password" autocomplete="off" placeholder="Type Password">
                    <input class="btn btn-primary" type="submit" value="Login">
                </form>
            </div>
        </div>
    </div>
    <div class="div-signup d-flex justify-content-center align-items-center">
        <div class="card signup-card">
            <div class="card-header text-center">Register To Discover The Best Offers</div>
            <div class="card-body">
                <form action="" class="signup d-grid gap-2">
                    <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Type Username">
                    <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Type Password">
                    <input class="form-control" type="password" name="password-confirm" autocomplete="new-password" placeholder="Confirm Password">
                    <input class="form-control" type="email" name="email" autocomplete="off" placeholder="Type Your Email">
                    <input class="btn btn-success" type="submit" value="Signup">
                </form>
            </div>
        </div>
    </div>
</div>

<?php include $tpl . 'footer.php'; ?>  