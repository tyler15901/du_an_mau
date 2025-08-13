<?php
class CommentModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Lấy tất cả bình luận
    public function getAllComments($limit = null, $offset = 0) {
        try {
            $sql = "SELECT r.*, p.name as product_name, u.ho_ten as user_name 
                    FROM reviews r
                    JOIN products p ON r.product_id = p.id
                    JOIN users u ON r.user_id = u.id
                    ORDER BY r.created_at DESC";
            
            if ($limit) {
                $sql .= " LIMIT ? OFFSET ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$limit, $offset]);
            } else {
                $stmt = $this->pdo->query($sql);
            }
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // Lấy bình luận theo sản phẩm
    public function getCommentsByProduct($product_id, $limit = null, $offset = 0) {
        try {
            $sql = "SELECT r.*, u.ho_ten as user_name 
                    FROM reviews r
                    JOIN users u ON r.user_id = u.id
                    WHERE r.product_id = ?
                    ORDER BY r.created_at DESC";
            
            if ($limit) {
                $sql .= " LIMIT ? OFFSET ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$product_id, $limit, $offset]);
            } else {
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$product_id]);
            }
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // Lấy bình luận theo user
    public function getCommentsByUser($user_id, $limit = null, $offset = 0) {
        try {
            $sql = "SELECT r.*, p.name as product_name 
                    FROM reviews r
                    JOIN products p ON r.product_id = p.id
                    WHERE r.user_id = ?
                    ORDER BY r.created_at DESC";
            
            if ($limit) {
                $sql .= " LIMIT ? OFFSET ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$user_id, $limit, $offset]);
            } else {
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$user_id]);
            }
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // Thêm bình luận mới
    public function addComment($product_id, $user_id, $comment) {
        try {
            $sql = "INSERT INTO reviews (product_id, user_id, comment) VALUES (?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$product_id, $user_id, $comment]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    // Cập nhật bình luận
    public function updateComment($id, $comment) {
        try {
            $sql = "UPDATE reviews SET comment = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$comment, $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Xóa bình luận
    public function deleteComment($id) {
        try {
            $sql = "DELETE FROM reviews WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Lấy bình luận theo ID
    public function getCommentById($id) {
        try {
            $sql = "SELECT r.*, p.name as product_name, u.ho_ten as user_name 
                    FROM reviews r
                    JOIN products p ON r.product_id = p.id
                    JOIN users u ON r.user_id = u.id
                    WHERE r.id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    // Lấy tổng số bình luận
    public function getTotalComments($product_id = null) {
        try {
            $sql = "SELECT COUNT(*) as total FROM reviews";
            $params = [];
            
            if ($product_id) {
                $sql .= " WHERE product_id = ?";
                $params[] = $product_id;
            }
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            return 0;
        }
    }

    // Tìm kiếm bình luận
    public function searchComments($keyword, $limit = null, $offset = 0) {
        try {
            $sql = "SELECT r.*, p.name as product_name, u.ho_ten as user_name 
                    FROM reviews r
                    JOIN products p ON r.product_id = p.id
                    JOIN users u ON r.user_id = u.id
                    WHERE r.comment LIKE ? OR p.name LIKE ? OR u.ho_ten LIKE ?
                    ORDER BY r.created_at DESC";
            
            $searchTerm = "%$keyword%";
            
            if ($limit) {
                $sql .= " LIMIT ? OFFSET ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $limit, $offset]);
            } else {
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
            }
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // Kiểm tra user đã bình luận sản phẩm chưa
    public function hasUserCommented($user_id, $product_id) {
        try {
            $sql = "SELECT COUNT(*) as count FROM reviews WHERE user_id = ? AND product_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$user_id, $product_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Lấy bình luận mới nhất
    public function getLatestComments($limit = 5) {
        try {
            $sql = "SELECT r.*, p.name as product_name, u.ho_ten as user_name 
                    FROM reviews r
                    JOIN products p ON r.product_id = p.id
                    JOIN users u ON r.user_id = u.id
                    ORDER BY r.created_at DESC
                    LIMIT ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$limit]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
?>