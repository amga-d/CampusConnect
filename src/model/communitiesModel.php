<?php

require_once __DIR__ . "/modelsFunction.php";

function getCommunitiesNotIn($user_id)
{
    $query = "  SELECT
                   c.community_name, 
                    c.community_type,
                    c.description, 
                    c.profile_image, 
                    c.created_by, 
                    c.recruitment_status, 
                    c.created_at, 
                    c.community_id,
                    COUNT(cm.user_id) AS member_count
                FROM  communities c 
                LEFT JOIN community_members cm ON  c.community_id = cm.community_id
                WHERE  c.community_id NOT IN (
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
                ORDER BY c.created_at DESC 
                LIMIT 20;";

    $paramsType = "i";
    $params = [$user_id];

    return getData($query, $paramsType, $params, "getCommunitiesNotIn");
}
function getCommunityMembers($communityId)
{
    $query = "SELECT 
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
        ";
    $paramsType = "i";
    $params = [$communityId];
    return getData($query, $paramsType, $params, "getCommunityMember");
}

function getAllCommunities()
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
    $query = "SELECT
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
    $paramstype = "i";
    $param = [$user_id];
    return getData($query, $paramstype, $param, "getMyCommunities");
}
function getCommunityInfo($community_id)
{
    $query = "SELECT * FROM communities WHERE community_id = ?";
    $paramsType = "i";
    $params = [$community_id];

    return getData($query, $paramsType, $params, "getCommunityInfo");
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

function addAdmin($user_id, $community_id)
{
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
    try {
        $role = "admin";
        $membership = "Leader";
        $membership_status = "approved";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iisss", $community_id, $user_id, $role, $membership, $membership_status);

        if (!$stmt->execute()) {
            throw new Exception("Query Execution Failed");
        };
        return true;
    } catch (Exception $e) {
        error_log("Error adding the admin to the new community" . $e->getMessage());
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
