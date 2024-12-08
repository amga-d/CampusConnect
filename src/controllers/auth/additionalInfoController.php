<?php session_start();

require_once __DIR__ .'/../functions.php';
require_once __DIR__ .'/../../model/profileModel.php';

if (!check_login()) {
    header("Location: /src/view/auth/signin.php");
    exit();
}

const ALLOWED_TYPES = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/gif'  => 'gif'
];
const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB

if ($_SERVER['REQUEST_METHOD'] === "POST"){
    updateProfile($_POST , $_FILES);
}

function updateProfile($data , $file = null){

    validateInputs($data);

    $profileImagePath = null;
    if ($file && isset($file['profile_image']) && $file['profile_image']['error'] === UPLOAD_ERR_OK){
        $profileImagePath = uploadProfileImage(file: $file['profile_image']);

    }

    $result = setUserProfile(
        $_SESSION['user_id'],
        $data['gender'],
        $data['bio'],
        $data['birthday'],
        $profileImagePath
    );
    if ($result){
        header('Location: /index.php');
    }
    else {
    echo '<script>alert("There was a problem while updating data.");</script>';
    }
    
}

function uploadProfileImage($file){
    try {

    if (!isset(ALLOWED_TYPES[$file['type']])) {
        throw new Exception('Invalid file type');
    }
    if ($file['size'] > MAX_FILE_SIZE) {
        throw new Exception('File size exceeds limit');
    }
    
    $uploadDir = __DIR__.'/../../../public/uploads/profile_images/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $extension = ALLOWED_TYPES[$file['type']];
    $fileName = bin2hex(random_bytes(16)) . '.' . $extension;
    $uploadPath = $uploadDir . $fileName;

    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        throw new Exception('Failed to upload file');
    }
    
    return '/public/uploads/profile_images/' . $fileName;
} catch (Exception $e) {
    echo 'sdfasfsdfsf'. $e->getMessage();
    
}

}

function validateInputs($data){
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


?>
