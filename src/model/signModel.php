<?php

require_once __DIR__ . '/../config/db_conn.php';
require_once __DIR__ . '/../controllers/functions.php';



function isEmailUniqu($useremail)
{
    $conn = connect_db();
    $count = null;
    
    $stmt = $conn->prepare("SELECT COUNT(`email`) FROM `users` WHERE email = ?");
    $stmt->bind_param("s", $useremail);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    return $count === 0;
}


function signup($username, $useremail, $password)
{
    try {
        $conn = connect_db();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
        $stmt->bind_param("sss", $username, $useremail, $hash);

        if (!$stmt->execute()) {
            throw new Exception("Query  execution failed");
        }
        $user_id = get_user_id($useremail);
        if (!empty($user_id)) {
            return $user_id;
        }   
        return false;

    } catch (Exception $e) {
        error_log("Error creating a new account : " . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }

    }
}


function authenticateLogin($useremail, $password)
{
    try {
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT password FROM `users` where email = ?");
        $stmt->bind_param("s", $useremail,);

        if (!$stmt->execute()) {
            throw new Exception("Query execution failed");
        }
        $stmt ->bind_result($hasedPassword);
        if ($stmt->fetch()){
            if(password_verify($password, $hasedPassword)){
                $user_id = get_user_id(useremail: $useremail);
                return $user_id;
        }
    }
        return false; 
    } catch (Exception $e) {
        error_log("Error creating a new account : " . $e->getMessage());
        return false;

    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        
    }
}

function get_user_id($useremail)
{
    try {
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT user_id From `users` where email = ? ");
        $stmt->bind_param("s", $useremail);

        if (!$stmt->execute()) {
            throw new Exception("Query execution failed");
        }

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $userdata = $result->fetch_assoc();
            return $userdata["user_id"];
        }
        return false;

    } catch (Exception $e) {
        error_log(message: "Error creating a new account : " . $e->getMessage());
        return false;

    } finally {
        
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}

function is_addtional_info($user_id){
    try {
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT `birthdate` FROM `users` WHERE `user_id` = ? AND `birthdate` IS NOT NULL");
        $stmt->bind_param("i", $user_id);

        if (!$stmt->execute()) {
            throw new Exception("Query Execution Failed");
        }
        $result = $stmt->get_result();
        if ($result->num_rows > 0) { 
            return true;
        }
        return false;


    } catch (Exception $e) {
        error_log(message: "Check addtional information failed" . $e->getMessage());
    }finally {
       
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}
