<?php
// Có class chứa các function thực thi tương tác với cơ sở dữ liệu cho danh mục
class CategoryModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDatabase(); // Kết nối CSDL
    }

    // Lấy danh sách tất cả danh mục
    public function getAllCategories()
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM categories");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }

    // Thêm danh mục mới
    public function addCategory($name)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO categories (name) VALUES (:name)");
            $stmt->bindParam(':name', $name);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // Cập nhật danh mục
    public function updateCategory($id, $name)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE categories SET name = :name WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // Xóa danh mục
    public function deleteCategory($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM categories WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }
}