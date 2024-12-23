<?php
// edit community controller
require_once __DIR__ . '/../../model/dashboardModel.php';
ini_set('display_errors', 0);
ini_set('log_errors', 1);
class communityAdmin
{
    private const ALLOWED_TYPES = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif'
    ];
    private const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function getCommunityDetails($communityId)
    {
        return getCommunityDetails($communityId);
    }

    public function updateCommunity($data, $files = null)
    {
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

    private function validateInputs($data)
    {
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

    private function uploadCommunityImage($file)
    {
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

    public function postAnnouncement($data)
    {
        if (!isset($_SESSION['user_id'])) {
            return [
                'success' => false,
                'message' => "unauthorized access"
            ];
        }

        try {
            // create_announcement($data['community_id'], $_SESSION('user_id'), $data['announcementContnet']);
            $result = create_announcement($data['community_id'], $_SESSION['user_id'], $data['announcementContnet']);

            if (!$result) {
                throw new Exception('Failed To Post Annoucement');
            }
            $AnnouncementData = get_announcementById($result);
            return [
                'success' => true,
                'message' => 'Announcement is Successfully Posted',
                'newAnnouncement' => $AnnouncementData
            ];
        } catch (Exception $e) {
            error_log("Core Member class" . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    public function postEvent($data, $file)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return (['success' => false, 'message' => 'Invalid request method']);
        }

        $userId = $_SESSION['user_id'] ?? null;
        $communityId = $data['community_id'] ?? null;

        if (!$userId || !$communityId) {
            return (['success' => false, 'message' => 'Missing required data']);
        }

        $role = getUserRole($userId, $communityId);
        if (!$role || ($role !== 'admin' && $role !== 'core_member')) {
            return (['success' => false, 'message' => 'Unauthorized']);
        }

        if (empty($data['event_name']) || empty($data['description'])) {
            return (['success' => false, 'message' => 'Event name and description are required']);
        }

        // Handle image upload if present
        $imagePath = null;
        if (isset($file['event_image']) && $file['event_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../../public/uploads/events/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileExtension = strtolower(pathinfo($file['event_image']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($fileExtension, $allowedExtensions)) {
                return (['success' => false, 'message' => 'Invalid file type. Only JPG, JPEG, PNG and GIF are allowed']);
            }

            $fileName = uniqid('event_') . '.' . $fileExtension;
            $fullPath = $uploadDir . $fileName;
            $imagePath = "/public/uploads/events/" . $fileName;

            if (!move_uploaded_file($file['event_image']['tmp_name'], $fullPath)) {
                return (['success' => false, 'message' => 'Failed to upload image']);
            }

            $eventData = [
                'community_id' => $communityId,
                'creator_id' => $userId,
                'event_name' => $data['event_name'],
                'description' => $data['description'],
                'image_path' => $imagePath
            ];

            // Create event
            try {
                $result = createEvent($eventData);
                if ($result) {
                    // Get user profile for response
                    $userProfile = getUserProfile($userId);

                    return ([
                        'success' => true,
                        'message' => 'Event created successfully',
                        'imagePath' => $imagePath,
                        'creatorName' => $userProfile['name'],
                        'creatorImage' => $userProfile['profile_image'],
                        'event' => $eventData
                    ]);
                } else {
                    return (['success' => false, 'message' => 'Failed to create event']);
                }
            } catch (Exception $e) {
                error_log("Error creating event: " . $e->getMessage());
                return (['success' => false, 'message' => 'An error occurred while creating the event']);
            }
        }
    }


    public function manageMemeber($data) {}

    public function invite($data)
    { {
            if (!isset($_SESSION['user_id'])) {
                return [
                    'success' => false,
                    'message' => 'Unauthorized access'
                ];
            }

            // Retrieve and validate the community_id from POST data
            if (!isset($data['community_id'])) {
                return [
                    'success' => false,
                    'message' => 'Community ID not provided.'
                ];
            }

            $communityId = intval($data['community_id']);
            if ($communityId <= 0) {
                return [
                    'success' => false,
                    'message' => 'Invalid Community ID.'
                ];
            }

            $userId = $_SESSION['user_id'];

            // Check if the user is a member of the community
            $role = getUserRole($userId, $communityId);
            if (!$role) {
                return [
                    'success' => false,
                    'message' => 'You are not a member of this community.'
                ];
            }

            if ($role != "admin") {
                return [
                    'success' => false,
                    'message' => 'Unauthorized access.'
                ];
            }
            $user = findUserByEmail($data["inviteEmail"])["user_id"];
            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'Email not found.'
                ];
            }

            // Check if the user is already a member of the community
            if (checkUserIsInCommunity($user, $communityId)) {
                return [
                    'success' => false,
                    'message' => 'User is already a member of this community. '
                ];
            }

            if(addToCommunity($user,$communityId)){
                return [
                    'success' => true,
                    'message' => 'User invited successfully.'
                ];
            }
            else{
                return [
                    'success' => false,
                    'message' => 'Fialed to invite'. $data["inviteEmail"] .$user .$communityId
                ];
            }

            
            
        }
    }
}

// function inviteUserToCommunity($email, $communityId)
// {
//     // Check if the email exists
//     $user = getUserByEmail($email);
//     if (!$user) {
//         return [
//             'success' => false,
//             'message' => 'Email not found.'
//         ];
//     }

//     $userId = $user['user_id'];

//     // Check if the user is already a member of the community
//     if (isUserInCommunity($userId, $communityId)) {
//         return [
//             'success' => false,
//             'message' => 'User is already a member of this community.'
//         ];
//     }

//     // Proceed to invite the user to the community
//     // Add your invite logic here

//     return [
//         'success' => true,
//         'message' => 'User invited successfully.'
//     ];
// }

class communityMember
{
    public function leaveCommunity($data)
    {
        if (!isset($_SESSION['user_id'])) {
            return [
                'success' => false,
                'message' => 'Unauthorized access'
            ];
        }

        // Retrieve and validate the community_id from POST data
        if (!isset($data['community_id'])) {
            return [
                'success' => false,
                'message' => 'Community ID not provided.'
            ];
        }

        $communityId = intval($data['community_id']);
        if ($communityId <= 0) {
            return [
                'success' => false,
                'message' => 'Invalid Community ID.'
            ];
        }

        $userId = $_SESSION['user_id'];

        // Check if the user is a member of the community
        $role = getUserRole($userId, $communityId);
        if (!$role) {
            return [
                'success' => false,
                'message' => 'You are not a member of this community.'
            ];
        }

        // Proceed to remove the user from the community
        $result = removeMemberFromCommunity($communityId, $userId);
        if ($result) {
            return [
                'success' => true,
                'message' => 'Successfully left the community.'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Failed to leave the community. Please try again.'
            ];
        }
    }

    function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}

class communityCoreMember
{
    public function postAnnouncement($data)
    {
        if (!isset($_SESSION['user_id'])) {
            return [
                'success' => false,
                'message' => "unauthorized access"
            ];
        }

        try {
            // create_announcement($data['community_id'], $_SESSION('user_id'), $data['announcementContnet']);
            $result = create_announcement($data['community_id'], $_SESSION['user_id'], $data['announcementContnet']);

            if (!$result) {
                throw new Exception('Failed To Post Annoucement');
            }
            $AnnouncementData = get_announcementById($result);
            return [
                'success' => true,
                'message' => 'Announcement is Successfully Posted',
                'newAnnouncement' => $AnnouncementData
            ];
        } catch (Exception $e) {
            error_log("Core Member class" . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    public function postEvent($data, $file)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return (['success' => false, 'message' => 'Invalid request method']);
        }

        $userId = $_SESSION['user_id'] ?? null;
        $communityId = $data['community_id'] ?? null;

        if (!$userId || !$communityId) {
            return (['success' => false, 'message' => 'Missing required data']);
        }

        $role = getUserRole($userId, $communityId);
        if (!$role || ($role !== 'admin' && $role !== 'core_member')) {
            return (['success' => false, 'message' => 'Unauthorized']);
        }

        if (empty($data['event_name']) || empty($data['description'])) {
            return (['success' => false, 'message' => 'Event name and description are required']);
        }

        // Handle image upload if present
        $imagePath = null;
        if (isset($file['event_image']) && $file['event_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../../public/uploads/events/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileExtension = strtolower(pathinfo($file['event_image']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($fileExtension, $allowedExtensions)) {
                return (['success' => false, 'message' => 'Invalid file type. Only JPG, JPEG, PNG and GIF are allowed']);
            }

            $fileName = uniqid('event_') . '.' . $fileExtension;
            $fullPath = $uploadDir . $fileName;
            $imagePath = "/public/uploads/events/" . $fileName;

            if (!move_uploaded_file($file['event_image']['tmp_name'], $fullPath)) {
                return (['success' => false, 'message' => 'Failed to upload image']);
            }

            $eventData = [
                'community_id' => $communityId,
                'creator_id' => $userId,
                'event_name' => $data['event_name'],
                'description' => $data['description'],
                'image_path' => $imagePath
            ];

            // Create event
            try {
                $result = createEvent(eventData: $eventData);
                if ($result) {
                    // Get user profile for response
                    $userProfile = getUserProfile($userId);

                    return ([
                        'success' => true,
                        'message' => 'Event created successfully',
                        'imagePath' => $imagePath,
                        'creatorName' => $userProfile['name'],
                        'creatorImage' => $userProfile['profile_image'],
                        'event' => $eventData
                    ]);
                } else {
                    return (['success' => false, 'message' => 'Failed to create event']);
                }
            } catch (Exception $e) {
                error_log("Error creating event: " . $e->getMessage());
                return (['success' => false, 'message' => 'An error occurred while creating the event']);
            }
        }
    }

    public function leaveCommunity($data)
    {
        if (!isset($_SESSION['user_id'])) {
            return [
                'success' => false,
                'message' => 'Unauthorized access'
            ];
        }

        // Retrieve and validate the community_id from POST data
        if (!isset($data['community_id'])) {
            return [
                'success' => false,
                'message' => 'Community ID not provided.'
            ];
        }

        $communityId = intval($data['community_id']);
        if ($communityId <= 0) {
            return [
                'success' => false,
                'message' => 'Invalid Community ID.'
            ];
        }

        $userId = $_SESSION['user_id'];

        // Check if the user is a member of the community
        $role = getUserRole($userId, $communityId);
        if (!$role) {
            return [
                'success' => false,
                'message' => 'You are not a member of this community.'
            ];
        }

        // Proceed to remove the user from the community
        $result = removeMemberFromCommunity($communityId, $userId);
        if ($result) {
            return [
                'success' => true,
                'message' => 'Successfully left the community.'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Failed to leave the community. Please try again.'
            ];
        }
    }


    // public function invite(){}
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['role'] == "admin") {

        $controller = new communityAdmin();
        switch ($_POST['action']) {
            case 'updateCommunity':
                $response = $controller->updateCommunity($_POST, $_FILES);
                break;
            case 'postAnnouncement':
                $response = $controller->postAnnouncement($_POST);
                break;
            case 'postEvent':
                $response = $controller->postEvent($_POST, $_FILES);
                break;
            case 'manageMemeber':
                $response = $controller->manageMemeber($_POST);
                break;
            case 'invite';
                $response = $controller->invite($_POST);
                break;
            default;
                $response = [
                    'success' => false,
                    'message' => 'undefinded action'
                ];
                break;
        }
    } elseif ($_POST['role'] == 'core_member') {

        $controller = new communityCoreMember();
        $response = [
            'success' => false,
            'message' => 'undefinded action'
        ];
        switch ($_POST['action']) {
            case 'postEvent':
                $response = $controller->postEvent($_POST, $_FILES);
                break;
            case 'postAnnouncement':
                $response = $controller->postAnnouncement($_POST);
                break;
            case 'leaveCommunity':
                $response = $controller->leaveCommunity($_POST);
                break;
            default;
                break;
        }
    } elseif ($_POST['role'] == 'member') {

        $controller = new communityMember();
        switch ($_POST['action']) {
            case 'leaveCommunity':
                $response = $controller->leaveCommunity($_POST);
                break;
            default:
                $response = [
                    'success' => false,
                    'message' => 'Undefined action ' . $_POST['action']
                ];
                break;
        }
    } else {
        $response = [
            'success' => false,
            'message' => 'Unauthorized access'
        ];
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
