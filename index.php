<?php
    session_start();
    include ("./user_service/auth/functions.php") ;
    check_login();
    

?>

<h1>this is the home page</h1>
<a href="./user_service/auth/logout.php">logout</a>


