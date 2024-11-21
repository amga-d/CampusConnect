<?php
include("./functions.php");
include("db_conn.php");


session_start();
if (isset($_SESSION["username"])) {
  header("Location: ../index.php");
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
  elseif(!isEmailUniqu($useremail,$conn)){
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

    do {
      $user_id = generate_random_uid();
    } while (!(isIdUniqu($user_id, $conn)));
    

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (user_id,user_name,user_email,user_password) VALUES (?,?,?,?)");
    $stmt->bind_param("isss", $user_id, $username, $useremail, $hash);

    if ($stmt->execute()) {
      header("Location: ./signin.php");
      // echo "user Add with unique ID : {$user_id}";
    } else {
      echo "Error stmt" . $stmt->error;
    }
    $useremail = $username = $password = "";
  }

}
include("../../pages/signup.html");
