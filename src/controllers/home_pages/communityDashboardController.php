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
        $events = getEventsByCommunity($communityId);

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

function manageMember($communityId, $memberId, $action)
{
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
                promoteMemberToCoreTeam($communityId, $memberId);
                break;
            default:
                throw new Exception("Invalid action");
        }
        return ['success' => true];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}


function postEvent($communityId, $memberId, $eventData)
{
    $roll = getUserRole($memberId, $communityId);
    if ($roll && ($roll == "core_member" || $roll == "admin")) {
        try {
            if (create_Event($communityId, $memberId, $eventData)) { //TODO: make a function to create a new Event in community Model
                return ["success" => true]; // TODO: call a function to reload the page
            };
        } catch (Exception $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    } else {
        return ["success" => false, "message" => "Unauthorized"];
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
