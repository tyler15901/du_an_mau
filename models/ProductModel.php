<?php
// Có class chứa các function thực thi tương tác với cơ sở dữ liệu
class ProductModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDatabase(); // Kết nối CSDL qua hàm trong commons/function.php
    }

    // Cập nhật: Lấy danh sách sản phẩm với search/filter
    public function getAllProducts($search = '', $category = '', $price_range = 'all')
    {
        try {
            $sql = "SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE 1=1";
            if (!empty($search)) {
                $sql .= " AND p.name LIKE :search"; // Tìm theo tên
            }
            if (!empty($category)) {
                $sql .= " AND p.category_id = :category"; // Filter danh mục
            }
            if ($price_range != 'all') {
                list($min, $max) = explode('-', $price_range); // Filter giá, ví dụ 0-500000
                $sql .= " AND p.price BETWEEN :min AND :max";
            }
            $stmt = $this->conn->prepare($sql);
            if (!empty($search)) {
                $searchParam = '%' . $search . '%';
                $stmt->bindParam(':search', $searchParam);
            }
            if (!empty($category)) {
                $stmt->bindParam(':category', $category);
            }
            if ($price_range != 'all') {
                $stmt->bindParam(':min', $min);
                $stmt->bindParam(':max', $max);
            }
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }
    // Lấy danh sách tất cả sản phẩm
    public function getAllProducts()
    {
        try {
            $stmt = $this->conn->prepare("SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }

    // Lấy thông tin sản phẩm theo ID
    public function getProductById($id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return null;
        }
    }

    // Lấy sản phẩm liên quan dựa trên danh mục
    public function getRelatedProducts($categoryId, $currentProductId)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM products WHERE category_id = :category_id AND id != :current_id LIMIT 4");
            $stmt->bindParam(':category_id', $categoryId);
            $stmt->bindParam(':current_id', $currentProductId);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }
}