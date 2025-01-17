<?php 
    ob_start();
    session_start();
    if (isset($_SESSION['Username'])) {
        $pageTitle = 'Dashboard';
        include('init.php');

        /* Start Dashboard page */  ?>
        <div class="container">
            <div class="home-stats">
                <h1 class="text-center">Dashboard</h1>
                <div class="row">
                    <div class="col-md-3">
                        <div class="stat st-members">
                            <i class="fa fa-users"></i>
                            <div class="info">
                                Total Members
                                <span>
                                    <a href="members.php"><?php echo countItems('UserID','users') ?></a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat st-pending">
                            <i class="fa fa-user-plus"></i>
                            <div class="info">
                                Pending Members
                                <span>
                                    <a href="members.php?do=Manage&page=Pending"><?php echo checkItem("RegStatus","users",0) ?></a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat st-items">
                            <i class="fa fa-tag"></i>
                            <div class="info">
                                Total Items
                                <span>
                                    <a href="items.php"><?php echo countItems('Item_ID','items') ?></a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat st-comments">
                            <i class="fa fa-comments"></i>
                            <div class="info">
                                Total Comments
                                <span>
                                    <a href="comments.php"><?php echo countItems('c_id','comments') ?></a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="latest">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-users"></i> Latest Registerd Users
                            </div>
                            <div class="card-body">
                                <div class="latest-users">
                                
                                    <?php

                                        $theLatest = getLatest('*','users','UserID');

                                        foreach ($theLatest as $user) {

                                            if ($user['RegStatus'] == 0) {
                                                echo '<li>' . $user['Username'] . 
                                                '<a href="members.php?do=Edit&userid='. $user['UserID'] .'" class= "btn btn-success edit-latest"><i class="fa fa-edit"></i>Edit</a>
                                                <a href="members.php?do=Active&userid= ' . $user['UserID'] . '  " class="btn btn-info active-latest confirm"><i class="fa fa-check"></i> Activate</a>
                                                </li>';

                                            } else {
                                            echo '<li>' . $user['Username'] . 
                                            '
                                            <a href="members.php?do=Edit&userid='. $user['UserID'] .'" class= "btn btn-success edit-latest" ><i class="fa fa-edit"></i>Edit</a>
                                           </li>';
                                            }
                                        }

                                    
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-users"></i> Latest Added Items
                            </div>
                            <div class="card-body">
                                <div class="latest-users">
                                
                                    <?php

                                        $Latest_Items = getLatest('*','items','Item_ID');

                                        foreach ($Latest_Items as $item) {

                                            if ($item['Approve'] == 0) {
                                                echo '<li>' . $item['Name'] . 
                                                '<a href="items.php?do=Edit&itemid='. $item['Item_ID'] .'" class= "btn btn-success edit-latest"><i class="fa fa-edit"></i>Edit</a>
                                                <a href="items.php?do=Approve&itemid= ' . $item['Item_ID'] . '  " class="btn btn-info active-latest confirm"><i class="fa fa-check"></i> Approve</a>
                                                </li>';

                                            } else {
                                            echo '<li>' . $item['Name'] . 
                                            '
                                            <a href="items.php?do=Edit&itemid='. $item['Item_ID'] .'" class= "btn btn-success edit-latest" ><i class="fa fa-edit"></i>Edit</a>
                                           </li>';
                                            }
                                        }

                                    
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<?php    /* End Dashboard page */

        include $tpl . 'footer.php';  

    } else {
        header('location: index.php');
        exit();
    }

ob_end_flush();
?>