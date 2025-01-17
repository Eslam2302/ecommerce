<?php 

    session_start();

    $pageTitle = 'Comments';

    if (isset($_SESSION['Username'])) {
        include('init.php');

        $do = isset($_GET['do']) ? $_GET['do'] :'Manage';

        // Start manage page
        if ($do == 'Manage') {  

            $stmt = $con->prepare(" SELECT
                                                comments.*, items.Name AS Item_Name, users.UserName AS Member
                                            FROM 
                                                comments
                                            INNER JOIN
                                                items
                                            ON 
                                                items.Item_ID = comments.item_id
                                            INNER JOIN
                                                users
                                            ON
                                                users.UserID = comments.user_id");

            $stmt->execute();
            
            $rows = $stmt->fetchAll();
            
            ?>
           
            <h1 class="text-center">Manage Comments</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class=" main-table table text-center">
                        <tr>
                            <th>#ID</th>
                            <th>Comment</th>
                            <th>Item Name</th>
                            <th>User Name</th>
                            <th>Added Date</th>
                            <th>Control</th>
                        </tr>

                        <?php 
                        
                            foreach ($rows as $row) {

                                echo "<tr>";
                                    echo "<td>" . $row['c_id'] . "</td>";
                                    echo "<td>" . $row['comment'] . "</td>";
                                    echo "<td>" . $row['Item_Name'] . "</td>";
                                    echo "<td>" . $row['Member'] . "</td>";
                                    echo "<td>" . $row['comment_date'] . "</td>";
                                    echo "<td>
                                            <a href='comments.php?do=Edit&comid= " . $row['c_id'] . "  ' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                                            <a href='comments.php?do=Delete&comid= " . $row['c_id'] . "  ' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
                                     
                                            if ($row['status'] == 0) {
                                                echo     "<a href='comments.php?do=Approve&comid= " . $row['c_id'] . "  ' class='btn btn-info confirm'><i class='fa fa-check'></i> Approve</a>";

                                            }
                                     
                                        echo "</td>";
                                echo "</tr>";
                            }
                        
                        ?>

                    </table>
                </div>
            </div>

 <?php  
        } elseif ($do == 'Edit') {  // Edit Page 

            $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0; 

            $stmt = $con->prepare(" SELECT * FROM comments WHERE c_id = ?");
            $stmt->execute(array( $comid));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();

            if ($count > 0) { 

            ?>

                <div class="container">
                    <div class="row edit-profile-card ">
                        <div class="col-2"></div>
                        <div class="card col-8">
                            <div class="card-header text-center">
                                Edit Comment
                            </div>
                            <div class="card-body">
                                <form action="?do=Update" method="POST">
                                    <input type="hidden" name="comid" value="<?php echo $comid ?>">
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Comment</label>
                                        <div class="col-sm-10">
                                        <input type="text" class="form-control" name="comment" value="<?php echo $row['comment']; ?>">
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
                redirectHome($theMsg, 'comments');
            }
           // End Of do == Edit 
        } elseif ($do == 'Update') { // Update User


            if ($_SERVER['REQUEST_METHOD'] == 'POST') {  // Update member
                echo "<h1 class='text-center'>Update Comment</h1>";
                echo "<div class='container'>";

                // Get variables from the form

                $comid = $_POST['comid'];
                $comment = $_POST['comment'];

                // Valdation

                $formErrors = array();

                if (empty($comment)) {
                    $formErrors[] = 'Comment Cant Be Empty</div>';
                }

                // Loop into Error Aray
                foreach($formErrors as $error) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }

                // Check if there no error then update 

                if (empty($formErrors)) {

                  
                    // Update Database with the info

                    $stmt = $con->prepare('UPDATE comments SET comment = ? WHERE c_id = ?');
                    $stmt->execute(array($comment, $comid));

                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Updated</div>';
                    redirectHome($theMsg, 'comments');
                    
                }

            } else{
                $theMsg =  '<div class="alert alert-danger">Sorry You Cant Browse This Page Direct</div>';
                redirectHome($theMsg,'back');
            }

            echo '</div>';

        // End Update do==update

        } elseif ($do == 'Delete'){

            $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0; 

            $stmt = $con->prepare(" SELECT * FROM comments WHERE c_id = ? Limit 1");
            $stmt->execute(array( $comid));
            $count = $stmt->rowCount();

            echo "<div class='container'>";

            if ($count > 0) { 

                $stmt = $con->prepare("DELETE FROM comments WHERE c_id = :zcom");

                $stmt->bindParam("zcom",$comid);

                $stmt->execute();

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Deleted</div>';
                redirectHome($theMsg , 'comments');

            } else {
                $theMsg = '<div class="alert alert-danger">This User Is No Exist</div>';
                redirectHome($theMsg , 'back');
            }
            echo '</div>';
            
 // End of Delete 


        } elseif ($do == 'Approve'){

            $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0; 

            $stmt = $con->prepare(" SELECT c_id FROM comments WHERE c_id = ? Limit 1");
            $stmt->execute(array( $comid));
            $count = $stmt->rowCount();

            echo "<div class='container'>";

            if ($count > 0) { 

                $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE c_id = ?");

                $stmt->execute(array( $comid));
                
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Comment Approved</div>';
                redirectHome($theMsg , 'comments');

            } else {
                $theMsg = '<div class="alert alert-danger">This Comment Is No Exist</div>';
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