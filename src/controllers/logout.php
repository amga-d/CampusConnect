<?php 
session_start();
session_destroy();
header("Location: /src/view/auth/signin.php");
die;