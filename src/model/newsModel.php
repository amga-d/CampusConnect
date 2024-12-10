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
// INSERT INTO news (news_name, description, news_image) VALUES ("Festival Qur'an UII 2024
// ","Yth. Mahasiswa

// di Lingkungan

// Universitas Islam Indonesia

 

// Assalamu’alaikum Warahmatullahi Wabarakatuh,

 

// Halo Sobat Minsis!

 

// Ada kabar seru nih buat kamu semua!  

// Universitas Islam Indonesia dengan bangga mempersembahkan Festival Qur'an UII 2024, ajang penuh inspirasi untuk menyalurkan bakat dan kecintaanmu pada Al-Qur'an. Yuk, ikuti berbagai rangkaian kegiatan menarik sesuai minatmu!  

 

// Jadwal Kegiatan:  

// - 25 November - 13 Desember 2024: Pendaftaran & Pengumpulan Karya  

// - 14 Desember 2024: Seleksi dan Penjurian  

// - 15 Desember 2024: Pengumuman Finalis  

// - 16 Desember 2024: Technical Meeting  

// - 22 Desember 2024: Pelaksanaan Final & Acara Puncak  

 

// Informasi & Pendaftaran:  

// Klik tautan berikut  [https://linktr.ee/FestivalQuranUII2024]

 

// Ayo daftarkan diri kamu sekarang juga dan jadilah bagian dari kemeriahan Festival Qur'an UII 2024! Jangan lewatkan kesempatan ini, ya! 

 

// Wassalamu’alaikum Warahmatullahi Wabarakatuh.

 

// Pertanyaan Layanan Kemahasiswaan:  

// Hubungi Call Center UII via WhatsApp di +62 898 444 1212  " , "\assets\img\news\festival_quran.jpg");