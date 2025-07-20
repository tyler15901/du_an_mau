<?php 
// Comment: Class Model cho banner, tương tác với bảng banners.
class BannerModel {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    // Comment: Lấy banner active.
    public function getBanners() {
        $stmt = $this->conn->prepare("SELECT * FROM banners WHERE active = 1 LIMIT 5");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}