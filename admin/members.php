<?php 

    session_start();
    if (isset($_SESSION['Username'])) {
        $pageTitle = 'Members';
        include('init.php');

        $do = isset($_GET['do']) ? $_GET['do'] :'Manage';

        // Start manage page
        if ($do == 'Manage') {  

            $query = '';

            if (isset( $_GET['page']) && $_GET['page'] == 'Pending' ) {
                $query = 'And RegStatus = 0';
            }
            
            $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query");

            $stmt->execute();
            
            $rows = $stmt->fetchAll();
            
            ?>
           
            <h1 class="text-center">Manage Member Page</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class=" main-table table text-center">
                        <tr>
                            <th>#ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Full Name</th>
                            <th>Registerd Date</th>
                            <th>Control</th>
                        </tr>

                        <?php 
                        
                            foreach ($rows as $row) {

                                echo "<tr>";
                                    echo "<td>" . $row['UserID'] . "</td>";
                                    echo "<td>" . $row['Username'] . "</td>";
                                    echo "<td>" . $row['Email'] . "</td>";
                                    echo "<td>" . $row['FullName'] . "</td>";
                                    echo "<td>" . $row['Date'] . "</td>";
                                    echo "<td>
                                            <a href='members.php?do=Edit&userid= " . $row['UserID'] . "  ' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                                            <a href='members.php?do=Delete&userid= " . $row['UserID'] . "  ' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
                                     
                                            if ($row['RegStatus'] == 0) {
                                                echo     "<a href='members.php?do=Active&userid= " . $row['UserID'] . "  ' class='btn btn-info confirm'><i class='fa fa-check'></i> Activate</a>";

                                            }
                                     
                                        echo "</td>";
                                echo "</tr>";
                            }
                        
                        ?>

                    </table>
                </div>
                <a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Member</a>
            </div>

 <?php  } elseif ($do == 'Add') { ?>

            <div class="container">
                <div class="row edit-profile-card ">
                    <div class="col-2"></div>
                    <div class="card col-8">
                        <div class="card-header text-center">
                            Add New Member
                        </div>
                        <div class="card-body">
                            <form action="?do=insert" method="POST">
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Username</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                    <input type="password" class="password form-control" name="password" placeholder="Password" required autocomplete="new-password">
                                    <i class="show-pass fa fa-eye fa-2x"></i>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Fullname</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control" name="full" placeholder="FullName" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Member</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-2"></div>
                </div>
            </div>

        <?php
        } elseif ($do == 'insert') { // Insert User
            

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {  // Update member

                echo "<h1 class='text-center'>Insert Member</h1>";
                echo "<div class='container'>";
                // Get variables from the form

                $user = $_POST['username'];
                $pass = $_POST['password'];
                $email = $_POST['email'];
                $name = $_POST['full'];

                $hashPass = sha1($_POST['password']);

                // Valdation

                $formErrors = array();

                if (strlen($user) < 4) {
                    $formErrors[] = 'Username Cant Be less than 4 Char';
                }
                if (strlen($user) > 20) {
                    $formErrors[] = 'Username Cant Be More than 4 Char';
                }
                if (empty($user)) {
                    $formErrors[] = 'Username Cant Be Empty';
                }
                if (empty($pass)) {
                    $formErrors[] = 'Password Cant Be Empty';
                }
                if (empty($email)) {
                    $formErrors[] = 'Email Cant Be Empty';
                }
                if (empty($name)) {
                    $formErrors[] = 'FullName Cant Be Empty';
                }

                // Loop into Error Aray
                foreach($formErrors as $error) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }

                // Check if there no error then update 

                if (empty($formErrors)) {

                    // Check if user is exist

                    $check = checkItem("Username","users",$user);

                    if ($check == 1) {

                        $theMsg =  '<div class="alert alert-danger">Sorry This User Is Exist</div>';
                        redirectHome($theMsg,'back');

                    } else {

                        // Insert User into Database

                        $stmt = $con->prepare("INSERT INTO 
                                                        users(Username, Password,Email,FullName,RegStatus,Date)
                                                        VALUES(:zuser,:zpass,:zmail,:zname,1,now())
                                                        ");

                        $stmt->execute(array(
                            'zuser' => $user,
                            'zpass'=> $hashPass,
                            'zmail'=> $email,
                            'zname'=> $name
                        ));

                        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Updated</div>';
                        redirectHome($theMsg,'members');

                    }
                }

            } else{

                $theMsg =  '<div class="alert alert-danger">Sorry You Cant Browse This Page Direct</div>';
                redirectHome($theMsg,'back');

            }

            echo '</div>';

        } elseif ($do == 'Edit') {  // Edit Page 

            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0; 

            $stmt = $con->prepare(" SELECT * FROM users WHERE UserID = ? Limit 1");
            $stmt->execute(array( $userid));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();

            if ($count > 0) { 

            ?>

                <div class="container">
                    <div class="row edit-profile-card ">
                        <div class="col-2"></div>
                        <div class="card col-8">
                            <div class="card-header text-center">
                                Edit Profile
                            </div>
                            <div class="card-body">
                                <form action="?do=Update" method="POST">
                                    <input type="hidden" name="userid" value="<?php echo $userid ?>">
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Username</label>
                                        <div class="col-sm-10">
                                        <input type="text" class="form-control" name="username" value="<?php echo $row['Username']; ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                                        <div class="col-sm-10">
                                        <input type="hidden" name="oldpassword" value="<?php echo $row['Password']; ?>">
                                        <input type="password" class="form-control" name="newpassword" autocomplete="new-password">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                        <input type="email" class="form-control" name="email" value="<?php echo $row['Email']; ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Fullname</label>
                                        <div class="col-sm-10">
                                        <input type="text" class="form-control" name="full" value="<?php echo $row['FullName']; ?>">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-2"></div>
                    </div>
                </div>
            <?php
            // End of Count > 0 
            } else {
                $theMsg = '<div class="alert alert-danger">Theres No Such ID</div>';
                redirectHome($theMsg, 'members');
            }
           // End Of do == Edit 
        } elseif ($do == 'Update') { // Update User


            if ($_SERVER['REQUEST_METHOD'] == 'POST') {  // Update member
                echo "<h1 class='text-center'>Update Member</h1>";
                echo "<div class='container'>";

                // Get variables from the form

                $id = $_POST['userid'];
                $user = $_POST['username'];
                $email = $_POST['email'];
                $name = $_POST['full'];
                

                // Password Trick

                $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']) ;

                // Valdation

                $formErrors = array();

                if (strlen($user) < 4) {
                    $formErrors[] = '>Username Cant Be less than 4 Char';
                }
                if (strlen($user) > 20) {
                    $formErrors[] = '>Username Cant Be More than 4 Char';
                }
                if (empty($user)) {
                    $formErrors[] = 'Username Cant Be Empty</div>';
                }
                if (empty($email)) {
                    $formErrors[] = 'Email Cant Be Empty';
                }
                if (empty($name)) {
                    $formErrors[] = 'FullName Cant Be Empty';
                }

                // Loop into Error Aray
                foreach($formErrors as $error) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }

                // Check if there no error then update 

                if (empty($formErrors)) {

                    // check if user is exist

                    $check = checkItem("Username","users",$user);

                    if ($check == 1) {

                        $theMsg = '<div class="alert alert-danger">This User Is Exist</div>';
                        redirectHome($theMsg, 'back');

                    } else {

                        // Update Database with the info

                        $stmt = $con->prepare('UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ?');
                        $stmt->execute(array($user, $email, $name, $pass, $id));

                        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Updated</div>';
                        redirectHome($theMsg, 'members');
                    }
                    
                }

            } else{
                $theMsg =  '<div class="alert alert-danger">Sorry You Cant Browse This Page Direct</div>';
                redirectHome($theMsg,'back');
            }

            echo '</div>';

        // End Update do==update

        } elseif ($do == 'Delete'){

            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0; 

            $stmt = $con->prepare(" SELECT * FROM users WHERE UserID = ? Limit 1");
            $stmt->execute(array( $userid));
            $count = $stmt->rowCount();

            echo "<div class='container'>";

            if ($count > 0) { 

                $stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser");

                $stmt->bindParam("zuser",$userid);

                $stmt->execute();

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Deleted</div>';
                redirectHome($theMsg , 'members');

            } else {
                $theMsg = '<div class="alert alert-danger">This User Is No Exist</div>';
                redirectHome($theMsg , 'back');
            }
            echo '</div>';
            
 // End of Delete 


        } elseif ($do == 'Active'){

            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0; 

            $stmt = $con->prepare(" SELECT UserID FROM users WHERE UserID = ? Limit 1");
            $stmt->execute(array( $userid));
            $count = $stmt->rowCount();

            echo "<div class='container'>";

            if ($count > 0) { 

                $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");

                $stmt->execute(array( $userid));
                
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' User Activated</div>';
                redirectHome($theMsg , 'dashboard');

            } else {
                $theMsg = '<div class="alert alert-danger">This User Is No Exist</div>';
                redirectHome($theMsg , 'back');
            }
            
            echo "</div>";

        } // End of Active 


        include $tpl . 'footer.php';  

    } else {
        header('location: index.php');
        exit();
    }


?>