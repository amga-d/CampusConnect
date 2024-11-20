<?php
session_start();
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $email =  filter_input(INPUT_POST,"email", FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        echo("$email is a valid email address");
      } else {
        echo("$email is not a valid email address");
      }

}
else{
    echo "dsfsd";
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>"
    method="post">
        <label>Email</label>
        <input type="text" name="email">
        <input type="submit" name="subimt" value="submit">
    </form>
</body>
</html>