<?php 
    session_start();
    $pageTitle = 'Profile';

    include 'init.php';

    if (isset($_SESSION['user'])) {

        $getUser = $con->prepare("SELECT * FROM users WHERE Username = ?");

        $getUser->execute(array($sessionUser));

        $info = $getUser->fetch();

        
?>

<h1 class="text-center">My Profile</h1>

<div class="information block">
    <div class="container">
        <div class="card">
            <div class="card-header text-bg-primary mb-3">My Information</div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li>
                        <i class="fa-solid fa-unlock"></i>
                        <span>Login Name:</span> <?php echo $info['Username']; ?> 
                    </li>
                    <li>
                        <i class="fa-solid fa-envelope"></i>
                        <span>Email:</span> <?php echo $info['Email']; ?> 
                    </li>
                    <li>
                        <i class="fa-solid fa-user"></i>
                        <span>Full Name:</span> <?php echo $info['FullName']; ?> 
                    </li>
                    <li>
                        <i class="fa-solid fa-calendar"></i>
                        <span>Registered Date:</span> <?php echo $info['Date']; ?> 
                    </li>
                    <li>
                        <i class="fa-solid fa-tags"></i>
                        <span>Favourite Category:</span> 
                    </li>
                </ul>
                <a href="#" class="btn my-btn">Edit Information</a>
            </div>
        </div>
    </div>
</div>

<div id="my-ads" class="my-ads block">
    <div class="container">
        <div class="card">
            <div class="card-header text-bg-primary mb-3">Latest Ads</div>
            <div class="card-body">
                    <?php
                    if (!empty(getitems('Member_ID' , $info['UserID']))) {
                        echo '<div class="row">';
                            foreach(getitems('Member_ID' , $info['UserID'],1) as $item) {
                                echo '<div class="col-sm-6 col-md-3 col-lg-3 big-box>">';
                                    echo '<div class="thumbnail item-box">';
                                        // IF The item Is Not Approved
                                        if($item['Approve'] == 0) { echo '<div class="not-approved-item">Waiting Approval</div>'; }
                                        echo '<span class="price-tag">' . '$' . $item['Price'] . '</span>';
                                        echo '<img src="mcro.png" alt="image" class="img-fluid">';
                                        echo '<div class="caption">';
                                            echo '<h3><a href="items.php?itemid=' . $item['Item_ID'] . '">' . $item['Name'] . '</a></h3>';
                                            echo '<p>' . $item['Description'] . '</p>';
                                            echo '<div class="date">' . $item['Add_Date'] . '</div>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                        }
                        echo '</div>';
                    } else {
                        echo 'There Is No Ads To Show, , Create <a href="newad.php">New Ad</a>';
                    }
                    ?>
            </div>
        </div>
    </div>
</div>

<div class="my-comments block">
    <div class="container">
        <div class="card">
            <div class="card-header text-bg-primary mb-3">Latest Comments</div>
            <div class="card-body">
                <?php 

                $stmt = $con->prepare("SELECT comment From comments WHERE user_id = ?");

                $stmt->execute(array($info['UserID']));

                $comments = $stmt->fetchAll();

                if (!empty($comments)) {

                    foreach ($comments as $comment) {

                        echo '<p>' . $comment['comment'] . '</p>';

                    }

                } else {

                    echo 'There Is No Comments To Show ';
                    
                }


                ?>
            </div>
        </div>
    </div>
</div>


    
<?php

} else {
    header('location:login.php');
    exit;
}

 include $tpl . 'footer.php';
 
 ?>

 