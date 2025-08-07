<?php
class ProductModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDatabase();
    }

    // ... (các hàm cũ giữ nguyên)

    // Thêm sản phẩm mới
    public function addProduct($name, $price, $category_id, $description, $image)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO products (name, price, category_id, description, image) VALUES (:name, :price, :category_id, :description, :image)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':image', $image);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // Cập nhật sản phẩm
    public function updateProduct($id, $name, $price, $category_id, $description, $image)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE products SET name = :name, price = :price, category_id = :category_id, description = :description, image = :image WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':image', $image);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // Xóa sản phẩm
    public function deleteProduct($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM products WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }
}