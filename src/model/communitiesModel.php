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
function getCommunityDetails($community_id)
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
function createCommunity($community_data){
    $query = "INSERT INTO communities (community_name, community_type, description, profile_image, created_by, recruitment_status, created_at, community_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $conn = connect_db();
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssss", $community_data['community_name'], $community_data['community_type'], $community_data['description'], $community_data['profile_image'], $community_data['created_by'], $community_data['recruitment_status'], $community_data['created_at'], $community_data['community_id']);
    try{
        $stmt->execute();
        return true;
    }catch(Exception $e){
        error_log("Error creating community: " . $e->getMessage());
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
