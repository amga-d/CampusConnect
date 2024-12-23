<?php
require_once __DIR__ . "/modelsFunction.php";

function getUserName($user_id){

    // $query = "INSERT INTO news (news_name, description, news_image) VALUES (?, ?, ?)";
    // $paramstype = "sss";
    // $params = [$data["news_name"], $data["description"], $data["news_image"]];
    try{

    
    $conn = connect_db();
    
    $stmt = $conn->prepare("SELECT `name` FROM `users` WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);

    if(!$stmt->execute()){
        throw new Exception("Query execution failed");
    }

    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
    return $user_data["name"];

    }catch(PDOException $e){
        error_log("Failed to get username".$e->getMessage());
    }finally{
        
        if(isset($stmt)){
            $stmt->close();
        }
    }
}

function getUserProfile($user_id){
    try{
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT `profile_image` FROM `users` WHERE `user_id` = ?");
        $stmt->bind_param("i", $user_id);

        if(!$stmt->execute()){
            throw new Exception("Query Execation Failed");
        }
        $stmt ->bind_result($profile_path);
        if($stmt->fetch()){
            return $profile_path;
        }

    }catch(PDOException $e){   
    error_log("".$e->getMessage());

    }finally{
    
    if(isset($stmt)){
        $stmt->close();
    }
    
    }
}

function createCommunity($community_data)
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
    
    }
}

function joinCommunity($user_id, $community_id){
    $query ="insert into community_members (community_id, user_id, role,membership) values (?,?,'member','member');";
    $conn = connect_db();
    try {
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $community_id, $user_id);

        if (!$stmt->execute()) {
            throw new Exception("Query Execution Failed");
        };
        return true;
    } catch (Exception $e) {
        error_log("Error adding the joining the new community" . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        
    }
}

function getUserCommunitiesAndEvents($user_id) {
    try {
        $conn = connect_db();
        
        // Query to get communities
        $communitiesQuery = "
            SELECT 
                c.community_id, 
                c.community_name, 
                c.description, 
                c.profile_image, 
                c.community_type,
                (SELECT COUNT(*) FROM community_members cm WHERE cm.community_id = c.community_id) AS member_count
            FROM communities c
            INNER JOIN community_members cm ON c.community_id = cm.community_id
            WHERE cm.user_id = ?
            GROUP BY c.community_id
        ";
        
        $stmt = $conn->prepare($communitiesQuery);
        $stmt->bind_param("i", $user_id);
        if (!$stmt->execute()) {
            throw new Exception("Query execution failed");
        }
        $communitiesResult = $stmt->get_result();
        $communities = $communitiesResult->fetch_all(MYSQLI_ASSOC);
        
        // Query to get events for these communities
        $eventsQuery = "
            SELECT 
                e.event_id, 
                e.event_name, 
                e.created_at, 
                c.profile_image AS community_image
            FROM events e
            INNER JOIN communities c ON e.community_id = c.community_id
            WHERE e.community_id IN (
                SELECT community_id
                FROM community_members
                WHERE user_id = ?
            )
            ORDER BY e.created_at ASC
        ";
        
        $stmt = $conn->prepare($eventsQuery);
        $stmt->bind_param("i", $user_id);
        if (!$stmt->execute()) {
            throw new Exception("Query execution failed");
        }
        $eventsResult = $stmt->get_result();
        $events = $eventsResult->fetch_all(MYSQLI_ASSOC);
        
        return ['communities' => $communities, 'events' => $events];
        
    } catch (Exception $e) {
        error_log("Failed to get communities and events: " . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}

?>