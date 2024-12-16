<?php require_once __DIR__ . '/../config/db_conn.php';

function getLatestNews()
{
    $conn = connect_db();

    try {
        $stmt = $conn->prepare(
            'SELECT
                news_name,
                description,
                created_at,
                news_image
            FROM news 
            ORDER BY 
            created_at DESC 
            LIMIT 20;'
        );
        if (!$stmt->execute()) {
            throw new Exception("Query execution failed");
        }
        $result = $stmt->get_result();
        return $result;
    } catch (Exception $e) {
        error_log('Error getting news: ' . $e->getMessage());
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
// ```
// CREATE TABLE news (
//     news_id INT AUTO_INCREMENT PRIMARY KEY,
//     news_name VARCHAR(255) NOT NULL,
//     description TEXT,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     news_image VARCHAR(255)
// );
// ```

function createNews()
{
    $conn = connect_db();
    try {
        $stmt = $conn->prepare("INSERT INTO news (news_name, description, news_image) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $news_name, $description, $news_image);
        if (!$stmt->execute()) {
            throw new Exception("Query execution failed");
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
// INSERT INTO news (news_name, description, news_image) VALUES ("","","")