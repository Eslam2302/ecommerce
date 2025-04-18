<?php 
ob_start();
session_start();

$pageTitle = 'Homepage';

include 'init.php'; ?>


<div class="container">
    <h1 class="text-center">Items</h1>
    <div class="row">
        <?php
            $allItems = getAllFrom('items','Item_ID', 'WHERE Approve = 1');
            foreach($allItems as $item) {
                echo '<div class="col-sm-6 col-md-3 col-lg-3 big-box>">';
                    echo '<div class="thumbnail item-box">';
                        echo '<span class="price-tag">' . '$' . $item['Price'] . '</span>';
                        echo '<img src="mcro.png" alt="image" class="img-fluid img-responsive img-thumbnail">';
                        echo '<div class="caption">';
                            echo '<h3><a href="items.php?itemid=' . $item['Item_ID'] . '">' . $item['Name'] . '</a> </h3>';
                            echo '<p>' . $item['Description'] . '</p>';
                            echo '<p class="date">' . $item['Add_Date'] . '</p>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            }
        ?>
    </div>
</div>


    
<?php
    include $tpl . 'footer.php'; 
    ob_end_flush(); 
?>