<?php
include("./functions.php");
include("db_conn.php");
include("./");

session_start();
if (isset($_SESSION["username"])) {
  header("Location: ../index.php");
  exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = htmlspecialchars($_POST["username"]);
  $useremail = filter_input(INPUT_POST,"email", FILTER_SANITIZE_EMAIL);
  $password = filter_input(INPUT_POST,"password", FILTER_SANITIZE_SPECIAL_CHARS);



  if (!empty($username) && !empty($password) && !empty($useremail)){
    if (!is_numeric($username)) 
    {
      if (!filter_var($useremail, FILTER_VALIDATE_EMAIL)===false)
      {
        do{
          $user_id = generate_random_uid();
        }while(!(isIdUniqu($user_id, $conn)));
    
        $hash = password_hash($password,PASSWORD_DEFAULT);
    
        $stmt= $conn->prepare("INSERT INTO users (user_id,user_name,user_email,user_password) VALUES (?,?,?,?)");
        $stmt-> bind_param("isss",$user_id,$username,$useremail,$hash);
    
        if($stmt->execute()){
          header("Location: ./signin.php");
          // echo "user Add with unique ID : {$user_id}";
        }
        else{
          echo "Error stmt". $stmt ->error;
        }
      } 
      else {
        echo "Email in not a Valid Email Address";
      }    
    }
    else {
      echo "Enter A valid Name";
    }




  }
  else {
    echo "Enter your data";
  }
}

function isIdUniqu($user_id, $conn){
  $count = null;
  $stmt = $conn->prepare("SELECT COUNT(`user_id`) FROM `users` WHERE user_id = ?");
  $user_id = generate_random_uid();
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $stmt->bind_result($count);
  $stmt->fetch();
  $stmt->close();
  return $count === 0;
}

include("../../pages/signup.html");
?>
