<?php
require_once __DIR__ . '/../../model/communitiesModel.php';
session_start();

function getCommunityDetails($communityId) {
    try {
        // Get basic community information
        $community = getCommunityById($communityId);
        if (!$community) {
            throw new Exception("Community not found");
        }

        // Check user's role in the community
        $isAdmin = checkUserIsAdmin($_SESSION['user_id'], $communityId);
        
        // Get community members
        $members = getCommunityMembers($communityId);
        
        // Get community posts/activities
        $activities = getCommunityActivities($communityId);
        
        return [
            'community' => $community,
            'isAdmin' => $isAdmin,
            'members' => $members,
            'activities' => $activities
        ];
    } catch (Exception $e) {
        error_log("Community Dashboard error: " . $e->getMessage());
        return false;
    }
}

// Admin-only functions
function updateCommunityDetails($communityId, $data) {
    if (!checkUserIsAdmin($_SESSION['user_id'], $communityId)) {
        return ['success' => false, 'message' => 'Unauthorized'];
    }
    
    try {
        $result = updateCommunity($communityId, $data);
        return ['success' => true];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

function manageMember($communityId, $memberId, $action) {
    if (!checkUserIsAdmin($_SESSION['user_id'], $communityId)) {
        return ['success' => false, 'message' => 'Unauthorized'];
    }
    
    try {
        switch ($action) {
            case 'add':
                addMemberToCommunity($communityId, $memberId);
                break;
            case 'remove':
                removeMemberFromCommunity($communityId, $memberId);
                break;
            case 'promote':
                promoteMemberToAdmin($communityId, $memberId);
                break;
            default:
                throw new Exception("Invalid action");
        }
        return ['success' => true];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

// Initialize dashboard data if community ID is provided
$dashboardData = null;
$error = null;

if (isset($_GET['id'])) {
    $dashboardData = getCommunityDetails($_GET['id']);
    if (!$dashboardData) {
        $error = "Failed to load community dashboard";
    }
}
