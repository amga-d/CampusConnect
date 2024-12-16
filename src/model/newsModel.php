<?php require_once __DIR__ . "/modelsFunction.php";
function getLatestNews()
{
    $query = "SELECT
                news_name,
                description,
                created_at,
                news_image
            FROM news 
            ORDER BY 
            created_at DESC 
            LIMIT 20";
    return getDataWithoutParams($query, "getLatestNews");
}
function addNews($data)
{
    $query = "INSERT INTO news (news_name, description, news_image) VALUES (?, ?, ?)";
    $paramstype = "sss";
    $params = [$data["news_name"], $data["description"], $data["news_image"]];
    return insertData($query, $paramstype, $params, "aaddNews");

}
// INSERT INTO news (news_name, description, news_image) VALUES ("","","")