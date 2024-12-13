<!-- <?php
        // require_once __DIR__ . '/../../model/communitiesModel.php';
        session_start();

        // Dummy data for testing
        $dashboardData = [
            'community' => [
                'name' => 'Computer Science Club',
                'description' => 'A vibrant community for CS students to collaborate, learn, and grow together. Join us for coding challenges, workshops, and tech discussions!',
                'profile_image' => 'https://cdn-icons-png.flaticon.com/512/2721/2721620.png',
                'banner_image' => 'https://img.freepik.com/free-vector/gradient-technological-background_23-2148884155.jpg',
            ],
            'isAdmin' => true,
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
        ?> -->

<?php
require_once __DIR__ . '/../../model/communitiesModel.php';
session_start();
function getCommunityDetails($communityId)
{
    try {
        // Get basic community information
        $community = getCommunityById($communityId);
        if (!$community) {
            throw new Exception("Community not found");
        }
        // Check user's role in the community
        $role = getUserRole($$_SESSION['user_id'], $communityId);

        // Get community members
        $members = getCommunityMembers($communityId);

        // Get community posts/activities
        // $activities = getCommunityActivities($communityId);

        return [
            'community' => $community,
            'role' => $role,
            'members' => $members
            // 'activities' => $activities
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


function checkUserIsAdmin($user_id, $communityId){
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
