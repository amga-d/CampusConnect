<?php

require_once __DIR__ . '/../config/db_conn.php';
require_once __DIR__ . '/modelsFunction.php';
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../../logs/error.log');


function getCommunity($communityId)
{
    try {
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT * FROM communities WHERE community_id = ?");
        $stmt->bind_param("i", $communityId);
        if (!$stmt->execute()) {
            throw new Exception("Query Execution Failed");
        }
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    } catch (Exception $e) {
        error_log("Error in getCommunityById: " . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}

function getUserRole($userId, $communityId)
{

    try {
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT role FROM community_members WHERE user_id = ? AND community_id = ?");
        $stmt->bind_param("ii", $userId, $communityId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['role'];
    } catch (Exception $e) {
        error_log("Error in checkUserIsAdmin: " . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}

function getCommunityAnnouncements($communityId)
{
    $query = "SELECT 
    an.content,
    an.created_at,
    cm.membership,
    usr.name,
    usr.profile_image
FROM announcements an
INNER JOIN users usr ON an.user_id = usr.user_id
LEFT JOIN community_members cm ON an.community_id = cm.community_id AND cm.user_id = an.user_id
WHERE an.community_id = ?
ORDER BY an.created_at DESC;";
    try {
        $conn = connect_db();
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i",  $communityId);
        if (!$stmt->execute()) {
            throw new Exception("Query Execution Failed");
        }
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    } catch (Exception $e) {
        error_log("Error in getCommunityAnnouncements: " . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}

function getCommunityInfo($community_id)
{
    $query = "SELECT * FROM communities WHERE community_id = ?";
    $paramsType = "i";
    $params = [$community_id];

    return getData($query, $paramsType, $params, "getCommunityInfo");
}

function getCommunityMembers($communityId)
{
    $query = "SELECT 
                u.name, 
                cm.role, 
                cm.membership,
                cm.membership_status,
                u.profile_image
            FROM 
                community_members cm
            JOIN 
                users u 
            ON 
                cm.user_id = u.user_id
            WHERE 
            cm.community_id = ?
        ";
    $paramsType = "i";
    $params = [$communityId];
    return getData($query, $paramsType, $params, "getCommunityMember");
}

function getUserProfile($user_id)
{
    try {
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT `profile_image`,`name` FROM `users` WHERE `user_id` = ?");
        $stmt->bind_param("i", $user_id);

        if (!$stmt->execute()) {
            throw new Exception("Query Execation Failed");
        }
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        error_log("" . $e->getMessage());
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}
#edit community model

function getCommunityDetails($communityId): mixed
{
    $query = "SELECT * FROM communities WHERE community_id = ?";
    $paramstype = "i";
    $params = [$communityId];
    $result = getData($query, $paramstype, $params, "getCommunityDetails");
    return $result ? $result[0] : null;
}

function updateCommunityDetails($communityId, $name, $description, $type, $privacy, $recruitmentStatus, $profileImage = null)
{
    try {
        $conn = connect_db();

        // Check if community name is unique (if necessary)
        $queryCheck = "SELECT community_id FROM communities WHERE community_name = ? AND community_id != ?";
        $paramstypeCheck = "si";
        $paramsCheck = [$name, $communityId];
        $checkResult = getData($queryCheck, $paramstypeCheck, $paramsCheck, "checkCommunityName");

        if ($checkResult) {
            throw new Exception('Community name is already taken');
        }

        // Prepare base update query
        $updateQuery = "UPDATE communities SET 
            community_name = ?, 
            description = ?, 
            community_type = ?, 
            community_privacy = ?, 
            recruitment_status = ?";

        $params = [$name, $description, $type, $privacy, $recruitmentStatus];
        $types = "sssss";

        // Add profile image to update if provided
        if ($profileImage) {
            $updateQuery .= ", profile_image = ?";
            $params[] = $profileImage;
            $types .= "s";
        }

        $updateQuery .= " WHERE community_id = ?";
        $params[] = $communityId;
        $types .= "i";

        // Prepare and execute statement
        $stmt = $conn->prepare($updateQuery);
        if (!$stmt) {
            throw new Exception('Prepare failed: ' . $conn->error);
        }
        $stmt->bind_param($types, ...$params);
        $result = $stmt->execute();

        if (!$result) {
            throw new Exception('Execute failed: ' . $stmt->error);
        }

        return true;
    } catch (Exception $e) {
        error_log('Community update model error: ' . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}

function create_announcement($xommunity_id, $user_id, $contnet)
{
    try {
        $conn = connect_db();
        $stmt = $conn->prepare('INSERT INTO announcements (community_id, user_id, content) values (?,?,?)');
        $stmt->bind_param('iis', $xommunity_id, $user_id, $contnet);
        if (!$stmt->execute()) {
            throw new Exception('Query Execution Failed' . $stmt->error);
        }
        $annoId = $stmt->insert_id;
        return $annoId;
    } catch (Exception $e) {
        error_log('Error in create_accouncemet: ' . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}

function get_announcementById($announcement_id)
{
    $query = "SELECT 
                an.content,
                an.created_at,
                cm.membership,
                usr.name,
                usr.profile_image

            FROM announcements an
            INNER JOIN  community_members cm ON an.community_id = cm.community_id
            INNER JOIN  users usr ON an.user_id = usr.user_id
            WHERE an.announcement_id = ?";
    try {
        $conn = connect_db();
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i",  $announcement_id);
        if (!$stmt->execute()) {
            throw new Exception("Query Execution Failed");
        }
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    } catch (Exception $e) {
        error_log("Error in getAnnouncementsBy Id: " . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}

function createEvent($eventData)
{
    try {
        $conn = connect_db();

        $query = "INSERT INTO events (community_id, creator_id, event_name, description, image_path) 
                 VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param(
            "iisss",
            $eventData['community_id'],
            $eventData['creator_id'],
            $eventData['event_name'],
            $eventData['description'],
            $eventData['image_path']
        );

        if (!$stmt->execute()) {
            throw new Exception("Query Execution failed: " . $stmt->error);
        }
        return true;
    } catch (Exception $e) {
        error_log("Error in createEvent: " . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}
function getEvents($communityId)
{
    $query = "SELECT 
                ev.event_name, 
                ev.description,
                ev.created_at,
                ev.creator_id,
                ev.image_path,
                usr.name,
                usr.profile_image

            FROM events ev
            INNER JOIN  users usr ON ev.creator_id = usr.user_id
            WHERE ev.community_id = ?
            ORDER BY 
                    ev.created_at DESC
            ";
    try {
        $conn = connect_db();
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i",  $communityId);
        if (!$stmt->execute()) {
            throw new Exception("Query Execution Failed");
        }
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    } catch (Exception $e) {
        error_log("Error in get community events: " . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}



function removeMemberFromCommunity($communityId, $userId)
{
    $query = "DELETE FROM community_members WHERE community_id = ? AND user_id = ?";
    $paramsType = "ii";
    $params = [$communityId, $userId];
    return deleteData($query, $paramsType, $params, "removeMemberFromCommunity");
}

function findUserByEmail($email)
{
    try {
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    } catch (Exception $e) {
        error_log("Error in getUserByEmail: " . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}

function checkUserIsInCommunity($userId, $communityId)
{
    try {
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT user_id FROM community_members WHERE user_id = ? AND community_id = ?");
        $stmt->bind_param("ii", $userId, $communityId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    } catch (Exception $e) {
        error_log("Error in isUserInCommunity: " . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}

function addToCommunity($user, $communityId)
{
    $query = "insert into community_members (community_id, user_id, role,membership) values (?,?,'member','member');";
    $conn = connect_db();
    try {
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $communityId, $user);

        if (!$stmt->execute()) {
            throw new Exception("Query Execution Failed");
        };
        return true;
    } catch (Exception $e) {
        error_log("Error inviting user to join community" . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}
