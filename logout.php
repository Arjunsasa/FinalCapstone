<?php
session_start();

include "config/config.php"; 

include "config/functions.php";

//If the user is logged in
if(isLoggedIn()){
            //Clear & Destroy all sessions
            session_unset(); // remove all session variables
            session_destroy(); // destroy the session
            jsRedirect(SITE_ROOT . "login.php");
        } else{
            jsRedirect(SITE_ROOT . "login.php");
        }

?>