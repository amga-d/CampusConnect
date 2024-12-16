<?php

require_once __DIR__ . '/../config/db_conn.php';
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '../../../logs/error.log');



function getCommunitiesNotIn($user_id){
    $query = "             SELECT
                   c.community_name, 
                    c.community_type,
                    c.description, 
                    c.profile_image, 
                    c.created_by, 
                    c.recruitment_status, 
                    c.created_at, 
                    c.community_id,
                    COUNT(cm.user_id) AS member_count
                FROM 
                    communities c 
                LEFT JOIN 
                    community_members cm
                ON
                    c.community_id = cm.community_id
                where 
                    c.community_id NOT IN (
                    SELECT community_id
                    FROM community_members
                    WHERE user_id = ?
                    )
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

function getUserRole($userId, $communityId) {
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
        if (isset($conn)) {
            $conn->close();
        }
    }
}

function getCommunityMembers($communityId) {
    try {
        $conn = connect_db();
        $stmt = $conn->prepare("
            SELECT 
                u.name, 
                cm.role, 
                cm.membership,
                cm.membership_status
                u.profile_image
            FROM 
                community_members cm
            JOIN 
                users u 
            ON 
                cm.user_id = u.id
            WHERE 
            cm.community_id = ?
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
                    c.community_id,
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
function getCommunityInfo($community_id)
{
    // Implement the logic to fetch community details from the database
    // qurey the community details from the database with the 
    $query = "SELECT * FROM communities WHERE community_id = ?";
    $conn = connect_db();
    try {
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $community_id);
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
function createCommunity($community_data, $user_id)
{
    $query = "INSERT INTO communities (
                    community_name,
                    community_type, 
                    description, 
                    profile_image, 
                    created_by, 
                    recruitment_status,
                    community_privacy)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
try {
    $conn = connect_db();
    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "ssssiss",
        $community_data['community_name'],
        $community_data['community_type'],
        $community_data['description'],
        $community_data['profile_image'],
        $community_data['creator_id'],
        $community_data['recruitment_status'],
        $community_data['privacy']
    );
    

        if (!$stmt->execute()) {
            throw new Exception('Query -INSERT NEW COMMUNIYT- Execution Failed ');
        }
        $last_id = $conn->insert_id;
        if (addAdmin($community_data['creator_id'], $last_id)) {
            return $last_id;
        } else {
            // handle deleting the community
            return false;
        }
    } catch (Exception $e) {
        error_log("Error creating community: " . $e->getMessage());
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

function addAdmin($user_id, $community_id) {
    $query = 
        "INSERT INTO community_members(
                                community_id,
                                user_id,
                                role,
                                membership,
                                membership_status) 
                                VALUES (?,?,?,?,?);
                                ";

    $conn = connect_db();
    try{
        $role = "admin";
        $membership ="Leader";
        $membership_status ="approved";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iisss", $community_id, $user_id,$role,$membership,$membership_status);
        
        if(!$stmt->execute()){
            throw new Exception("Query Execution Failed");
        };
        return true;
    }catch (Exception $e) {
        error_log("Error adding the admin to the new community". $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        if(isset($conn)) {
        $conn->close();
        }
    }
}
