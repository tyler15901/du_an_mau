<?php 
// Comment: Class Model cho danh mục, thêm try-catch bắt lỗi query.
class CategoryModel {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getMenuWithSub() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM categories WHERE parent_id = 0 LIMIT 5");
            $stmt->execute();
            $menu = $stmt->fetchAll();

            foreach ($menu as &$item) {
                $subStmt = $this->conn->prepare("SELECT * FROM categories WHERE parent_id = :parent_id");
                $subStmt->execute(['parent_id' => $item['id']]);
                $item['sub'] = $subStmt->fetchAll();
            }
            return $menu;
        } catch (PDOException $e) {
            error_log("Lỗi query menu: " . $e->getMessage());
            return [];
        }
    }

    public function getMainCategories() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM categories WHERE is_main = 1 LIMIT 8");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Lỗi query danh mục: " . $e->getMessage());
            return [];
        }
    }
}