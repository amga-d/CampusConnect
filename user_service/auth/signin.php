<?php
include("./functions.php");
include("./db_conn.php");

session_start();

if (isset($_SESSION["user_id"]))
{
    header("Location: ../../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{

    $useremail =  filter_input(INPUT_POST,"useremail", FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST,"password", FILTER_SANITIZE_SPECIAL_CHARS);

    if(!filter_var($useremail, FILTER_VALIDATE_EMAIL)=== false){
        if(!empty($password))
        {
            if (authenticateLogin($conn, $useremail, $password)) 
            {
                header("Location: ../../index.php");
                exit();
            }
            else
            {
                echo "Wrong Email or Password";
            }
        }
        else {
            echo "Enter Your Password";
        }
    }
    else
    {
        echo "Email in not a Valid Email Address";
    }
}


function authenticateLogin($conn, $useremail, $password)
{
    $stmt = $conn->prepare("SELECT * FROM `users` where user_email = ? ");
    $stmt->bind_param("s", $useremail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) 
    {
        $userdata = $result->fetch_assoc();
        if (password_verify($password, $userdata["user_password"])) 
        {
            $_SESSION["user_id"] = $userdata["user_id"];
            return true;
        }
    }
    else 
    {
        return false;
    }
}
include("../../pages/singin.html");

?>

