<?php
session_start();
$pageTitle = 'Login';

if (isset($_SESSION['user'])){                      // IF user already loged in and session stored
    header('location: index.php');          // Redirect to Home page for user 
}

include 'init.php'; 

// Check if user coming from http post request

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['login'])){

        $username   =   $_POST['username'];
        $password   =   $_POST['password'];
        $hashedPass =   sha1($password);

        // Check if user exist in database

        $stmt = $con->prepare(" SELECT
                                            Username , Password
                                        FROM
                                            users
                                        WHERE
                                            Username = ?
                                        AND
                                            Password = ?
                                    ");
        $stmt->execute(array($username,$hashedPass));
        $count = $stmt->rowCount();

        if ($count > 0) {                                       // If I find user in database

            $_SESSION['user'] = $username;                  // Register Session name
            header('location: index.php');          // Redirect to dashboard page for admin 
            exit();                                             // Close any thing after redirect

        }
    } else {

        $formErrors = array();

        $username   =   $_POST['username'];
        $password   =   $_POST['password'];
        $password2  =   $_POST['password-confirm'];
        $email      =   $_POST['email'];


        // Filter username if isset errors

        if (isset($_POST['username'])) {

            $filterdUser = filter_var($_POST['username'], FILTER_SANITIZE_ADD_SLASHES);

            if (strlen($filterdUser) < 4) {

                $formErrors[] = 'Username Must Be Larger Than 4 Char';

            }

        }

        // Filter password if isset errors

        if (isset($_POST['password']) && isset($_POST['password-confirm']) ) {

            if (empty($password)) {

                $formErrors[] = 'Password Cant Be Empty';

            }

            $pass1 = sha1($_POST['password']);
            $pass2 = sha1($_POST['password-confirm']);

            if ($pass1 !== $pass2) {

                $formErrors[] = 'Sorry Password Is Not Match';

            }


        }

        // Filter email if isset errors

        if (isset($_POST['email'])) {

            $filterdEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

            if (filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true) {

                $formErrors[] = 'This Email Is Not Valid';

            }

        }

        // Check if there no error then insert user in database 

        if (empty($formErrors)) {

            // Check if user is exist

            $check = checkItem("Username","users",$_POST['username']);

            if ($check == 1) {

                $formErrors[] =  '<div class="alert alert-danger">Sorry This User Is Exist</div>';

            } else {

                // Insert User into Database

                $stmt = $con->prepare("INSERT INTO 
                                                users(Username, Password,Email,RegStatus,Date)
                                                VALUES(:zuser,:zpass,:zmail,0,now())
                                                ");

                $stmt->execute(array(
                    'zuser' => $username,
                    'zpass'=> sha1($password),
                    'zmail'=> $email,
                ));


                    $_SESSION['user'] = $username;                  // Register Session name
                    header('location: index.php');          // Redirect to dashboard page
                    exit();                                         // Close any thing after redirect
        
            }
        }

    }

}



 ?>


<div class="container login-page">
    <h1 class="text-center h1-login">
        <span class="selected" data-class="login-card">Login</span> | <span data-class="signup-card">SignUp</span>
    </h1>

    <!-- Start Login Form -->
    <div class="div-login d-flex justify-content-center align-items-center">
        <div class="card login-card">
            <div class="card-header text-center">Login To Discover The Best Offers</div>
            <div class="card-body">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="login d-grid gap-2">
                    <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Type Username">
                    <input class="form-control" type="password" name="password" autocomplete="off" placeholder="Type Password">
                    <input class="btn btn-primary" name="login" type="submit" value="Login">
                </form>
            </div>
        </div>
    </div>
    <!-- End Login Form -->

    <!-- Start Signup Form -->
    <div class="div-signup d-flex justify-content-center align-items-center">
        <div class="card signup-card">
            <div class="card-header text-center">Register To Discover The Best Offers</div>
            <div class="card-body">
                <form class="signup d-grid gap-2" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                    <input 
                    class="form-control" type="text" name="username" 
                    autocomplete="off" placeholder="Type Username"
                    pattern=".{4,20}" title="User Name Must Be >= 4 Char"
                    />
                    <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Type Password">
                    <input class="form-control" type="password" name="password-confirm" autocomplete="new-password" placeholder="Confirm Password">
                    <input class="form-control" type="email" name="email" autocomplete="off" placeholder="Type Your Email">
                    <input class="btn btn-success" name="signup" type="submit" value="Signup">
                </form>
            </div>
        </div>
    </div>
    <!-- End Signup Form -->

    <div class="the-errors text-center">
        <?php 

        if (!empty($formErrors)) {

            foreach($formErrors as $error) {

                echo $error . '<br>';

            }

        }

        ?>
    </div>

</div>


<?php include $tpl . 'footer.php'; ?>  