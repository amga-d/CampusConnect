<?php
session_start();    
require_once __DIR__ . '/../config/db_conn.php';

function getUserName(){
    $user_id = $_SESSION["user_id"];
    try{

    
    $conn = connect_db();
    
    $stmt = $conn->prepare("SELECT `name` FROM `users` WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);

    if(!$stmt->execute()){
        throw new Exception("Query execution failed");
    }

    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
    return $user_data["name"];

    }catch(PDOException $e){
        error_log("Failed to get username".$e->getMessage());
    }finally{
        if(isset($conn)){
            $conn->close();
        }
        if(isset($stmt)){
            $stmt->close();
        }
    }
}


function getUserProfile(){
    $user_id = $_SESSION["user_id"];
    try{
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT `profile_image` FROM `users` WHERE `user_id` = ?");
        $stmt->bind_param("i", $user_id);

        if(!$stmt->execute()){
            throw new Exception("Query Execation Failed");
        }
        $stmt ->bind_result($profile_path);
        if($stmt->fetch()){
            return $profile_path;
        }

    }catch(PDOException $e){   
    error_log("".$e->getMessage());

    }finally{
    if(isset($conn)){
        $conn->close();
    }
    if(isset($stmt)){
        $stmt->close();
    }
    
    }
}
?>