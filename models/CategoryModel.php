<?php 
// Comment: Class Model cho danh mục, tương tác với bảng categories trong MySQL.
class CategoryModel {
    public $conn;

    public function __construct() {
        $this->conn = connectDB(); // Kết nối DB từ function.php.
    }

    // Comment: Lấy menu chính và submenu (nested array cho View loop).
    public function getMenuWithSub() {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE parent_id = 0 LIMIT 5"); // Lấy 5 menu chính.
        $stmt->execute();
        $menu = $stmt->fetchAll();

        foreach ($menu as &$item) {
            $subStmt = $this->conn->prepare("SELECT * FROM categories WHERE parent_id = :parent_id");
            $subStmt->execute(['parent_id' => $item['id']]);
            $item['sub'] = $subStmt->fetchAll(); // Thêm submenu vào array.
        }
        return $menu;
    }

    // Comment: Lấy danh mục chính cho carousel (is_main = 1).
    public function getMainCategories() {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE is_main = 1 LIMIT 8");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}