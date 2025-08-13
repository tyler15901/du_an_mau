<?php
require_once 'commons/env.php';
require_once 'commons/function.php';

class CategoryModel {
    private $conn;
    
    public function __construct() {
        $this->conn = connectDB();
    }
    
    // Lấy tất cả danh mục
    public function getAllCategories() {
        $sql = "SELECT * FROM categories ORDER BY id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Lấy danh mục theo ID
    public function getCategoryById($id) {
        $sql = "SELECT * FROM categories WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    // Lấy danh mục theo slug
    public function getCategoryBySlug($slug) {
        $sql = "SELECT * FROM categories WHERE slug = :slug";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    // Thêm danh mục mới
    public function addCategory($data) {
        $sql = "INSERT INTO categories (name, slug) VALUES (:name, :slug)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':slug', $data['slug']);
        return $stmt->execute();
    }
    
    // Cập nhật danh mục
    public function updateCategory($id, $data) {
        $sql = "UPDATE categories SET name = :name, slug = :slug WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':slug', $data['slug']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    // Xóa danh mục
    public function deleteCategory($id) {
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    // Đếm số sản phẩm trong danh mục
    public function countProductsInCategory($categoryId) {
        $sql = "SELECT COUNT(*) as total FROM products WHERE category_id = :category_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }
    
    // Tạo slug từ tên danh mục
    public function createSlug($name) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        
        // Kiểm tra slug đã tồn tại chưa
        $sql = "SELECT COUNT(*) as count FROM categories WHERE slug = :slug";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        $result = $stmt->fetch();
        
        if ($result['count'] > 0) {
            $slug .= '-' . time();
        }
        
        return $slug;
    }
}
