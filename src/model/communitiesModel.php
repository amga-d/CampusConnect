<?php

require_once __DIR__ . '/../config/db_conn.php';

function getCommunities()
{
    $conn = connect_db();
    try {
        // Add LIMIT and ORDER BY for better performance and pagination
        $stmt = $conn->prepare("
                SELECT
                    c.community_name, 
                    c.description, 
                    c.profile_image, 
                    c.created_by, 
                    c.requirement_status, 
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
                    c.community_name, 
                    c.description, 
                    c.profile_image, 
                    c.created_by, 
                    c.requirement_status, 
                    c.created_at
                ORDER BY 
                    c.created_at DESC 
                LIMIT 20;

        ");

        if (!$stmt->execute()) {
            throw new Exception("Query execution failed");
        }

        $result = $stmt->get_result();
        return $result;
    } catch (Exception $e) {
        error_log("Error fetching communities: " . $e->getMessage());
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
