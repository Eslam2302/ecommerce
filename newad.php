<?php 
    session_start();
    $pageTitle = 'Create New Ad';

    include 'init.php';
    
    if (isset($_SESSION['user'])) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $formErrors = array();

            $name       = filter_var($_POST['name'], FILTER_SANITIZE_ADD_SLASHES);
            $desc       = filter_var($_POST['description'], FILTER_SANITIZE_ADD_SLASHES);
            $price      = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
            $country    = filter_var($_POST['country'], FILTER_SANITIZE_ADD_SLASHES);
            $status     = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
            $category   = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);

            if(strlen($name) < 3) {
                $formErrors[] = 'Item Titile Must Be More Than 3 Character';
            }
            if(strlen($desc) < 10) {
                $formErrors[] = 'Item Description Must Be More Than 10 Character';
            }
            if(strlen($country) < 2) {
                $formErrors[] = 'Item Country Made Must Be More Than 2 Character';
            }
            if(empty($price)) {
                $formErrors[] = 'Price Can\'t Be Empty';
            }
            if(empty($status)) {
                $formErrors[] = 'Status Can\'t Be Empty';
            }
            if(empty($category)) {
                $formErrors[] = 'Category Can\'t Be Empty';
            }


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
                    'zmember'   => $_SESSION['uid'],
                    'zcat'      => $category,
                ));
            }
        }

?>

<h1 class="text-center">Create New Ad</h1>

<div class="create-ad block">
    <div class="container">
        <div class="card">
            <div class="card-header text-bg-primary mb-3">Create New Ad</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" 
                                    class="form-control live-name"
                                    name="name" 
                                    placeholder="Type Name Of Item" 
                                    required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Description</label>
                                <div class="col-sm-9">
                                    <input type="text" 
                                    class="form-control live-desc" 
                                    name="description" 
                                    placeholder="Type Description Of Item"
                                    required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Price</label>
                                <div class="col-sm-9">
                                    <input type="text" 
                                    class="form-control live-price" 
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
                                        <option value="">...</option>
                                        <option value="1">New</option>
                                        <option value="2">Like New</option>
                                        <option value="3">Used</option>
                                        <option value="4">Old</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Categories</label>
                                <div class="col-sm-9">
                                    <select name="category" class="form-control">
                                        <option value="">...</option>
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
                    <div class="col-md-4">
                     <div class="thumbnail item-box live-preview">
                             <span class="price-tag">$</span>
                             <img src="mcro.png" alt="image" class="img-fluid">
                             <div class="caption">
                                 <h3></h3>
                                 <p></p>
                             </div>
                         </div>
                    </div>
                </div>
            </div>
            <!-- Start Looping Through Erros -->
            <?php 
                if (!empty($formErrors)) {

                    foreach($formErrors as $error) {
                        echo '<div class="alert alert-danger">' . $error . '</div>';
                    }

                }         
            ?>
            <!-- End Looping Through Erros -->
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

 