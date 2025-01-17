<?php 

    ob_start();

    session_start();

    $pageTitle = 'Categories';

    if (isset($_SESSION['Username'])) {
        
        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] :'Manage';

        if ($do == 'Manage') {

            $sort = 'ASC';

            $sort_array = array('ASC','DESC');

            if (isset($_GET['sort']) && in_array($_GET['sort'],$sort_array)) {

                $sort = $_GET['sort'];

            }

            $stmt = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");

            $stmt->execute();
            
            $cats = $stmt->fetchAll();
            
            ?>
           
            <h1 class="text-center">Manage Categories Page</h1>
            <div class="container categories">
                <div class="card">
                    <div class="card-header">
                        <span class="">Categories</span>
                        <span class="sorting">
                            <a href="?sort=ASC" class="<?php if($sort == 'ASC') {echo 'active';} ?>">Asc</a> |
                            <a href="?sort=DESC" class="<?php if($sort == 'DESC') {echo 'active';} ?>">Desc</a>
                        </span>
                        <a href="categories.php?do=Add" class="add-cat btn btn-primary"><i class="fa fa-plus"></i> Add New Category</a>
                    </div>
                    <div class="card-body">
                        <?php 
                        
                        foreach ($cats as $cat) { 

                            echo '<div class="cat">';
                                echo '<div class="hidden-button">';

                                    echo '<a href="?do=Edit&&catid= '. $cat['ID'] .'" class="btn btn-success btn-sm"><i class="fa fa-edit"></i>Edit</a>';
                                    echo '<a href="?do=Delete&&catid= '. $cat['ID'] .'" class="btn btn-danger btn-sm confirm"><i class="fa fa-close"></i>Delete</a>';

                                echo '</div>';
                                echo '<h4 class="card-title">' . $cat['Name'] . '</h5>';
                                echo '<p class="card-text">';
                                    if  ($cat['Description'] == '') {echo 'This Category Has No Description';} else {echo $cat['Description'];}; 
                                echo '</p>';
                                if ($cat['Visibilty'] == 1) {echo '<span class="visibilty">Hidden</span>';}
                                if ($cat['Allow_Comment'] == 1) {echo '<span class="commenting">Comment Disabled</span>';}
                                if ($cat['Allow_Ads'] == 1) {echo '<span class="ads">Ads Disabled</span>';}
                            echo '</div>';
                            echo '<hr>';

                        }
                        
                        ?>
                    </div>
                </div>
            </div>

 <?php

        } elseif ($do == 'Add') { ?>

            <div class="container">
                <div class="row edit-profile-card ">
                    <div class="col-2"></div>
                    <div class="card col-8">
                        <div class="card-header text-center">
                            Add New Category
                        </div>
                        <div class="card-body">
                            <form action="?do=Insert" method="POST">
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="name" placeholder="Type Name Of Category" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Description</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="description" placeholder="Descripe The Category">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Ordering</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="ordering" placeholder="Number to Arrange The Categories">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Visible</label>
                                    <div class="col-sm-9">
                                        <div>
                                            <input id="vis-yes" type="radio" name="vivibilty" value="0" checked >
                                            <label for="vis-yes">Yes</label>
                                        </div>
                                        <div>
                                            <input id="vis-no" type="radio" name="vivibilty" value="1">
                                            <label for="vis-no">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Allow Commenting</label>
                                    <div class="col-sm-9">
                                        <div>
                                            <input id="com-yes" type="radio" name="commenting" value="0" checked >
                                            <label for="com-yes">Yes</label>
                                        </div>
                                        <div>
                                            <input id="com-no" type="radio" name="commenting" value="1">
                                            <label for="com-no">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Allow Ads</label>
                                    <div class="col-sm-9">
                                        <div>
                                            <input id="ads-yes" type="radio" name="ads" value="0" checked >
                                            <label for="ads-yes">Yes</label>
                                        </div>
                                        <div>
                                            <input id="ads-no" type="radio" name="ads" value="1">
                                            <label for="ads-no">No</label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Category</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-2"></div>
                </div>
            </div>

        <?php

        } elseif ($do == 'Insert') {


            if ($_SERVER['REQUEST_METHOD'] == 'POST') {  // Update member

                echo "<h1 class='text-center'>Insert Category</h1>";
                echo "<div class='container'>";
                // Get variables from the form

                $name           = $_POST['name'];
                $desc    = $_POST['description'];
                $order       = $_POST['ordering'];
                $visible      = $_POST['vivibilty'];
                $comment     = $_POST['commenting'];
                $ads            = $_POST['ads'];

                // Valdation

                $formErrors = array();
                if (empty($name)) {
                    $formErrors[] = 'Category Name Cant Be Empty';
                }

                // Loop into Error Aray
                foreach($formErrors as $error) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }

                // Check if there no error then update 

                if (empty($formErrors)) {

                    // Check if Category Name is exist

                    $check = checkItem("Name","categories",$name);

                    if ($check == 1) {

                        $theMsg =  '<div class="alert alert-danger">Sorry This Category Name Is Exist</div>';
                        redirectHome($theMsg,'back');

                    } else {

                        // Insert Category into Database

                        $stmt = $con->prepare("INSERT INTO 
                                                        categories(Name, Description,Ordering,Visibilty,Allow_Comment,Allow_Ads)
                                                        VALUES(:zname,:zdesc,:zorder,:zvis,:zcom,:zads)
                                                        ");

                        $stmt->execute(array(
                            'zname' => $name,
                            'zdesc'=> $desc,
                            'zorder'=> $order,
                            'zvis'=> $visible,
                            'zcom'=> $comment,
                            'zads'=> $ads
                        ));

                        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Updated</div>';
                        redirectHome($theMsg,'categories');

                    }
                }

            } else{

                $theMsg =  '<div class="alert alert-danger">Sorry You Cant Browse This Page Direct</div>';
                redirectHome($theMsg,'back');

            }

            echo '</div>';

        } elseif ($do == 'Edit') {

            $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0; 

            $stmt = $con->prepare(" SELECT * FROM categories WHERE ID = ? Limit 1");
            $stmt->execute(array( $catid));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();

            if ($count > 0) { 

            ?>

            <div class="container">
                <div class="row edit-profile-card ">
                    <div class="col-2"></div>
                    <div class="card col-8">
                        <div class="card-header text-center">
                            Edit Category (<?php echo $row['Name']; ?>)
                        </div>
                        <div class="card-body">
                            <form action="?do=Insert" method="POST">
                                <input type="hidden" name="catid" value="<?php echo $catid ?>">
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="name" Value="<?php echo $row['Name']; ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Description</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="description" Value="<?php echo $row['Description']; ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Ordering</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="ordering" Value="<?php echo $row['Ordering']; ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Visible</label>
                                    <div class="col-sm-9">
                                        <div>
                                            <input id="vis-yes" type="radio" name="vivibilty" value="0" <?php if ($row['Visibilty'] == 0){echo 'checked';} ?> >
                                            <label for="vis-yes">Yes</label>
                                        </div>
                                        <div>
                                            <input id="vis-no" type="radio" name="vivibilty" value="1" <?php if ($row['Visibilty'] == 1){echo 'checked';} ?>>
                                            <label for="vis-no">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Allow Commenting</label>
                                    <div class="col-sm-9">
                                        <div>
                                            <input id="com-yes" type="radio" name="commenting" value="0" <?php if ($row['Allow_Comment'] == 0){echo 'checked';} ?> >
                                            <label for="com-yes">Yes</label>
                                        </div>
                                        <div>
                                            <input id="com-no" type="radio" name="commenting" value="1" <?php if ($row['Allow_Comment'] == 1){echo 'checked';} ?>>
                                            <label for="com-no">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Allow Ads</label>
                                    <div class="col-sm-9">
                                        <div>
                                            <input id="ads-yes" type="radio" name="ads" value="0" <?php if ($row['Allow_Ads'] == 0){echo 'checked';} ?> >
                                            <label for="ads-yes">Yes</label>
                                        </div>
                                        <div>
                                            <input id="ads-no" type="radio" name="ads" value="1" <?php if ($row['Allow_Ads'] == 1){echo 'checked';} ?>>
                                            <label for="ads-no">No</label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Edit Category</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-2"></div>
                </div>
            </div>
            <?php
            // End of Count > 0 
            } else {
                $theMsg = '<div class="alert alert-danger">Theres No Such Category ID</div>';
                redirectHome($theMsg, 'Categories');
            }
           // End Of do == Edit 

        } elseif ($do == 'Update') {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {  // Update member
                echo "<h1 class='text-center'>Update Category</h1>";
                echo "<div class='container'>";

                // Get variables from the form

                $catid          = $_POST['catid'];
                $name           = $_POST['name'];
                $desc           = $_POST['description'];
                $order          = $_POST['ordering'];
                $visible        = $_POST['vivibilty'];
                $comment        = $_POST['commenting'];
                $ads            = $_POST['ads'];


                // Valdation

                $formErrors = array();

                if (empty($name)) {
                    $formErrors[] = 'Category Name Cant Be Empty</div>';
                }
  

                // Loop into Error Aray
                foreach($formErrors as $error) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }

                // Check if there no error then update 

                if (empty($formErrors)) {

                        // Update Database with the info

                        $stmt = $con->prepare('UPDATE categories
                            SET Name = ?, Description = ?, Ordering = ?, Visibilty = ?, Allow_Comment = ? , Allow_Ads = ?
                            WHERE ID = ?');
                        $stmt->execute(array($name, $desc, $order, $visible, $comment, $ads,$catid));

                        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Updated</div>';
                        redirectHome($theMsg, 'categories');
                    
                }

            } else{
                $theMsg =  '<div class="alert alert-danger">Sorry You Cant Browse This Page Direct</div>';
                redirectHome($theMsg,'back');
            }

            echo '</div>';

        // End Update do==update


        } elseif ($do == 'Delete') {

            $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0; 

            $stmt = $con->prepare(" SELECT * FROM categories WHERE ID = ? Limit 1");
            $stmt->execute(array( $catid));
            $count = $stmt->rowCount();

            echo "<div class='container'>";

            if ($count > 0) { 

                $stmt = $con->prepare("DELETE FROM categories WHERE ID = :zcat");

                $stmt->bindParam("zcat",$catid);

                $stmt->execute();

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Deleted</div>';
                redirectHome($theMsg , 'categories');

            } else {
                $theMsg = '<div class="alert alert-danger">This Category Is No Exist</div>';
                redirectHome($theMsg , 'back');
            }
            echo '</div>';
            
 // End of Delete 

        } // End Of $do 

        include $tpl . 'footer.php';

    } else {

        header('Location: index.php');
        exit();

    } // End of Seession

    ob_end_flush();




?>