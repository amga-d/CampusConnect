<?php

require_once __DIR__ . '/../config/db_conn.php';

function getCommunities()
{
    $query = "             SELECT
                   c.community_name, 
                    c.community_type,
                    c.description, 
                    c.profile_image, 
                    c.created_by, 
                    c.recruitment_status, 
                    c.created_at, 
                    COUNT(cm.user_id) AS member_count
                FROM 
                    communities c 
                LEFT JOIN 
                    community_members cm
                ON
                    c.community_id = cm.community_id
                GROUP BY 
                    c.community_id,
                    c.community_type,
                    c.community_name, 
                    c.description, 
                    c.profile_image, 
                    c.created_by, 
                    c.recruitment_status, 
                    c.created_at
                ORDER BY 
                    c.created_at DESC 
                LIMIT 20;";


    $conn = connect_db();
    try {
        $stmt = $conn->prepare($query);

        if (!$stmt->execute()) {
            throw new Exception("Query execution failed");
        }

        $result = $stmt->get_result();
        return $result;
    } catch (Exception $e) {
        error_log("Error fetching : " . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        if (isset($conn)) {
            $conn->close();
        }
    }
}

function getMyCommunities($user_id)
{
    $query = "
            SELECT
                c.community_name,
                c.community_id,
                c.description,
                c.profile_image,
                c.community_type,
                cm.membership,
                COUNT(cm.user_id) AS member_count
            FROM
                communities c
            LEFT JOIN community_members cm ON
                c.community_id = cm.community_id
            WHERE
                c.community_id IN (
                    SELECT community_id
                    FROM community_members
                    WHERE user_id = ?
                )
            GROUP BY
                
                c.community_name,
                c.community_id,
                c.description,
                c.profile_image,
                c.community_type;


    ;";

    $conn = connect_db();
    try {
        // Add LIMIT and ORDER BY for better performance and pagination
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);

        if (!$stmt->execute()) {
            throw new Exception("Query execution failed");
        }

        $result = $stmt->get_result();
        return $result;
    } catch (Exception $e) {
        error_log("Error fetching : " . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        if (isset($conn)) {
            $conn->close();
        }
    }
}

function getCommunityById($communityId) {
    try {
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT * FROM communities WHERE community_id = ?");
        $stmt->bind_param("i", $communityId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    } catch (Exception $e) {
        error_log("Error in getCommunityById: " . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        if (isset($conn)) {
            $conn->close();
        }
    }
}

function checkUserIsAdmin($userId, $communityId) {
    try {
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT role FROM community_members WHERE user_id = ? AND community_id = ?");
        $stmt->bind_param("ii", $userId, $communityId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row && $row['role'] === 'admin';
    } catch (Exception $e) {
        error_log("Error in checkUserIsAdmin: " . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        if (isset($conn)) {
            $conn->close();
        }
    }
}

function getCommunityMembers($communityId) {
    try {
        $conn = connect_db();
        $stmt = $conn->prepare("
            SELECT u.name, cm.role, u.profile_image 
            FROM community_members cm
            JOIN users u ON cm.user_id = u.id
            WHERE cm.community_id = ?
        ");
        $stmt->bind_param("i", $communityId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    } catch (Exception $e) {
        error_log("Error in getCommunityMembers: " . $e->getMessage());
        return [];
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        if (isset($conn)) {
            $conn->close();
        }
    }
}

function getCommunityActivities($communityId) {
    try {
        $conn = connect_db();
        $stmt = $conn->prepare("
            SELECT a.*, u.name as author_name, u.profile_image as author_image
            FROM activities a
            JOIN users u ON a.user_id = u.id
            WHERE a.community_id = ?
            ORDER BY a.created_at DESC
            LIMIT 10
        ");
        $stmt->bind_param("i", $communityId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    } catch (Exception $e) {
        error_log("Error in getCommunityActivities: " . $e->getMessage());
        return [];
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        if (isset($conn)) {
            $conn->close();
        }
    }
}
