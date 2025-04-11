<?php 

    // Error Reporting

    ini_set('display_errors' , 'On');
    error_reporting(E_ALL);

    include 'admin/connect.php';

    $sessionUser = '';
    if (isset($_SESSION['user'])) {
        $sessionUser = $_SESSION['user'];
    }

    // Routes

    $tpl    =   "includes/templates/";        // Templates Dir
    $lang   =   "includes/lang/";             // Js Dir
    $func   =   "includes/functions/";
    $css    =   "layout/css/";                // Css Dir
    $js     =   "layout/js/";                 // Js Dir


    // Include the important files 
    include $func . 'functions.php';
    include $lang . 'en.php'  ;
    include $tpl . 'header.php';
