<?php
require_once __DIR__ . "/modelsFunction.php";
require_once __DIR__ ."/../config/db_conn.php";

function getUserProfile($userId)
{  
    $query = "SELECT user_id, name, email, profile_image, bio, birthdate, gender, created_at FROM Users WHERE user_id = ?";
    $paramstype = "i";
    $params = [$userId];
    return getData($query,$paramstype,$params,"getUserProfile")[0];    

}

function updateUserProfile($userId, $email, $gender, $birthday, $bio, $profileImage = null)
{



    try {
        
        $query1 = "SELECT user_id FROM Users WHERE email = ? AND user_id != ?";
        $paramstype1 = "si";
        $params1 = [$email,$userId];
        $result =  getData($query1,$paramstype1,$params1,"checkEmail");    
        if (!$result){
            throw new Exception('Email is already taken');
        }

        $conn = connect_db();
        // Prepare base update query
        $updateQuery = "UPDATE Users SET 
            email = ?, 
            gender = ?, 
            birthdate = ?, 
            bio = ?";

        $params = [$email, $gender, $birthday, $bio];
        $types = "ssss";

        // Add profile image to update if provided
        if ($profileImage) {
            $updateQuery .= ", profile_image = ?";
            $params[] = $profileImage;
            $types .= "s";
        }

        $updateQuery .= " WHERE user_id = ?";
        $params[] = $userId;
        $types .= "i";

        // Prepare and execute statement1
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param($types, ...$params);
        $result = $stmt->execute();

        if (!$result) {
            throw new Exception($conn->error);
        }

        return true;
    } catch (Exception $e) {
        error_log('Profile update model error: ' . $e->getMessage());
        return false;
    }
    finally{
        if (isset($stmt)) {
            $stmt->close();
        }
        if (isset($conn)) {
            $conn->close();
        }
    }
}

function setUserProfile($userId, $gender,$bio, $birthday, $profileImage = null){
    $conn = connect_db();

    try{
        // Prepare base update query
        $updateQuery =" UPDATE users set 
        gender = ?,
        birthdate = ?,
        bio = ?";

        $params = [$gender, $birthday, $bio];
        $types = "sss";

        if($profileImage){
            $updateQuery .= ", profile_image = ?";
            $params[] = $profileImage;
            $types .= "s";
        }
        
        $updateQuery .= " WHERE user_id = ?";
        $params[] = $userId;
        $types .= "i";

        // Prepare and execute statement
        $stmt = $conn->prepare( $updateQuery );
        $stmt->bind_param($types, ...$params);
        $result = $stmt->execute();

        if (!$result) {
            echo"". $conn->error;
            throw new Exception($conn->error);
        }
        return true;

    }catch (Exception $e) {
        error_log('Profile update model error: ' . $e->getMessage());
        echo"". $e->getMessage();
        return false;
    }
    finally{
        if (isset($stmt)) {
            $stmt->close();
        }
        if (isset($conn)) {
            $conn->close();
        }
    }
}
