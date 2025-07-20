<?php 
// Comment: Class Model cho banner, tương tác với bảng banners, thêm try-catch để xử lý lỗi SQL.
class BannerModel {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    // Comment: Lấy banner active, bắt lỗi nếu query sai (e.g., reserved word).
    public function getBanners() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM banners WHERE active = 1 LIMIT 5");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            // Comment: Xử lý lỗi: Log lỗi và return empty array để trang không crash.
            error_log("Lỗi query banners: " . $e->getMessage()); // Log vào file error.log.
            return []; // Return empty để tiếp tục.
        }
    }
}