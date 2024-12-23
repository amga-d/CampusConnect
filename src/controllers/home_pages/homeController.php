<?php
require_once __DIR__ . '/../../model/userModel.php';
session_start();
    $username = getUserName($_SESSION['user_id']) ;
    
