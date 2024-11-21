<?php

function check_login()
{
    if (isset($_SESSION["user_id"])) {
        // echo "{$_SESSION["username"]}";
        return true;
    } else {

        header("Location: ./user_service/landingpage.php");
        return false;
    }
    die;
}

function check_login_without_redirecting()
{
    if (isset($_SESSION["user_id"])) {
        return true;
    } else {
        return false;
    }
}



function generate_random_uid()
{
    $UID = "";
    $len = rand(4, 19);
    for ($i = 0; $i < $len; $i++) {
        $UID .= rand(0, 9);
    }
    return $UID;
}

function isIdUniqu($user_id, $conn)
{
    $count = null;
    $stmt = $conn->prepare("SELECT COUNT(`user_id`) FROM `users` WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count === 0;
}

function isEmailUniqu($useremail, $conn)
{
    $count = null;
    $stmt = $conn->prepare("SELECT COUNT(`user_email`) FROM `users` WHERE user_email = ?");
    $stmt->bind_param("s", $useremail);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count === 0;
}