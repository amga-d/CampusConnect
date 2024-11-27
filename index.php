<?php
session_start();
require_once "./src/controllers/functions.php";

// Redirect to dashboard if logged in, otherwise to landing page
if (check_login_without_redirecting()) {
    header("Location: /src/view/dashboard.php");
} else {
    header("Location: /src/view/landingpage.php");
}
exit();


