<?php require_once __DIR__ . "/modelsFunction.php";
function getLatestEvents()
{
    $query = "SELECT 
                ev.event_name, 
                ev.description,
                ev.created_at,
                ev.image_path,
                cm.community_name,
                cm.profile_image


            FROM events ev
            INNER JOIN  communities cm ON ev.community_id = cm.community_id
            ORDER BY 
                    ev.created_at DESC
            ";
    return getDataWithoutParams($query, "getLatestEvents");
}