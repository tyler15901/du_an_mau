<?php
class ProductModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllProducts($limit = null, $offset = 0) {
        $sql = "SELECT p.*, c.name as category_name FROM products p
                JOIN categories c ON p.category_id = c.id
                ORDER BY p.id DESC";
        
        if ($limit) {
            $sql .= " LIMIT ? OFFSET ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$limit, $offset]);
        } else {
            $stmt = $this->pdo->query($sql);
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id) {
        $sql = "SELECT p.*, c.name as category_name FROM products p
                JOIN categories c ON p.category_id = c.id
                WHERE p.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProductBySlug($slug) {
        $sql = "SELECT p.*, c.name as category_name FROM products p
                JOIN categories c ON p.category_id = c.id
                WHERE p.slug = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$slug]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProductsWithFilter($search = '', $category = '', $price_range = 'all', $limit = null, $offset = 0) {
        $sql = "SELECT p.*, c.name as category_name FROM products p
                JOIN categories c ON p.category_id = c.id
                WHERE 1=1";
        $params = [];

        // Tìm kiếm theo tên sản phẩm
        if (!empty($search)) {
            $sql .= " AND p.name LIKE ?";
            $params[] = "%$search%";
        }

        // Lọc theo danh mục
        if (!empty($category)) {
            $sql .= " AND p.category_id = ?";
            $params[] = $category;
        }

        // Lọc theo khoảng giá
        if ($price_range !== 'all') {
            switch ($price_range) {
                case '0-500000':
                    $sql .= " AND p.price <= 500000";
                    break;
                case '500000-1000000':
                    $sql .= " AND p.price > 500000 AND p.price <= 1000000";
                    break;
                case '1000000':
                    $sql .= " AND p.price > 1000000";
                    break;
            }
        }

        $sql .= " ORDER BY p.id DESC";
        
        if ($limit) {
            $sql .= " LIMIT ? OFFSET ?";
            $params[] = $limit;
            $params[] = $offset;
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductsByCategory($category_id, $limit = null, $offset = 0) {
        $sql = "SELECT p.*, c.name as category_name FROM products p
                JOIN categories c ON p.category_id = c.id
                WHERE p.category_id = ?
                ORDER BY p.id DESC";
        
        if ($limit) {
            $sql .= " LIMIT ? OFFSET ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$category_id, $limit, $offset]);
        } else {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$category_id]);
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRelatedProducts($category_id, $exclude_id, $limit = 4) {
        $sql = "SELECT p.*, c.name as category_name FROM products p
                JOIN categories c ON p.category_id = c.id
                WHERE p.category_id = ? AND p.id != ?
                ORDER BY p.id DESC
                LIMIT ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$category_id, $exclude_id, $limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchProducts($keyword, $limit = null, $offset = 0) {
        $sql = "SELECT p.*, c.name as category_name FROM products p
                JOIN categories c ON p.category_id = c.id
                WHERE p.name LIKE ? OR p.description LIKE ?
                ORDER BY p.id DESC";
        
        if ($limit) {
            $sql .= " LIMIT ? OFFSET ?";
            $stmt = $this->pdo->prepare($sql);
            $searchTerm = "%$keyword%";
            $stmt->execute([$searchTerm, $searchTerm, $limit, $offset]);
        } else {
            $stmt = $this->pdo->prepare($sql);
            $searchTerm = "%$keyword%";
            $stmt->execute([$searchTerm, $searchTerm]);
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFeaturedProducts($limit = 8) {
        $sql = "SELECT p.*, c.name as category_name FROM products p
                JOIN categories c ON p.category_id = c.id
                ORDER BY p.id DESC
                LIMIT ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalProducts($search = '', $category = '') {
        $sql = "SELECT COUNT(*) as total FROM products p
                JOIN categories c ON p.category_id = c.id
                WHERE 1=1";
        $params = [];

        if (!empty($search)) {
            $sql .= " AND p.name LIKE ?";
            $params[] = "%$search%";
        }

        if (!empty($category)) {
            $sql .= " AND p.category_id = ?";
            $params[] = $category;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    // Thêm sản phẩm mới
    public function addProduct($data) {
        try {
            $sql = "INSERT INTO products (name, price, category_id, description, image, stock, slug) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                $data['name'],
                $data['price'],
                $data['category_id'],
                $data['description'],
                $data['image'],
                $data['stock'],
                $data['slug']
            ]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    // Cập nhật sản phẩm
    public function updateProduct($id, $data) {
        try {
            $sql = "UPDATE products SET 
                    name = ?, price = ?, category_id = ?, description = ?, 
                    image = ?, stock = ?, slug = ?
                    WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $data['name'],
                $data['price'],
                $data['category_id'],
                $data['description'],
                $data['image'],
                $data['stock'],
                $data['slug'],
                $id
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Xóa sản phẩm
    public function deleteProduct($id) {
        try {
            // Lấy thông tin ảnh trước khi xóa
            $product = $this->getProductById($id);
            if ($product && !empty($product['image'])) {
                deleteImage($product['image']);
            }
            
            $sql = "DELETE FROM products WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Kiểm tra slug tồn tại
    public function slugExists($slug, $excludeId = null) {
        $sql = "SELECT COUNT(*) as count FROM products WHERE slug = ?";
        $params = [$slug];
        
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }
}
?>