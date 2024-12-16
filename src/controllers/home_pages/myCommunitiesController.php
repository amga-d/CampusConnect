<?php
require_once __DIR__ . '/../../model/communitiesModel.php';
session_start();
// Initialize an array to store communities data
$myCommunities = [];


try {
    $result = getMyCommunities($_SESSION['user_id']);
    // $result = getMyCommunities($_SESSION('user_id'));
    
    if ($result === false) {
        throw new Exception("Failed to fetch my communities");
    }
    
    // Check if we have results before trying to fetch them
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $myCommunities[] = $row;
        }
    }
    
} catch (Exception $e) {
    error_log("Discover page error: " . $e->getMessage());
}