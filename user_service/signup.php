<?php
include("./functions.php");
include("db_conn.php");

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



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Page</title>
  <link rel="stylesheet" href="../assets/styles/sign.css" />
</head>

<body>
  <form class="form"
    action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>"
    method="post">
    <div class="flex-column">
      <label>Name </label>
    </div>
    <div class="inputForm">
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="60" viewBox="0 0 22 60" fill="none">
        <path d="M7.5 31.25C8.49456 31.25 9.44839 30.8549 10.1517 30.1517C10.8549 29.4484 11.25 28.4946 11.25 27.5C11.25 26.5054 10.8549 25.5516 10.1517 24.8483C9.44839 24.1451 8.49456 23.75 7.5 23.75C6.50544 23.75 5.55161 24.1451 4.84835 24.8483C4.14509 25.5516 3.75 26.5054 3.75 27.5C3.75 28.4946 4.14509 29.4484 4.84835 30.1517C5.55161 30.8549 6.50544 31.25 7.5 31.25ZM1.25 38.75C1.25 38.75 0 38.75 0 37.5C0 36.25 1.25 32.5 7.5 32.5C13.75 32.5 15 36.25 15 37.5C15 38.75 13.75 38.75 13.75 38.75H1.25ZM13.75 25.625C13.75 25.4592 13.8158 25.3003 13.9331 25.1831C14.0503 25.0658 14.2092 25 14.375 25H19.375C19.5408 25 19.6997 25.0658 19.8169 25.1831C19.9342 25.3003 20 25.4592 20 25.625C20 25.7908 19.9342 25.9497 19.8169 26.0669C19.6997 26.1842 19.5408 26.25 19.375 26.25H14.375C14.2092 26.25 14.0503 26.1842 13.9331 26.0669C13.8158 25.9497 13.75 25.7908 13.75 25.625ZM14.375 28.75C14.2092 28.75 14.0503 28.8158 13.9331 28.9331C13.8158 29.0503 13.75 29.2092 13.75 29.375C13.75 29.5408 13.8158 29.6997 13.9331 29.8169C14.0503 29.9342 14.2092 30 14.375 30H19.375C19.5408 30 19.6997 29.9342 19.8169 29.8169C19.9342 29.6997 20 29.5408 20 29.375C20 29.2092 19.9342 29.0503 19.8169 28.9331C19.6997 28.8158 19.5408 28.75 19.375 28.75H14.375ZM16.875 32.5C16.7092 32.5 16.5503 32.5658 16.4331 32.6831C16.3158 32.8003 16.25 32.9592 16.25 33.125C16.25 33.2908 16.3158 33.4497 16.4331 33.5669C16.5503 33.6842 16.7092 33.75 16.875 33.75H19.375C19.5408 33.75 19.6997 33.6842 19.8169 33.5669C19.9342 33.4497 20 33.2908 20 33.125C20 32.9592 19.9342 32.8003 19.8169 32.6831C19.6997 32.5658 19.5408 32.5 19.375 32.5H16.875ZM16.875 36.25C16.7092 36.25 16.5503 36.3158 16.4331 36.4331C16.3158 36.5503 16.25 36.7092 16.25 36.875C16.25 37.0408 16.3158 37.1997 16.4331 37.3169C16.5503 37.4342 16.7092 37.5 16.875 37.5H19.375C19.5408 37.5 19.6997 37.4342 19.8169 37.3169C19.9342 37.1997 20 37.0408 20 36.875C20 36.7092 19.9342 36.5503 19.8169 36.4331C19.6997 36.3158 19.5408 36.25 19.375 36.25H16.875Z" fill="black" />
      </svg>
      <input type="text" class="input" name="username" placeholder="Enter your Name" />
    </div>
    <div class="flex-column">
      <label>Email </label>
    </div>
    <div class="inputForm">
      <svg
        height="20"
        viewBox="0 0 32 32"
        width="20"
        xmlns="http://www.w3.org/2000/svg">
        <g id="Layer_3" data-name="Layer 3">
          <path
            d="m30.853 13.87a15 15 0 0 0 -29.729 4.082 15.1 15.1 0 0 0 12.876 12.918 15.6 15.6 0 0 0 2.016.13 14.85 14.85 0 0 0 7.715-2.145 1 1 0 1 0 -1.031-1.711 13.007 13.007 0 1 1 5.458-6.529 2.149 2.149 0 0 1 -4.158-.759v-10.856a1 1 0 0 0 -2 0v1.726a8 8 0 1 0 .2 10.325 4.135 4.135 0 0 0 7.83.274 15.2 15.2 0 0 0 .823-7.455zm-14.853 8.13a6 6 0 1 1 6-6 6.006 6.006 0 0 1 -6 6z"></path>
        </g>
      </svg>
      <input type="text" class="input" name="email" placeholder="Enter your Email" />
    </div>

    <div class="flex-column">
      <label>Password </label>
    </div>
    <div class="inputForm">
      <svg
        height="20"
        viewBox="-64 0 512 512"
        width="20"
        xmlns="http://www.w3.org/2000/svg">
        <path
          d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0"></path>
        <path
          d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0"></path>
      </svg>
      <input type="password" class="input" name="password" placeholder="Enter your Password" />
    </div>

    <button class="button-submit" type="submit">Sign Up</button>
    <p class="p">Already have a account? <span class="span"><a href="signin.php">login</a></span></p>
    <div class="flex-row">
      <button class="btn google">
        <svg
          version="1.1"
          width="20"
          id="Layer_1"
          xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink"
          x="0px"
          y="0px"
          viewBox="0 0 512 512"
          style="enable-background:new 0 0 512 512;"
          xml:space="preserve">
          <path
            style="fill:#FBBB00;"
            d="M113.47,309.408L95.648,375.94l-65.139,1.378C11.042,341.211,0,299.9,0,256
    c0-42.451,10.324-82.483,28.624-117.732h0.014l57.992,10.632l25.404,57.644c-5.317,15.501-8.215,32.141-8.215,49.456
    C103.821,274.792,107.225,292.797,113.47,309.408z"></path>
          <path
            style="fill:#518EF8;"
            d="M507.527,208.176C510.467,223.662,512,239.655,512,256c0,18.328-1.927,36.206-5.598,53.451
    c-12.462,58.683-45.025,109.925-90.134,146.187l-0.014-0.014l-73.044-3.727l-10.338-64.535
    c29.932-17.554,53.324-45.025,65.646-77.911h-136.89V208.176h138.887L507.527,208.176L507.527,208.176z"></path>
          <path
            style="fill:#28B446;"
            d="M416.253,455.624l0.014,0.014C372.396,490.901,316.666,512,256,512
    c-97.491,0-182.252-54.491-225.491-134.681l82.961-67.91c21.619,57.698,77.278,98.771,142.53,98.771
    c28.047,0,54.323-7.582,76.87-20.818L416.253,455.624z"></path>
          <path
            style="fill:#F14336;"
            d="M419.404,58.936l-82.933,67.896c-23.335-14.586-50.919-23.012-80.471-23.012
    c-66.729,0-123.429,42.957-143.965,102.724l-83.397-68.276h-0.014C71.23,56.123,157.06,0,256,0
    C318.115,0,375.068,22.126,419.404,58.936z"></path>
        </svg>

        Google
      </button>
    </div>
  </form>

</body>

</html>