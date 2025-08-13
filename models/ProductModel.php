<?php
require_once 'commons/env.php';
require_once 'commons/function.php';

class ProductModel {
    private $conn;
    
    public function __construct() {
        $this->conn = connectDB();
    }
    
    // Lấy tất cả sản phẩm
    public function getAllProducts($limit = null, $offset = null) {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                JOIN categories c ON p.category_id = c.id 
                ORDER BY p.id DESC";
        
        if ($limit) {
            $sql .= " LIMIT $limit";
            if ($offset) {
                $sql .= " OFFSET $offset";
            }
        }
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Lấy sản phẩm theo danh mục
    public function getProductsByCategory($categoryId, $limit = null, $offset = null) {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                JOIN categories c ON p.category_id = c.id 
                WHERE p.category_id = :category_id 
                ORDER BY p.id DESC";
        
        if ($limit) {
            $sql .= " LIMIT $limit";
            if ($offset) {
                $sql .= " OFFSET $offset";
            }
        }
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Lấy sản phẩm theo slug
    public function getProductBySlug($slug) {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                JOIN categories c ON p.category_id = c.id 
                WHERE p.slug = :slug";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    // Lấy sản phẩm theo ID
    public function getProductById($id) {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                JOIN categories c ON p.category_id = c.id 
                WHERE p.id = :id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    // Tìm kiếm sản phẩm
    public function searchProducts($keyword, $limit = null, $offset = null) {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                JOIN categories c ON p.category_id = c.id 
                WHERE p.name LIKE :keyword OR p.description LIKE :keyword 
                ORDER BY p.id DESC";
        
        if ($limit) {
            $sql .= " LIMIT $limit";
            if ($offset) {
                $sql .= " OFFSET $offset";
            }
        }
        
        $stmt = $this->conn->prepare($sql);
        $keyword = "%$keyword%";
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Lọc sản phẩm theo giá
    public function filterProductsByPrice($minPrice, $maxPrice, $limit = null, $offset = null) {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                JOIN categories c ON p.category_id = c.id 
                WHERE p.price BETWEEN :min_price AND :max_price 
                ORDER BY p.price ASC";
        
        if ($limit) {
            $sql .= " LIMIT $limit";
            if ($offset) {
                $sql .= " OFFSET $offset";
            }
        }
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':min_price', $minPrice);
        $stmt->bindParam(':max_price', $maxPrice);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Thêm sản phẩm mới
    public function addProduct($data) {
        $sql = "INSERT INTO products (name, price, category_id, description, image, stock, slug) 
                VALUES (:name, :price, :category_id, :description, :image, :stock, :slug)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':image', $data['image']);
        $stmt->bindParam(':stock', $data['stock']);
        $stmt->bindParam(':slug', $data['slug']);
        
        return $stmt->execute();
    }
    
    // Cập nhật sản phẩm
    public function updateProduct($id, $data) {
        $sql = "UPDATE products 
                SET name = :name, price = :price, category_id = :category_id, 
                    description = :description, stock = :stock, slug = :slug";
        
        // Chỉ cập nhật ảnh nếu có ảnh mới
        if (!empty($data['image'])) {
            $sql .= ", image = :image";
        }
        
        $sql .= " WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':stock', $data['stock']);
        $stmt->bindParam(':slug', $data['slug']);
        $stmt->bindParam(':id', $id);
        
        if (!empty($data['image'])) {
            $stmt->bindParam(':image', $data['image']);
        }
        
        return $stmt->execute();
    }
    
    // Xóa sản phẩm
    public function deleteProduct($id) {
        // Lấy thông tin ảnh trước khi xóa
        $product = $this->getProductById($id);
        
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            // Xóa file ảnh nếu có
            if ($product && !empty($product['image'])) {
                deleteFile($product['image']);
            }
            return true;
        }
        return false;
    }
    
    // Đếm tổng số sản phẩm
    public function countProducts($categoryId = null) {
        $sql = "SELECT COUNT(*) as total FROM products";
        if ($categoryId) {
            $sql .= " WHERE category_id = :category_id";
        }
        
        $stmt = $this->conn->prepare($sql);
        if ($categoryId) {
            $stmt->bindParam(':category_id', $categoryId);
        }
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }
    
    // Tạo slug từ tên sản phẩm
    public function createSlug($name) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        
        // Kiểm tra slug đã tồn tại chưa
        $sql = "SELECT COUNT(*) as count FROM products WHERE slug = :slug";
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
