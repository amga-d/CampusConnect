<?php
require_once __DIR__ . '/../../model/communitiesModel.php';
session_start();

header('Content-Type: application/json');

try {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('You must be logged in to create a community');
    }

    // Validate required fields
    $requiredFields = ['community_name', 'community_type', 'description'];
    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            throw new Exception("$field is required");
        }
    }

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
        $uploadDir = __DIR__ . '/../../../assets/img/communities/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
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
            $communityData['profile_image'] = '/assets/img/communities/' . $filename;
        } else {
            throw new Exception('Failed to upload image');
        }
    } else {
        // Set default image
        $communityData['profile_image'] = '/assets/img/home/default_community.png';
    }

    // Create the community
    $communityId = createCommunity($communityData);

    if ($communityId) {
        echo json_encode([
            'success' => true,
            'message' => 'Community created successfully',
            'community_id' => $communityId
        ]);
    } else {
        throw new Exception('Failed to create community');
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 