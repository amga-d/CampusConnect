<?php
    include("./auth/functions.php");
    session_start();

    if(check_login_without_redirecting()){
        header("Location: ../index.php") ;
        die();
    }
    else{
        include("../pages/landingpage.html");
    }
    

?>