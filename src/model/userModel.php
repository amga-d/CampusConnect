<?php
require_once __DIR__ . "/modelsFunction.php";

function getUserName($user_id){

    // $query = "INSERT INTO news (news_name, description, news_image) VALUES (?, ?, ?)";
    // $paramstype = "sss";
    // $params = [$data["news_name"], $data["description"], $data["news_image"]];
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


function getUserProfile($user_id){
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