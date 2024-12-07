<?php

require_once realpath(__DIR__ . "/../../vendor/autoload.php");

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . "/../../");
$dotenv->load();
// Move credentials to a separate config file that's not in version control
$db_server = $_ENV['MYSQL_DB_HOST'];
$db_user = $_ENV['MYSQL_DB_USER'];
$db_pass = $_ENV['MYSQL_DB_PASSWORD'];
$db_name = $_ENV['MYSQL_DB_NAME'];

function connect_db()
{
    global $db_server, $db_user, $db_pass, $db_name;

        $conn = new mysqli($db_server,$db_user,$db_pass,$db_name);
        if($conn -> connect_error) {
            error_log('atabase connection failed:'. $conn -> connect_error);
            die("Database connection failed, please try again " . $conn->connect_error);
        }
        return $conn;

}
