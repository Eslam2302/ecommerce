<?php 

    include 'connect.php';

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

    if (!isset($noNavbar)) { include $tpl . 'navbar.php'; }