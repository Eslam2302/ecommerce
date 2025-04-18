<?php 

    ob_start();

    session_start();

    $pageTitle = 'Items';

    if (isset($_SESSION['Username'])) {
        
        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] :'Manage';

        if ($do == 'Manage') {

            $stmt = $con->prepare('SELECT 
                                        items.*, 
                                        categories.Name AS Cat_Name, 
                                        users.Username 
                                        From items
                                        INNER JOIN categories ON categories.ID = items.Cat_ID
                                        INNER JOIN users ON users.UserID = items.Member_ID 
            ');

            $stmt->execute();
            
            $items = $stmt->fetchAll();
            
            ?>
           
            <h1 class="text-center">Manage Items Page</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class=" main-table table text-center">
                        <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Country Made</th>
                            <th>Adding Date</th>
                            <th>Category</th>
                            <th>Username</th>
                            <th>Control</th>
                        </tr>

                        <?php 
                        
                            foreach ($items as $item) {

                                echo "<tr>";
                                    echo "<td>" . $item['Item_ID'] . "</td>";
                                    echo "<td>" . $item['Name'] . "</td>";
                                    echo "<td>" . $item['Description'] . "</td>";
                                    echo "<td>" . '$' . $item['Price'] . "</td>";
                                    echo "<td>" . $item['Country_Made'] . "</td>";
                                    echo "<td>" . $item['Add_Date'] . "</td>";
                                    echo "<td>" . $item['Cat_Name'] . "</td>";
                                    echo "<td>" . $item['Username'] . "</td>";
                                    echo "<td>
                                            <a href='items.php?do=Edit&itemid= " . $item['Item_ID'] . "  ' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                                            <a href='items.php?do=Delete&itemid= " . $item['Item_ID'] . "  ' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
                                            if ($item['Approve'] == 0) {
                                                echo     "<a href='items.php?do=Approve&itemid= "
                                                 . $item['Item_ID'] . "  ' class='btn btn-info confirm'>
                                                 <i class='fa fa-check'></i> Approve</a>";
                                            }  echo "</td>";
                                echo "</tr>";
                            }
                        
                        ?>

                    </table>
                </div>
                <a href="items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Item</a>
            </div>

 <?php  

        } elseif ($do == 'Add') { ?>

            <div class="container">
                <div class="row edit-profile-card ">
                    <div class="col-2"></div>
                    <div class="card col-8">
                        <div class="card-header text-center">
                            Add New Item
                        </div>
                        <div class="card-body">
                            <form action="?do=Insert" method="POST">
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" 
                                        class="form-control"
                                        name="name" 
                                        placeholder="Type Name Of Item" 
                                        required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Description</label>
                                    <div class="col-sm-9">
                                        <input type="text" 
                                        class="form-control" 
                                        name="description" 
                                        placeholder="Type Description Of Item"
                                        required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Price</label>
                                    <div class="col-sm-9">
                                        <input type="text" 
                                        class="form-control" 
                                        name="price" 
                                        placeholder="Type Price Of Item"
                                        required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Country</label>
                                    <div class="col-sm-9">
                                        <input type="text" 
                                        class="form-control" 
                                        name="country" 
                                        placeholder="Type Country Of Made"
                                        required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Status</label>
                                    <div class="col-sm-9">
                                        <select name="status" class="form-control">
                                            <option value="0">...</option>
                                            <option value="1">New</option>
                                            <option value="2">Like New</option>
                                            <option value="3">Used</option>
                                            <option value="4">Old</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Members</label>
                                    <div class="col-sm-9">
                                        <select name="member" class="form-control">
                                            <option value="0">...</option>
                                            <?php

                                                $stmt = $con->prepare('SELECT * FROM users');
                                                $stmt->execute();
                                                $users = $stmt->fetchAll();
                                                foreach ($users as $user) {
                                                    echo "<option value='" . $user['UserID'] . "'>" . $user['Username'] . "</option>";
                                                }    
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Categories</label>
                                    <div class="col-sm-9">
                                        <select name="category" class="form-control">
                                            <option value="0">...</option>
                                            <?php

                                                $stmt2 = $con->prepare('SELECT * FROM categories');
                                                $stmt2->execute();
                                                $cats = $stmt2->fetchAll();
                                                foreach ($cats as $cat) {
                                                    echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
                                                }    
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Item</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-2"></div>
                </div>
            </div>

        <?php

        } elseif ($do == 'Insert') {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {  // Update member

                echo "<h1 class='text-center'>Insert Item</h1>";
                echo "<div class='container'>";
                // Get variables from the form

                $name = $_POST['name'];
                $desc = $_POST['description'];
                $price = $_POST['price'];
                $country = $_POST['country'];
                $status = $_POST['status'];
                $member = $_POST['member'];
                $cat = $_POST['category'];

                // Valdation

                $formErrors = array();

                if (empty($name)) {
                    $formErrors[] = 'Name Cant Be Empty';
                }
                if (empty($desc)) {
                    $formErrors[] = 'Description Cant Be Empty';
                }
                if (empty($price)) {
                    $formErrors[] = 'Price Cant Be Empty';
                }
                if (empty($country)) {
                    $formErrors[] = 'Country Cant Be Empty';
                }
                if ($status == 0) {
                    $formErrors[] = 'You Must Choose The Status';
                }
                if ($member == 0) {
                    $formErrors[] = 'You Must Choose The Member';
                }
                if ($cat == 0) {
                    $formErrors[] = 'You Must Choose The Category';
                }

                // Loop into Error Aray
                foreach($formErrors as $error) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }

                // Check if there no error then update 

                if (empty($formErrors)) {

                    // Insert Item into Database

                    $stmt = $con->prepare("INSERT INTO 
                                                    items(Name, Description, Price, Country_Made, Status, Add_Date, Member_ID, Cat_ID)
                                                    VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zmember, :zcat)
                                                    ");

                    $stmt->execute(array(
                        'zname'     => $name,
                        'zdesc'     => $desc,
                        'zprice'    => $price,
                        'zcountry'  => $country,
                        'zstatus'   => $status,
                        'zmember'   => $member,
                        'zcat'      => $cat,
                    ));

                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Updated</div>';
                    redirectHome($theMsg,'members');

                }

            } else{

                $theMsg =  '<div class="alert alert-danger">Sorry You Cant Browse This Page Direct</div>';
                redirectHome($theMsg,'back');

            }

            echo '</div>';


        } elseif ($do == 'Edit') {

            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0; 

            $stmt = $con->prepare(" SELECT * FROM items WHERE Item_ID = ?");
            $stmt->execute(array( $itemid));
            $item = $stmt->fetch();
            $count = $stmt->rowCount();

            if ($count > 0) { 

            ?>

            <div class="container">
                <div class="row edit-profile-card ">
                    <div class="col-2"></div>
                    <div class="card col-8">
                        <div class="card-header text-center">
                            Edit Item (<?php echo $item['Name']; ?>)
                        </div>
                        <div class="card-body">
                            <form action="?do=Update" method="POST">
                                <input type="hidden" name="itemid" value="<?php echo $itemid ?>">
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" 
                                        class="form-control"
                                        name="name" 
                                        value="<?php echo $item['Name']; ?>" 
                                        required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Description</label>
                                    <div class="col-sm-9">
                                        <input type="text" 
                                        class="form-control" 
                                        name="description" 
                                        value="<?php echo $item['Description']; ?>" 
                                        required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Price</label>
                                    <div class="col-sm-9">
                                        <input type="text" 
                                        class="form-control" 
                                        name="price" 
                                        value="<?php echo $item['Price']; ?>"
                                        required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Country</label>
                                    <div class="col-sm-9">
                                        <input type="text" 
                                        class="form-control" 
                                        name="country" 
                                        value="<?php echo $item['Country_Made']; ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Status</label>
                                    <div class="col-sm-9">
                                        <select name="status" class="form-control">
                                            <option value="1" <?php if ($item['Status'] == 1) {echo 'selected';} ?>>New</option>
                                            <option value="2" <?php if ($item['Status'] == 2) {echo 'selected';} ?>>Like New</option>
                                            <option value="3" <?php if ($item['Status'] == 3) {echo 'selected';} ?>>Used</option>
                                            <option value="4" <?php if ($item['Status'] == 4) {echo 'selected';} ?>>Old</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Members</label>
                                    <div class="col-sm-9">
                                        <select name="member" class="form-control">
                                            <option value="0">...</option>
                                            <?php

                                                $stmt = $con->prepare('SELECT * FROM users');
                                                $stmt->execute();
                                                $users = $stmt->fetchAll();
                                                foreach ($users as $user) {
                                                    echo "<option value='" . $user['UserID'] . "'";
                                                    if ($item['Member_ID'] == $user['UserID']) {echo 'selected';}
                                                    echo ">" . $user['Username'] . "</option>";
                                                }    
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Categories</label>
                                    <div class="col-sm-9">
                                        <select name="category" class="form-control">
                                            <option value="0">...</option>
                                            <?php

                                                $stmt2 = $con->prepare('SELECT * FROM categories');
                                                $stmt2->execute();
                                                $cats = $stmt2->fetchAll();
                                                foreach ($cats as $cat) {
                                                    echo "<option value='" . $cat['ID'] . "'";
                                                    if ($item['Cat_ID'] == $cat['ID']) {echo 'selected';}
                                                    echo">" . $cat['Name'] . "</option>";
                                                }    
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Edit Item</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-2"></div>
                </div>
            </div>                

            <?php
            // End of Count > 0 
            } else {
                $theMsg = '<div class="alert alert-danger">Theres No Such ID Item</div>';
                redirectHome($theMsg, 'items');
            }
           // End Of do == Edit 

        } elseif ($do == 'Update') {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {  // Update member
                echo "<h1 class='text-center'>Update Item</h1>";
                echo "<div class='container'>";

                // Get variables from the form

                $id = $_POST['itemid'];
                $name = $_POST['name'];
                $desc = $_POST['description'];
                $price = $_POST['price'];
                $country = $_POST['country'];
                $status = $_POST['status'];
                $member = $_POST['member'];
                $cat = $_POST['category'];

                
                // Valdation

                $formErrors = array();

                if (empty($name)) {
                    $formErrors[] = 'Name Cant Be Empty';
                }
                if (empty($desc)) {
                    $formErrors[] = 'Description Cant Be Empty';
                }
                if (empty($price)) {
                    $formErrors[] = 'Price Cant Be Empty';
                }
                if (empty($country)) {
                    $formErrors[] = 'Country Cant Be Empty';
                }
                if ($status == 0) {
                    $formErrors[] = 'You Must Choose The Status';
                }
                if ($member == 0) {
                    $formErrors[] = 'You Must Choose The Member';
                }
                if ($cat == 0) {
                    $formErrors[] = 'You Must Choose The Category';
                }

                // Loop into Error Aray
                foreach($formErrors as $error) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }

                // Check if there no error then update 

                if (empty($formErrors)) {
                    
                        // Update Database with the info

                        $stmt = $con->prepare('UPDATE items 
                        SET 
                        Name = ?, Description = ?, Price = ?, Country_Made = ?, Status = ?, Member_ID = ?, Cat_ID = ?
                        WHERE Item_ID = ?');

                        $stmt->execute(array($name, $desc, $price, $country, $status,$member,$cat,$id));

                        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Updated</div>';
                        redirectHome($theMsg, 'items');
                }

            } else{
                $theMsg =  '<div class="alert alert-danger">Sorry You Cant Browse This Page Direct</div>';
                redirectHome($theMsg,'back');
            }

            echo '</div>';

        // End Update do==update

        } elseif ($do == 'Delete') {

            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0; 

            $stmt = $con->prepare(" SELECT * FROM items WHERE Item_ID = ?");
            $stmt->execute(array( $itemid));
            $count = $stmt->rowCount();

            echo "<div class='container'>";

            if ($count > 0) { 

                $stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :zitem");

                $stmt->bindParam("zitem",$itemid);

                $stmt->execute();

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Deleted</div>';
                redirectHome($theMsg , 'items');

            } else {
                $theMsg = '<div class="alert alert-danger">This User Is No Exist</div>';
                redirectHome($theMsg , 'back');
            }
            echo '</div>';
            
 // End of Delete 


        } elseif ($do == 'Approve') {

            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0; 

            $stmt = $con->prepare(" SELECT Item_ID FROM items WHERE Item_ID = ?");
            $stmt->execute(array( $itemid));
            $count = $stmt->rowCount();

            echo "<div class='container'>";

            if ($count > 0) { 

                $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");

                $stmt->execute(array( $itemid));
                
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' User Activated</div>';
                redirectHome($theMsg , 'dashboard');

            } else {
                $theMsg = '<div class="alert alert-danger">This Item Is Not Exist</div>';
                redirectHome($theMsg , 'back');
            }
            
            echo "</div>";


        } // End Of $do 

        include $tpl . 'footer.php';

    } else {

        header('Location: index.php');
        exit();

    } // End of Seession

    ob_end_flush();




?>