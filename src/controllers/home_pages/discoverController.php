<?php
require_once __DIR__ . '/../../model/communitiesModel.php';
session_start();
// Initialize an array to store communities data
$communities = [];


try {
    $communities = getCommunitiesNotIn($_SESSION['user_id']);
    if ($communities === false) {
        throw new Exception("Failed to fetch communities");
    }
    
    
} catch (Exception $e) {
    error_log("Discover page error: " . $e->getMessage());
}