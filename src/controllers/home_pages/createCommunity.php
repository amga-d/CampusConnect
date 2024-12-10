<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '../../../logs/error.log');

require_once __DIR__ . '/../../model/communitiesModel.php';
session_start();

// if (!check_login()) {
//     header("Location: /src/view/auth/signin.php");
//     exit();
// }
header('Content-Type: application/json');
try {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('You must be logged in to create a community');
    }
    error_log('User is logged in.');

    // Validate required fields
    $requiredFields = ['community_name', 'community_type', 'description'];
    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            throw new Exception("$field is required");
        }
    }
    error_log('All required fields are present.');

    // Sanitize and prepare data
    $communityData = [
        'community_name' => htmlspecialchars($_POST['community_name']),
        'community_type' => htmlspecialchars($_POST['community_type']),
        'description' => htmlspecialchars($_POST['description']),
        'recruitment_status' => htmlspecialchars($_POST['recruitment_status'] ?? 'open'),
        'privacy' => htmlspecialchars($_POST['privacy'] ?? 'public'),
        'creator_id' => $_SESSION['user_id']
    ];

    // Handle image upload if present
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '../../../../public/uploads/community_images/';

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileInfo = pathinfo($_FILES['profile_image']['name']);
        $extension = strtolower($fileInfo['extension']);

        // Validate file type
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($extension, $allowedTypes)) {
            throw new Exception('Invalid file type. Only JPG, PNG, and GIF are allowed.');
        }

        // Generate unique filename
        $filename = uniqid() . '.' . $extension;
        $uploadPath = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadPath)) {
            $communityData['profile_image'] = '/public/uploads/community_images/' . $filename;
            error_log('Image uploaded successfully.');
        } else {
            throw new Exception('Failed to upload image');
        }
    } else {
        // Set default image
        $communityData['profile_image'] = '/public/uploads/community_images/default_community.png';
        error_log('Using default profile image.');
    }

    // Create the community
    $communityId = createCommunity($communityData ,$_SESSION["user_id"]);

    if ($communityId) {
        echo json_encode([
            'success' => true,
            'message' => 'Community created successfully',
            'community_id' => $communityId
        ]);
        error_log('Community created with ID: ' . $communityId);
    } else {
        throw new Exception('Failed to create community');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
    error_log('Error: ' . $e->getMessage());
    exit();
}
?>
