<?php
require_once __DIR__ . '/../../model/userModel.php';
session_start();

$username = getUserName($_SESSION['user_id']);
$userData = getUserCommunitiesAndEvents($_SESSION['user_id']);

if ($userData) {
    $communities = $userData['communities'];
    $events = $userData['events'];
} else {
    $communities = [];
    $events = [];
}