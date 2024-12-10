<?php
require_once __DIR__ . '/../../model/newsModel.php';
require_once __DIR__ . '/../functions.php';

$news = [];

try{
    $result = getLatestNews();
    if($result === false){
        throw new Exception("Failed to fetch news");
    }
    if($result && $result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $news[] = $row;
        }
    }
    
}catch(Exception $e){
    error_log("News page error: " . $e->getMessage());
}


?> 