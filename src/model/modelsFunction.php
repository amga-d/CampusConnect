<?php require_once __DIR__ . '/../config/db_conn.php';
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '../../../logs/error.log');

function getData($query, $paramsType, $params, $functionName)
{
    try {
        if (!$conn = connect_db()) {
            throw new Exception("Database Connection Failed");
        }
        $stmt = $conn->prepare($query);
        $stmt->bind_param($paramsType, ...$params);
        if (!$stmt->execute()) {
            throw new Exception("Query Exection Failed");
        }
        $result = $stmt->get_result();
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    } catch (Exception $e) {
        error_log("Error " . $functionName . " : " . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        if (isset($conn)) {
            $conn->close();
        }
    }
}

function getDataWithoutParams($query, $functionName)
{
    try {
        if (!$conn = connect_db()) {
            throw new Exception("Database Connection Failed");
        }
        $stmt = $conn->prepare($query);
        if (!$stmt->execute()) {
            throw new Exception("Query Exection Failed");
        }
        $result = $stmt->get_result();
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    } catch (Exception $e) {
        error_log("Error " . $functionName . " : " . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        if (isset($conn)) {
            $conn->close();
        }
    }
}

function insertData($query, $paramsType, $params, $functionName){
    $conn = connect_db();
    try {
        $stmt = $conn->prepare($query);
        $stmt->bind_param($paramsType, ... $params);
        if (!$stmt->execute()) {
            throw new Exception("INSERT QUERY Execution failed");
        }
        return true;
    } catch (Exception $e) {
        error_log('Error creating news: ' . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        if (isset($conn)) {
            $conn->close();
        }
    }
}


function deleteData($query, $paramsType, $params, $functionName){
    try {
        if (!$conn = connect_db()) {
            throw new Exception("Database Connection Failed");
        }
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param($paramsType, ...$params);
        if (!$stmt->execute()) {
            throw new Exception("DELETE Query Execution failed: " . $stmt->error);
        }
        // Check if any row was affected
        if ($stmt->affected_rows === 0) {
            throw new Exception("No matching record found to delete.");
        }
        return true;
    } catch (Exception $e) {
        error_log("Error " . $functionName . " : " . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        if (isset($conn)) {
            $conn->close();
        }
    }
}
