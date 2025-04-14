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
                                        Item_ID = ?");

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

    <!-- Comment -->
    <div class="row">
        <div class="col-md-3">
            User Image
        </div>
        <div class="col-md-9">
            User Comment
        </div>
    </div>  
</div>


    
<?php
    } else {
        echo 'There Is No Such ID';
    }

 include $tpl . 'footer.php';
 
 ?>

 