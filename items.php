<?php 
    session_start();
    $pageTitle = 'Show Item';

    include 'init.php';

    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0; 

    $stmt = $con->prepare(" SELECT
                                        items.*,
                                        categories.Name AS category_name,
                                        users.Username
                                    FROM
                                        items
                                    INNER JOIN 
                                        categories
                                    ON
                                        categories.ID = items.Cat_ID
                                    INNER JOIN
                                        users 
                                    ON
                                        users.UserID = items.Member_ID
                                    WHERE 
                                        Item_ID = ?
                                    AND
                                        Approve = 1");

    $stmt->execute(array( $itemid));

    $count = $stmt->rowCount();

    if($count > 0) {

    $item = $stmt->fetch();

        
?>

<h1 class="text-center"> <?php echo $item['Name']  ?> </h1>
<div class="container">
    <!-- Item Details -->
    <div class="row">
        <div class="col-md-3">
            <img class="img-responsive img-thumbnail center-block" src="mcro.png" alt="image">
        </div>
        <div class="col-md-9 item-info">
            <h2><?php echo $item['Name'] ?></h2>
            <p><?php echo $item['Description'] ?></p>
            <ul class="list-unstyled">
                <li>
                    <i class="fa-solid fa-calendar"></i>
                    <span>Added Date</span> : <?php echo $item['Add_Date'] ?>
                </li>
                <li>
                    <i class="fa-solid fa-money-bill-1"></i>
                    <span>Price</span> : <?php echo '$'. $item['Price'] ?>
                </li>
                <li>
                    <i class="fa-solid fa-building"></i>
                    <span>Made In</span> : <?php echo $item['Country_Made'] ?>
                </li>
                <li>
                    <i class="fa-solid fa-tag"></i>
                    <span>Category</span> : <a href="categories.php?pageid=<?php echo $item['Cat_ID'] ?>"> <?php echo $item['category_name'] ?></a>
                </li>
                <li>
                    <i class="fa-solid fa-user"></i>
                    <span>Added By</span> : <a href="#"> <?php echo $item['Username'] ?></a>
                </l>
            </ul>
        </div>
    </div>

    <hr class="custom-hr">

        <!-- Start Add Comment -->
        <?php if (isset($_SESSION['user'])) { ?>

        <div class="row">
            <div class="col-md-3 offset-md-3">
                <div class="add-comment">
                    <h3>Add Your Comment</h3>
                    <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['Item_ID'] ?>" method="POST">
                        <textarea name="comment" required></textarea>
                        <input class="btn btn-primary" type="submit" value="Add Comment">
                    </form>

                    <?php 
                    
                        if($_SERVER['REQUEST_METHOD'] == 'POST') {

                            $comment    = filter_var($_POST['comment'], FILTER_SANITIZE_ADD_SLASHES);
                            $userid     = $item['Member_ID'];
                            $itemid     = $item['Item_ID'];

                            if(!empty($comment)) {
                                $stmt = $con->prepare("INSERT INTO 
                                comments(comment, status, comment_date, item_id, user_id)
                                Values(:zcomment, 0, NOW(), :zitemid, :zuserid)");

                                $stmt->execute(array(

                                    'zcomment'  => $comment,
                                    'zitemid'   => $itemid,
                                    'zuserid'   => $userid

                                ));

                                if($stmt) {
                                    echo '<div class="alert alert-success">Comment Added</div>';
                                } else {
                                    echo '<div class="alert alert-danger">You Must Add Comment</div>';
                                }

                            }

                        }

                    ?>

                </div>
            </div>
        </div>
        <?php } else {
            echo '<div class="login-comment"><a href="login.php">Login</a> Or <a href="login.php">Register</a> To Add Comment</div>';
        } ?>
        <!-- Start Add Comment -->

    <hr class="custom-hr">

    <!-- Comment -->

    <?php 

        $stmt = $con->prepare(" SELECT
                                            comments.*, users.UserName AS Member
                                        FROM 
                                            comments
                                        INNER JOIN
                                            users
                                        ON
                                            users.UserID = comments.user_id
                                        WHERE 
                                            item_id = ?
                                        AND
                                            status = 1
                                        ORDER BY
                                            c_id DESC");

        $stmt->execute(array($item['Item_ID']));

        $comments = $stmt->fetchAll();

    ?>

    <?php 
        
        foreach($comments as $comment) { ?>

            <div class="comment-box">
                <div class="row">
                    <div class="col-sm-2 text-center">
                        <img class="img-responsive img-thumbnail center-block rounded-circle" src="mcro.png" alt="image">
                        <?php echo $comment['Member'] ?>
                    </div>
                    <div class="col-sm-10">
                        <p class="lead"><?php echo $comment['comment'] ?></p>
                    </div>
                </div>
            </div>

            <hr class="custom-hr">

       <?php }
    
    ?>

</div>


    
<?php
    } else {
        echo '<div class="container">';
            echo '<div class="alert alert-danger">There Is No Such ID / Or This Item Is Waiting Approve</div>';
        echo '</div>';
    }

 include $tpl . 'footer.php';
 
 ?>

 