<?php
session_start();

require_once __DIR__ .'/functions.php';

if (!check_login()) {
    header("Location: /src/view/auth/signin.php");
    exit();
}

// Get user data from session
$username = isset($_SESSION["username"]) ? htmlspecialchars($_SESSION["username"]) : "User";
$user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;

?>