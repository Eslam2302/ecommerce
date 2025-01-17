<?php 

    function lang( $phrase ) {

        static $lang = array(

            // Navbar

            "Home"          =>  "Home",
            "Dashboard"     =>  "Dashboard",
            "Categories"    =>  "Categories",
            "Items"         =>  "Items",
            "Members"       =>  "Members",
            "Comments"       =>  "Comments",
            "Statistics"    =>  "Statistics",
            "Logs"          =>  "Logs",
            "Edit"          =>  "Edit",
            "Profile"       =>  "Profile",
            "Setting"       =>  "Setting",
            "Logout"        =>  "Logout",


        );


        return $lang[$phrase];
    }   