<?php
require_once __DIR__ . '/../../model/dashboardModel.php';
ini_set('display_errors', 0);
ini_set('log_errors', 1);

session_start();
function initializeCommunityDashboard($communityId)
{
    try {
        // Get basic community information
        $community = getCommunityInfo($communityId);
        if (!$community) {
            throw new Exception("Community not found");
        }
        // Check user's role in the community
        $role = getUserRole($_SESSION['user_id'], $communityId);


        // Get community members
        $members = getCommunityMembers($communityId);

        // Get user profile
        $userprofile = getUserProfile($_SESSION['user_id']);
        // Get community announcements
        $announcements = getCommunityAnnouncements($communityId);

        // Get community events
        $events = getEvents($communityId);

        return [
            'community' => $community[0],
            'role' => $role,
            'profile' => $userprofile,
            'members' => $members,
            'announcements' => $announcements,
            'events' => $events
        ];
    } catch (Exception $e) {
        error_log("Community Dashboard error: " . $e->getMessage());
        return false;
    }
}




function checkUserIsAdmin($user_id, $communityId)
{
    return getUserRole($user_id, $communityId) == "admin";
}

// Initialize dashboard data if community ID is provided
$dashboardData = null;
$error = null;


if (isset($_GET['community_id'])) {
    $dashboardData = initializeCommunityDashboard($_GET['community_id']);
    if (!$dashboardData) {
        $error = "Failed to load community dashboard";
    }
}
