<?php

require_once __DIR__ . '/../config/db_conn.php';
require_once __DIR__ .'/modelsFunction.php';
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../../logs/error.log');


function getCommunity($communityId){
    try {
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT * FROM communities WHERE community_id = ?");
        $stmt->bind_param("i", $communityId);
        if (!$stmt->execute() ) {
            throw new Exception("Query Execution Failed");
        }
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    } catch (Exception $e) {
        error_log("Error in getCommunityById: " . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        if (isset($conn)) {
            $conn->close();
        }
    }
}
function getCommunityEvents($communityId)
{
    $query = "SELECT 
                an.title,
                an.content,
                an.created_at,
                cm.membership,
                usr.name,
                usr.profile_image

            FROM announcements an
            INNER JOIN  community_members cm ON an.community_id = cm.community_id
            INNER JOIN  users usr ON an.user_id = usr.user_id
            WHERE an.community_id = ?";
    try {
        $conn = connect_db();
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i",  $communityId);
        if (!$stmt->execute()) {
            throw new Exception("Query Execution Failed");
        }
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    } catch (Exception $e) {
        error_log("Error in get community events: " . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        if (isset($conn)) {
            $conn->close();
        }
    }
}

function getUserRole($userId, $communityId)
{

    try {
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT role FROM community_members WHERE user_id = ? AND community_id = ?");
        $stmt->bind_param("ii", $userId, $communityId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['role'];
    } catch (Exception $e) {
        error_log("Error in checkUserIsAdmin: " . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        if (isset($conn)) {
            $conn->close();
        }
    }
}

function getCommunityAnnouncements($communityId){
    $query ="SELECT 
                an.title,
                an.content,
                an.created_at,
                cm.membership,
                usr.name,
                usr.profile_image

            FROM announcements an
            INNER JOIN  community_members cm ON an.community_id = cm.community_id
            INNER JOIN  users usr ON an.user_id = usr.user_id
            WHERE an.community_id = ?";
    try {
        $conn = connect_db();
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i",  $communityId);
        if(!$stmt->execute()){
            throw new Exception("Query Execution Failed");
        }
        $result = $stmt->get_result();            
        return $result -> fetch_all(MYSQLI_ASSOC);
    } catch (Exception $e) {
        error_log("Error in getCommunityAnnouncements: " . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        if (isset($conn)) {
            $conn->close();
        }
    }
}

function getCommunityInfo($community_id)
{
    $query = "SELECT * FROM communities WHERE community_id = ?";
    $paramsType = "i";
    $params = [$community_id];

    return getData($query, $paramsType, $params, "getCommunityInfo");
}

function getCommunityMembers($communityId)
{
    $query = "SELECT 
                u.name, 
                cm.role, 
                cm.membership,
                cm.membership_status,
                u.profile_image
            FROM 
                community_members cm
            JOIN 
                users u 
            ON 
                cm.user_id = u.user_id
            WHERE 
            cm.community_id = ?
        ";
    $paramsType = "i";
    $params = [$communityId];
    return getData($query, $paramsType, $params, "getCommunityMember");
}


function getUserProfile($user_id){
    try{
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT `profile_image`,`name` FROM `users` WHERE `user_id` = ?");
        $stmt->bind_param("i", $user_id);

        if(!$stmt->execute()){
            throw new Exception("Query Execation Failed");
        }
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            return $row;
        }else{
            return false;
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