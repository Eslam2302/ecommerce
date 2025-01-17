<?php
    session_start();
    $noNavbar = '';
    $pageTitle = 'Login';
    if (isset($_SESSION['Username'])){                      // IF user already loged in and session stored
        header('location: dashboard.php');          // Redirect to dashboard page for admin 
    }
    include 'init.php';


    // Check if user coming from http post request

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $username   =   $_POST['user'];
        $password   =   $_POST['pass'];
        $hashedPass =   sha1($password);

        // Check if user exist in database

        $stmt = $con->prepare(" SELECT
                                            UserID , Username , Password
                                        FROM
                                            users
                                        WHERE
                                            Username = ?
                                        AND
                                            Password = ?
                                        AND
                                            GroupID = 1 
                                        Limit 1");
        $stmt->execute(array($username,$hashedPass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($count > 0) {                                       // If I find user in database

            $_SESSION['Username'] = $username;                  // Register Session name
            $_SESSION['ID'] = $row['UserID'];                  // Register Session ID
            header('location: dashboard.php');          // Redirect to dashboard page for admin 
            exit();                                             // Close any thing after redirect

        }

    }



?>

    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="login">
        <h4 class="text-center">Admin Login</h4>
        <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off">
        <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password">
        <input class="btn btn-primary col-12" type="Submit" value="Login">
    </form>


<?php
    include $tpl . 'footer.php';  
?>