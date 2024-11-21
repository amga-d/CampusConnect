<?php

    function check_login(){
        if(isset($_SESSION["user_id"])){
            // echo "{$_SESSION["username"]}";
            return true;
        }
        else{    
            
            header("Location: ../landingpage.php");
            return false;
        }
        die;
    }

    function check_login_without_redirecting(){
        if(isset($_SESSION["user_id"])){
            return true;
        }
        else{
            return false;
        }
    }



    function generate_random_uid(){
        $UID ="";
        $len = rand(4,19);
        for($i = 0 ; $i < $len ; $i++){
            $UID .=rand(0,9);
        }
        return $UID;
    }
    

?>