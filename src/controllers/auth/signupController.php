<?php

require_once __DIR__. '/../../model/signModel.php';

session_start();

if (isset($_SESSION["user_id"])) {
  header("Location: /index.php");
  exit();
}
$useremail = $username = $password = "";
$nameerror = $passworderror = $emailerror = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $username = htmlspecialchars($_POST["username"]);
  $useremail = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
  $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
  $valid_information =true;

  if (empty($username)) {
    $valid_information = false;
    $nameerror = "Name is Required ";
  }elseif (is_numeric($username)) {
    $valid_information = false;
    $nameerror = "Name is not Valid ";
  }

  //
  if (empty($useremail)) {
    $valid_information = false;
    $emailerror = "Email is Required ";
  } elseif (filter_var($useremail, FILTER_VALIDATE_EMAIL) === false) {
    $valid_information = false;
    $emailerror = "Email in not a Valid Email Address";
  }
  elseif(!isEmailUniqu($useremail)){
    $valid_information = false;
    $emailerror = "Email Address is Used";
  }

  if (empty($password)) {
    $valid_information = false;
    "Password is Required ";
  }
  if (strlen($password) < 8) {
    $valid_information = false;
   $passworderror = "Password must be at least 8 characters";
  } 

  if ($valid_information) {
    $user_id = signup($username,$useremail,$password);
    if(!empty($user_id)){
      $_SESSION["user_id"] = $user_id;
      header("Location: /index.php");
      $useremail = $username = $password = "";
      exit();
    }
    else{
      echo "Something went wrong";
    }
  }

}

?>