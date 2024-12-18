<?php
        require_once __DIR__ . '/../../model/dashboardModel.php';


        // Dummy data for testing
        $dashboardData = [
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

        // Get community announcements
        $announcements = getCommunityAnnouncements($communityId);

        // Get community events
        $events = getCommunityEvents($communityId);

        return [
            'community' => $community,
            'role' => $role,
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
// $dashboardData = null;
$error = null;
if (isset($_GET['community_id'])) {
    // $dashboardData = getCommunityDetails($_GET['community_id']);
    if (!$dashboardData) {
        $error = "Failed to load community dashboard";
    }
    // print_r(json_encode($dashboardData));
}
?>


<?php
// edit community controller

class CommunityController {
    private const ALLOWED_TYPES = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif'
    ];
    private const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function getCommunityDetails($communityId) {
        return getCommunityDetails($communityId);
    }

    public function updateCommunity($data, $files = null) {
        if (!isset($_SESSION['user_id'])) {
            return [
                'success' => false,
                'message' => 'Unauthorized access'
            ];
        }

        // Fetch community details to verify ownership
        $communityId = $data['community_id'] ?? null;
        if (!$communityId) {
            return [
                'success' => false,
                'message' => 'Invalid community ID'
            ];
        }

        $community = getCommunityDetails($communityId);
        if (!$community) {
            return [
                'success' => false,
                'message' => 'Community not found'
            ];
        }

        // Check if the current user is the owner
        if ($community['created_by'] != $_SESSION['user_id']) {
            return [
                'success' => false,
                'message' => 'You do not have permission to edit this community'
            ];
        }

        try {
            // Validate inputs
            $this->validateInputs($data);

            // Handle profile image upload
            $profileImagePath = null;
            if ($files && isset($files['community_image']) && $files['community_image']['error'] === UPLOAD_ERR_OK) {
                $profileImagePath = $this->uploadCommunityImage($files['community_image']);
            }

            // Update community
            $result = updateCommunityDetails(
                $communityId,
                $data['community_name'],
                $data['description'],
                $data['community_type'],
                $data['community_privacy'],
                $data['recruitment_status'],
                $profileImagePath
            );

            if (!$result) {
                throw new Exception('Failed to update community');
            }

            return [
                'success' => true,
                'message' => 'Community updated successfully',
                'profileImage' => $profileImagePath
            ];

        } catch (Exception $e) {
            error_log('Community update error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    private function validateInputs($data) {
        if (empty($data['community_name'])) {
            throw new Exception('Community name is required');
        }

        // Additional validations can be added here (e.g., description length)

        if (empty($data['community_type']) || !in_array($data['community_type'], ['academic', 'hobby', 'professional'])) {
            throw new Exception('Invalid community type');
        }

        if (empty($data['community_privacy']) || !in_array($data['community_privacy'], ['public', 'private'])) {
            throw new Exception('Invalid community privacy setting');
        }

        if (empty($data['recruitment_status']) || !in_array($data['recruitment_status'], ['open', 'closed'])) {
            throw new Exception('Invalid recruitment status');
        }
    }

    private function uploadCommunityImage($file) {
        if (!isset(self::ALLOWED_TYPES[$file['type']])) {
            throw new Exception('Invalid file type');
        }

        if ($file['size'] > self::MAX_FILE_SIZE) {
            throw new Exception('File size exceeds limit');
        }

        $uploadDir = __DIR__ . '/../../../public/uploads/community_images/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $extension = self::ALLOWED_TYPES[$file['type']];
        $fileName = bin2hex(random_bytes(16)) . '.' . $extension;
        $uploadPath = $uploadDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            throw new Exception('Failed to upload file');
        }

        return '/public/uploads/community_images/' . $fileName;
    }
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new CommunityController();
    $response = $controller->updateCommunity($_POST, $_FILES);

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>