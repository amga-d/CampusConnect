<?php
session_start();

require_once __DIR__ .'/functions.php';
require_once __DIR__.'/../model/userModel.php';

if (!check_login()) {
    header("Location: /src/view/auth/signin.php");
    exit();
}

$username = getUserName();
$userProfile =getUserProfile();
?>