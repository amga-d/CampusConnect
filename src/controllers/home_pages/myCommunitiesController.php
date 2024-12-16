<?php
require_once __DIR__ . '/../../model/communitiesModel.php';
session_start();
// Initialize an array to store communities data
$myCommunities = [];


try {
    $myCommunities = getMyCommunities($_SESSION['user_id']);
    // $result = getMyCommunities($_SESSION('user_id'));
    
    if ($myCommunities === false) {
        throw new Exception("Failed to fetch my communities");
    }
    
    // Check if we have results before trying to fetch them
    
} catch (Exception $e) {
    error_log("Discover page error: " . $e->getMessage());
}