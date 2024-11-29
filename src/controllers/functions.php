<?php

function check_login()
{
    if (isset($_SESSION["user_id"])) {
        // echo "{$_SESSION["username"]}";""
        return true;
    } else {
        header("Location: /src/view/auth/signin.php");
        return false;
    }
}

function check_login_without_redirecting()
{
    if (isset($_SESSION["user_id"])) {
        return true;
    } else {
        return false;
    }
}

// function isIdUniqu($user_id, $conn)
// {
//     $count = null;
//     $stmt = $conn->prepare("SELECT COUNT(`user_id`) FROM `users` WHERE user_id = ?");
//     $stmt->bind_param("i", $user_id);
//     $stmt->execute();
//     $stmt->bind_result($count);
//     $stmt->fetch();
//     $stmt->close();
//     return $count === 0;
// }

