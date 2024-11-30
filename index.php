<?php
    session_start();
    require_once "./src/controllers/functions.php" ;
    
    if(check_login_without_redirecting()){
        header("Location: /src/view/home.php");
    } else {
        header("Location: /src/view/landingpage.php");
    }
    
    exit();

?>




