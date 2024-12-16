<?php
        require_once __DIR__ . '/../../model/dashboardModel.php';

        // Dummy data for testing
        $dashboardDat1a = [
            'community' => [
                'name' => 'Computer Science Club',
                'description' => 'A vibrant community for CS students to collaborate, learn, and grow together. Join us for coding challenges, workshops, and tech discussions!',
                'profile_image' => 'https://cdn-icons-png.flaticon.com/512/2721/2721620.png',
                'banner_image' => 'https://img.freepik.com/free-vector/gradient-technological-background_23-2148884155.jpg',
            ],
            'role' => 'admin',
            'members' => [
                [
                    'name' => 'John Doe',
                    'role' => 'Admin',
                    'profile_image' => 'https://ui-avatars.com/api/?name=John+Doe'
                ],
                [
                    'name' => 'Alice Smith',
                    'role' => 'Member',
                    'profile_image' => 'https://ui-avatars.com/api/?name=Alice+Smith'
                ],
                [
                    'name' => 'Bob Johnson',
                    'role' => 'Member',
                    'profile_image' => 'https://ui-avatars.com/api/?name=Bob+Johnson'
                ]
            ],
            'activities' => [
                [
                    'author_name' => 'John Doe',
                    'author_image' => 'https://ui-avatars.com/api/?name=John+Doe',
                    'content' => 'Welcome to our new Python Workshop series! Join us every Thursday at 5 PM.',
                    'created_at' => '2024-12-09 15:30:00'
                ],
                [
                    'author_name' => 'Alice Smith',
                    'author_image' => 'https://ui-avatars.com/api/?name=Alice+Smith',
                    'content' => 'Just shared the slides from yesterday\'s Machine Learning presentation. Check them out in the resources section!',
                    'created_at' => '2024-12-08 14:20:00'
                ],
                [
                    'author_name' => 'Bob Johnson',
                    'author_image' => 'https://ui-avatars.com/api/?name=Bob+Johnson',
                    'content' => 'Looking for team members for the upcoming hackathon. DM if interested!',
                    'created_at' => '2024-12-07 09:45:00'
                ]
            ]
        ];

        $error = null;
        ?>

<?php
session_start();
function getCommunityDetails($communityId)
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
        $events = getCommunityEvents($communityId);

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
// Admin-only functions
function updateCommunityDetails($communityId, $data)
{
    if (!checkUserIsAdmin($_SESSION['user_id'], $communityId)) {
        return ['success' => false, 'message' => 'Unauthorized'];
    }

    try {
        $result = updateCommunity($communityId, $data); //TODO: make a function in communities model to handle updating image
        return ['success' => true];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
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

function postAnnouncement($communityId, $memberId, $announcementContent)
{
    $roll = getUserRole($memberId, $communityId);
    if ($roll && ($roll == "core_member" || $roll == "admin")) {
        try {
            if (create_announcement($communityId, $memberId, $announcementContent)) { //TODO: make a function to create a new announcement in community Model
                return ["success" => true];
            };
        } catch (Exception $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    } else {
        return ["success" => false, "message" => "Unauthorized"];
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
    $dashboardData = getCommunityDetails($_GET['community_id']);
    if (!$dashboardData) {
        $error = "Failed to load community dashboard";
    }
}


?>