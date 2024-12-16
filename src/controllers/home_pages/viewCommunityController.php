<?php
require_once __DIR__ . '/../../model/communitiesModel.php';

// Get community ID from GET parameter
$communityId = isset($_GET['community_id']) ? $_GET['community_id'] : null;

if ($communityId) {
    // Fetch community details from the database
    $community  = getCommunityInfo($communityId)[0]; // 

    if (!$community) {
        echo "COMMUNITY IS NOT FOUND!";
    }
    // Handle case where community is not found
    if ($community === false) {
        echo "<div class='error-message'>Community not found</div>";
        throw new Exception("Failed to fetch communities");
    }
    
    
    // The view will now have access to $community variable
} else {
    // Handle case where no community ID is provided
    echo "<div class='error-message'>Invalid community ID</div>";
    exit;
}
?> 