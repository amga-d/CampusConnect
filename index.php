<?php
    session_start();
    include ("./src/controllers/functions.php") ;
    check_login();
    

?>

<h1>this is the home page</h1>
<a href="./src/controllers/logout.php">logout</a>


