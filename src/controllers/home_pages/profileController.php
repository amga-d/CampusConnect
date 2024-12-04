<?php
require_once __DIR__ . '/../../model/profileModel.php';
require_once __DIR__ . '/../../config/db_connection.php';

class ProfileController {
    private $db;
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
        $this->db = connect_db();
    }

    public function getProfile() {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }
        
        return getUserProfile($_SESSION['user_id']);
    }

    public function updateProfile($data, $files = null) {
        if (!isset($_SESSION['user_id'])) {
            return [
                'success' => false,
                'message' => 'Unauthorized access'
            ];
        }

        try {
            // Validate inputs
            $this->validateInputs($data);

            // Handle profile image upload
            $profileImagePath = null;
            if ($files && isset($files['profile_image']) && $files['profile_image']['error'] === UPLOAD_ERR_OK) {
                $profileImagePath = $this->uploadProfileImage($files['profile_image']);
            }

            // Update profile
            $result = updateUserProfile(
                $_SESSION['user_id'],
                $data['email'],
                $data['gender'],
                $data['birthday'],
                $data['bio'],
                $profileImagePath
            );

            if (!$result) {
                throw new Exception('Failed to update profile');
            }

            return [
                'success' => true,
                'message' => 'Profile updated successfully',
                'profileImage' => $profileImagePath
            ];

        } catch (Exception $e) {
            error_log('Profile update error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    private function validateInputs($data) {
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format');
        }

        if (empty($data['gender']) || !in_array($data['gender'], ['Male', 'Female'])) {
            throw new Exception('Invalid gender');
        }

        if (!empty($data['birthday'])) {
            $date = DateTime::createFromFormat('Y-m-d', $data['birthday']);
            if (!$date || $date->format('Y-m-d') !== $data['birthday']) {
                throw new Exception('Invalid date format');
            }
        }

        if (strlen($data['bio']) > 1000) {
            throw new Exception('Bio is too long (maximum 1000 characters)');
        }
    }

    private function uploadProfileImage($file) {
        if (!isset(self::ALLOWED_TYPES[$file['type']])) {
            throw new Exception('Invalid file type');
        }

        if ($file['size'] > self::MAX_FILE_SIZE) {
            throw new Exception('File size exceeds limit');
        }

        $uploadDir = __DIR__ . '/../../public/uploads/profile_images/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $extension = self::ALLOWED_TYPES[$file['type']];
        $fileName = bin2hex(random_bytes(16)) . '.' . $extension;
        $uploadPath = $uploadDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            throw new Exception('Failed to upload file');
        }

        return 'uploads/profile_images/' . $fileName;
    }

    public function __destruct() {
        if ($this->db) {
            $this->db->close();
        }
    }
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new ProfileController();
    $response = $controller->updateProfile($_POST, $_FILES);
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}