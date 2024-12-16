<?php
require_once __DIR__ . '/../../model/communitiesModel.php';
session_start();
$user_id = $_SESSION["user_id"];


function getCommunityData($communityId) {
        try {
        // Fetch community details from the database
        $communityInfo  = getCommunityInfo($communityId)[0]; 
        if (!$communityInfo) {
            throw new Exception("Community not found");
        }
        $communityMember = getCommunityMembers($communityId);
        $communityEvent = getCommunityEvents($communityId);
        
        return [
            'info' => $communityInfo,
            'member'=> $communityMember,
            'event' => $communityEvent
        ];
    } catch (Exception $e) {
        error_log('Community View error :'. $e->getMessage());
        return false;
    }

}

// Get community ID from GET parameter
$communityId = isset($_GET['community_id']) ? $_GET['community_id'] : null;
$communityData = [];

if ($communityId) {
    $communityData = getCommunityData( $communityId );
    // The view will now have access to $community variable

    if (!$communityData) {
        echo "COMMUNITY IS NOT FOUND!";
    }
    // Handle case where community is not found
    if ($communityData === false) {
        echo "<div class='error-message'>Community not found</div>";
        throw new Exception("Failed to fetch communities");
    }
} else {
    // Handle case where no community ID is provided
    echo "<div class='error-message'>Invalid community ID</div>";
    exit;
}
?> 