<?php
session_start();
ini_set('display_errors', 0);
ini_set('log_errors', 1);
require_once __DIR__ .'/functions.php';
require_once __DIR__.'/../model/userModel.php';

if (!check_login()) {
    header("Location: /src/view/auth/signin.php");
    exit();
}
$user_id = $_SESSION["user_id"];
$username = getUserName($user_id);
$userProfile = getUserProfile($user_id);
?>