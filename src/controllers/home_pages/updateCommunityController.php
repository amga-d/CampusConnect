<?php
// edit community controller
require_once __DIR__ . '/../../model/dashboardModel.php';
ini_set('display_errors', 0);
ini_set('log_errors', 1);
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