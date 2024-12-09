<?php
require_once __DIR__ . '/../../model/communitiesModel.php';

// Initialize an array to store communities data
$communities = [];


try {
    $result = getCommunities();
    
    if ($result === false) {
        throw new Exception("Failed to fetch communities");
    }
    
    // Check if we have results before trying to fetch them
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $communities[] = $row;
        }
    }
    
} catch (Exception $e) {
    error_log("Discover page error: " . $e->getMessage());
}