<?php
require_once __DIR__ . '/../../model/eventsModel.php';
require_once __DIR__ . '/../functions.php';

$events = [];

try{
    $events = getLatestEvents();
    if($events === false){
        throw new Exception("Failed to fetch events");
    }
    
    
}catch(Exception $e){
    error_log("events page error: " . $e->getMessage());
}


?> 