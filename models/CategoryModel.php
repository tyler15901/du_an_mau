<?php
// Có class chứa các function thực thi tương tác với cơ sở dữ liệu cho danh mục
class CategoryModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Lấy tất cả danh mục
    public function getAllCategories() {
        try {
            $sql = "SELECT * FROM categories ORDER BY name ASC";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // Lấy danh mục theo ID
    public function getCategoryById($id) {
        try {
            $sql = "SELECT * FROM categories WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    // Lấy danh mục theo slug
    public function getCategoryBySlug($slug) {
        try {
            $sql = "SELECT * FROM categories WHERE slug = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$slug]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    // Thêm danh mục mới
    public function addCategory($data) {
        try {
            $sql = "INSERT INTO categories (name, slug) VALUES (?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$data['name'], $data['slug']]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    // Cập nhật danh mục
    public function updateCategory($id, $data) {
        try {
            $sql = "UPDATE categories SET name = ?, slug = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$data['name'], $data['slug'], $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Xóa danh mục
    public function deleteCategory($id) {
        try {
            $sql = "DELETE FROM categories WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Kiểm tra slug tồn tại
    public function slugExists($slug, $excludeId = null) {
        try {
            $sql = "SELECT COUNT(*) as count FROM categories WHERE slug = ?";
            $params = [$slug];
            
            if ($excludeId) {
                $sql .= " AND id != ?";
                $params[] = $excludeId;
            }
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Lấy tổng số danh mục
    public function getTotalCategories() {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM categories");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            return 0;
        }
    }

    // Tìm kiếm danh mục
    public function searchCategories($keyword) {
        try {
            $sql = "SELECT * FROM categories WHERE name LIKE ? ORDER BY name ASC";
            $stmt = $this->pdo->prepare($sql);
            $searchTerm = "%$keyword%";
            $stmt->execute([$searchTerm]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // Lấy danh mục có sản phẩm
    public function getCategoriesWithProducts() {
        try {
            $sql = "SELECT c.*, COUNT(p.id) as product_count 
                    FROM categories c
                    LEFT JOIN products p ON c.id = p.category_id
                    GROUP BY c.id
                    ORDER BY c.name ASC";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
?>