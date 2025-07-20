<?php 
// Comment: Class Model cho sản phẩm, tương tác với bảng products trong MySQL.
class ProductModel {
    public $conn;

    public function __construct() {
        $this->conn = connectDB(); // Kết nối DB.
    }

    // Comment: Lấy tất cả sản phẩm (mở rộng từ placeholder của bạn).
    public function getAllProduct() {
        $stmt = $this->conn->prepare("SELECT * FROM products");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Comment: Lấy sản phẩm khuyến mãi (promotion_price > 0 và chưa hết hạn).
    public function getPromotionProducts() {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE promotion_price > 0 AND promotion_end_date > NOW() LIMIT 4");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Comment: Lấy sản phẩm nổi bật (sắp xếp theo views DESC).
    public function getFeaturedProducts() {
        $stmt = $this->conn->prepare("SELECT * FROM products ORDER BY views DESC LIMIT 4");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}