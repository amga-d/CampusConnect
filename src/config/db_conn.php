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

function connect_db() {
    global $db_server, $db_user, $db_pass, $db_name;
    
    try {
        $conn = mysqli_connect(
            $db_server,
            $db_user,
            $db_pass,
            $db_name
        );
        
        if (!$conn) {
            throw new mysqli_sql_exception("Connection failed: " . mysqli_connect_error());
        }
        
        // Set charset to prevent SQL injection
        $conn->set_charset("utf8mb4");
        
        return $conn;
    } catch (mysqli_sql_exception $e) {
        // Log error securely instead of displaying it
        error_log("Database connection failed: " . $e->getMessage());
        // Return generic error to user
        die("Database connection error. Please try again later.");
    }
}
