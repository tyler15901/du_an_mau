<?php

// Hàm kết nối MySQL qua PDO (OOP style, dùng cho model query DB)
// Sử dụng biến môi trường từ env.php (ví dụ: define('DB_HOST', 'localhost'); define('DB_NAME', 'du_an_mau'); v.v.)
function connect_db() {
    try {
        // Tạo DSN (Data Source Name) từ biến môi trường
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        
        // Tạo object PDO với user/pass, set attribute để báo lỗi exception (dễ debug)
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Bật chế độ báo lỗi chi tiết
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Fetch data kiểu array associative (dễ dùng trong model)
        
        return $pdo; // Trả về $pdo nếu connect thành công
    } catch (PDOException $e) {
        // Debug cho sinh viên: In lỗi nếu connect thất bại (không dùng echo ở production, mà log)
        echo 'Lỗi kết nối MySQL: ' . $e->getMessage();
        return null; // Trả null để index.php kiểm tra
    }
}

// Các hàm hỗ trợ khác (nếu có, ví dụ: hàm escape string, hoặc helper cho Bootstrap view)
?>