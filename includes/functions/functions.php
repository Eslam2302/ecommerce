<?php 


    // Get All Function 

    function getAllFrom($field, $table, $orderfield, $where = NULL, $and = NULL, $ordering = "DESC"){

        global $con;

        $getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");

        $getAll->execute();

        $all = $getAll->fetchAll();

        return $all;


    }
    
    // Check if user is not activated

    function checkUserStatus($user) {

        global $con;
        $stmt = $con->prepare(" SELECT
                                    Username , RegStatus
                                FROM
                                    users
                                WHERE
                                    Username = ?
                                AND
                                    RegStatus = 0
                            ");
        $stmt->execute(array($user));
        $status = $stmt->rowCount();
        return $status;
    }



    // Check Item function
    // Function to check item in database

    function checkItem($select,$from,$value) {

        global $con;

        $statemnet = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

        $statemnet->execute(array($value));

        $count = $statemnet->rowCount();

        return $count;

    }

    // Redirect Function

    function redirectHome($theMsg, $url = null, $seconds = 3) { 

        if ($url === null) {

            $url = 'index.php';

        } elseif($url == 'members') {
            $url = 'members.php';
        }elseif($url == 'dashboard') {
            $url = 'dashboard.php';
        } elseif($url == 'categories') {
            $url = 'categories.php';
        }elseif($url == 'items') {
            $url = 'items.php';
        }elseif($url == 'comments') {
            $url = 'comments.php';
        }elseif($url == 'newad') {
            $url = 'newad.php';
        } else {

            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {

                $url = $_SERVER['HTTP_REFERER'];

            } else {

                $url = 'index.php';

            }

        }

        echo $theMsg;
        echo "<div class='alert alert-info'>You Will Be Directed After $seconds Seconds</div>";

        header("refresh:$seconds;url=$url");
        exit();

    }

















    // Title function that echo the page title in case the page has
    // the variable $pagetitle

    function getTitle() {
        global $pageTitle;
        if (isset($pageTitle)) {  echo $pageTitle;}
         else {echo 'Default';}
    }

    
    

    // Count Items or rows in database in any table

    function countItems($item,$table) {

        global $con;

        $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");

        $stmt2->execute();

        return $stmt2->fetchColumn();

    }

    // Function getlatest 5 items from database to show in dashboard

    function getLatest($item,$table,$order,$limit=5) {

        global $con;

        $getstmt = $con->prepare("SELECT $item FROM $table ORDER BY $order DESC LIMIT $limit");

        $getstmt->execute();

        $rows = $getstmt->fetchAll();

        return $rows;


    }
