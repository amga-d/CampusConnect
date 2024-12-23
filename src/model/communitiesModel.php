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
                AND community_privacy = 'public'
                GROUP BY 
                    c.community_id,
                    c.community_type,
                    c.community_name, 
                    c.description, 
                    c.profile_image, 
                    c.created_by, 
                    c.recruitment_status, 
                    c.created_at
                ORDER BY c.community_name ASC 
                ";

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

function getCommunityEvents($communityId)
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
    (SELECT cm.membership 
     FROM community_members cm 
     WHERE cm.community_id = c.community_id 
     AND cm.user_id = ?) AS membership,
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
    c.community_type
;";
    $paramstype = "ii";
    $param = [$user_id,$user_id];
    return getData($query, $paramstype, $param, "getMyCommunities");
}
function getCommunityInfo($community_id)
{
    $query = "SELECT community_id, community_name, description,profile_image,recruitment_status,community_type  FROM communities WHERE community_id = ? and community_privacy = 'public'";
    $paramsType = "i";
    $params = [$community_id];

    return getData($query, $paramsType, $params, "getCommunityInfo");
}

function isCommunityOpen($community_id)
{

    $query = " Select 
                recruitment_status 
                from communities 
                where community_id = ?;";
    try {
        $conn = connect_db();

        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $community_id);
        if (!$stmt->execute()) {
            throw new Exception("Query Execution Failed");
        }
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            if ($result->fetch_assoc()["recruitment_status"] == "open") {
                return true;
            }
        }
        return false;
    } catch (Exception $e) {
        error_log("Is Community Open" . $e->getMessage());
        return false;
    }
}

function isUserInCommunity($user_id, $community_id)
{
    $query = " select joined_at from community_members where community_id = ? and user_id = ?";
    try {
        $conn = connect_db();

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $community_id, $user_id);
        if (!$stmt->execute()) {
            throw new Exception("Query Execution Failed");
        }
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        error_log("Is Community Open" . $e->getMessage());
        return false;
    }
}


function removeMemberFromCommunity($communityId, $userId)
{
    $query = "DELETE FROM Community_Members WHERE community_id = ? AND user_id = ?";
    $paramsType = "ii";
    $params = [$communityId, $userId];
    return deleteData($query, $paramsType, $params, "removeMemberFromCommunity");
}
