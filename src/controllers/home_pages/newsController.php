<?php
require_once __DIR__ . '/../../model/newsModel.php';
require_once __DIR__ . '/../functions.php';

$news = [];

try{
    $news = getLatestNews();
    if($news === false){
        throw new Exception("Failed to fetch news");
    }
    
    
}catch(Exception $e){
    error_log("News page error: " . $e->getMessage());
}


?> 