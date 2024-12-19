<?php
session_start();
require_once __DIR__ . '/../../model/dashboardModel.php';

header('Content-Type: application/json');

class EventController {
    public function createEvent() {
        // Check if request is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return json_encode(['success' => false, 'message' => 'Invalid request method']);
        }

        // Get session user ID and community ID
        $userId = $_SESSION['user_id'] ?? null;
        $communityId = $_POST['community_id'] ?? null;

        if (!$userId || !$communityId) {
            return json_encode(['success' => false, 'message' => 'Missing required data']);
        }

        // Validate user's role
        $role = getUserRole($userId, $communityId);
        if (!$role || ($role !== 'admin' && $role !== 'core_member')) {
            return json_encode(['success' => false, 'message' => 'Unauthorized']);
        }

        // Validate required fields
        if (empty($_POST['event_name']) || empty($_POST['description'])) {
            return json_encode(['success' => false, 'message' => 'Event name and description are required']);
        }

        // Handle image upload if present
        $imagePath = null;
        if (isset($_FILES['event_image']) && $_FILES['event_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../uploads/events/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileExtension = strtolower(pathinfo($_FILES['event_image']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($fileExtension, $allowedExtensions)) {
                return json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, JPEG, PNG and GIF are allowed']);
            }

            $fileName = uniqid('event_') . '.' . $fileExtension;
            $imagePath = '/uploads/events/' . $fileName; // Store the relative path in database
            $fullPath = $uploadDir . $fileName;

            if (!move_uploaded_file($_FILES['event_image']['tmp_name'], $fullPath)) {
                return json_encode(['success' => false, 'message' => 'Failed to upload image']);
            }
        }

        // Prepare event data
        $eventData = [
            'community_id' => $communityId,
            'creator_id' => $userId,
            'event_name' => $_POST['event_name'],
            'description' => $_POST['description'],
            'image_path' => $imagePath
        ];

        // Create event
        try {
            $result = createEvent($eventData);
            if ($result) {
                // Get user profile for response
                $userProfile = getUserProfile($userId);
                
                return json_encode([
                    'success' => true, 
                    'message' => 'Event created successfully',
                    'imagePath' => $imagePath,
                    'creatorName' => $userProfile['name'],
                    'creatorImage' => $userProfile['profile_image'],
                    'event' => $eventData
                ]);
            } else {
                return json_encode(['success' => false, 'message' => 'Failed to create event']);
            }
        } catch (Exception $e) {
            error_log("Error creating event: " . $e->getMessage());
            return json_encode(['success' => false, 'message' => 'An error occurred while creating the event']);
        }
    }

    public function getEvents($communityId) {
        try {
            $events = getEventsByCommunity($communityId);
            if ($events) {
                return json_encode([
                    'success' => true,
                    'events' => $events
                ]);
            } else {
                return json_encode([
                    'success' => false,
                    'message' => 'No events found'
                ]);
            }
        } catch (Exception $e) {
            error_log("Error getting events: " . $e->getMessage());
            return json_encode([
                'success' => false,
                'message' => 'Failed to retrieve events'
            ]);
        }
    }
}

// Handle the request
$controller = new EventController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo $controller->createEvent();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['community_id'])) {
    echo $controller->getEvents($_GET['community_id']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>