<?php

ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../../logs/error.log');
require_once realpath(__DIR__ . "/../../vendor/autoload.php");

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . "/../../");
$dotenv->load();

$db_server = $_ENV['MYSQL_DB_HOST'];
$db_user = $_ENV['MYSQL_DB_USER'];
$db_pass = $_ENV['MYSQL_DB_PASSWORD'];
$db_name = $_ENV['MYSQL_DB_NAME'];


global $conn;
function connect_db()
{
    global $db_server, $db_user, $db_pass, $db_name ,$conn;
    // Check if the connection is not established yet
    if (!isset($conn)) {
        // Create the connection and log the message only once
        $conn = new mysqli($db_server, $db_user, $db_pass, $db_name);
        error_log("connect database");  // Log when the connection is first created

        // Check if the connection failed
        if ($conn->connect_error) {
            error_log('database connection failed:' . $conn->connect_error);
            die("Database connection failed, please try again " . $conn->connect_error);
        }
    }

    return $conn;
}
