<?php

require_once __DIR__. '/../config/db_conn.php';
require_once __DIR__. '/../controllers/functions.php';

 

function isEmailUniqu($useremail)
{
    $conn = connect_db(); 
    $count = null;
    $stmt = $conn->prepare("SELECT COUNT(`email`) FROM `users` WHERE email = ?");
    $stmt->bind_param("s", $useremail);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    return $count === 0;
}


function signup($username,$useremail,$password){
    $conn = connect_db();
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
    $stmt->bind_param("sss", $username, $useremail, $hash);
  
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return true;
      // echo "user Add with unique ID : {$user_id}";
    } else {
        $stmt->close();
        $conn->close();
      return false;
    }
}


function authenticateLogin($useremail, $password)
{
    $conn = connect_db();
    $stmt = $conn->prepare("SELECT * FROM `users` where email = ? ");
    $stmt->bind_param("s", $useremail);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $conn->close();

    if ($result->num_rows > 0) 
    {
        $userdata = $result->fetch_assoc();
        if (password_verify($password, $userdata["password"])) 
        {
            $_SESSION["user_id"] = $userdata["user_id"];
            $useremail= $password="";
            return true;
        }
    }
    else 
    {
        return false;
    }
}


?>