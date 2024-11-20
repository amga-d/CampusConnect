<?php
    // include("./db_conn.php");

    function check_login(){
        if(isset($_SESSION["user_id"])){
            // echo "{$_SESSION["username"]}";
            return true;
        }
        else{    
            header("Location: ./user_service/signin.php");
            return false;
        }
        die;
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