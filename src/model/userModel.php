<?php
session_start();    
require_once __DIR__ . '/../config/db_conn.php';

function getUserName(){
    $user_id = $_SESSION["user_id"];
    $conn = connect_db();
    $stmt = $conn->prepare("SELECT `name` FROM `users` WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    return $user_data["name"];
}

?>