<?php

require_once __DIR__. '/../../model/signModel.php';

session_start();

if (isset($_SESSION["user_id"]))
{
    header("Location: /index.php");
    exit();
}

$emailerror = $passworderror = "";
$useremail="";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{

    $useremail =  filter_input(INPUT_POST,"useremail", FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST,"password", FILTER_SANITIZE_SPECIAL_CHARS);
    
    $valid_information= true; // True by defualt 
    if(empty($useremail)){
        $valid_information= false;
        $emailerror= "Enter Your Email";
    }
    elseif(filter_var($useremail, FILTER_VALIDATE_EMAIL)=== false){
        $valid_information= false;
        $emailerror= "Email in not a Valid Email Address";
    }
    
    if(empty($password)){
        $valid_information= false;
        $passworderror= "Enter Your Password";
    }
    elseif(strlen($password) < 8){
        $valid_information= false;
        $passworderror = "Password must be at least 8 characters";

    }

    if ($valid_information) {
        $user_id = authenticateLogin($useremail, $password);
        if(!empty($user_id)){
            $_SESSION["user_id"] = $user_id;
            $useremail= $password="";
            header("Location: /index.php");
            exit();
        }
        else{
            $passworderror= "Wrong Email or Password";
        }
    }
    
            
                
}


