<?php
require_once 'commons/env.php';
require_once 'commons/function.php';

class ReviewModel {
    private $conn;
    
    public function __construct() {
        $this->conn = connectDB();
    }
    
    // Lấy tất cả bình luận
    public function getAllReviews() {
        $sql = "SELECT r.*, p.name as product_name, u.ho_ten as user_name 
                FROM reviews r 
                JOIN products p ON r.product_id = p.id 
                JOIN users u ON r.user_id = u.id 
                ORDER BY r.created_at DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Lấy bình luận theo sản phẩm
    public function getReviewsByProduct($productId) {
        $sql = "SELECT r.*, u.ho_ten as user_name 
                FROM reviews r 
                JOIN users u ON r.user_id = u.id 
                WHERE r.product_id = :product_id 
                ORDER BY r.created_at DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Lấy bình luận theo ID
    public function getReviewById($id) {
        $sql = "SELECT r.*, p.name as product_name, u.ho_ten as user_name 
                FROM reviews r 
                JOIN products p ON r.product_id = p.id 
                JOIN users u ON r.user_id = u.id 
                WHERE r.id = :id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    // Thêm bình luận mới
    public function addReview($data) {
        $sql = "INSERT INTO reviews (product_id, user_id, comment, rating) 
                VALUES (:product_id, :user_id, :comment, :rating)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':product_id', $data['product_id']);
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':comment', $data['comment']);
        $stmt->bindParam(':rating', $data['rating']);
        
        return $stmt->execute();
    }
    
    // Cập nhật bình luận
    public function updateReview($id, $data) {
        $sql = "UPDATE reviews SET comment = :comment, rating = :rating WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':comment', $data['comment']);
        $stmt->bindParam(':rating', $data['rating']);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
    
    // Xóa bình luận
    public function deleteReview($id) {
        $sql = "DELETE FROM reviews WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    // Đếm tổng số bình luận
    public function countReviews() {
        $sql = "SELECT COUNT(*) as total FROM reviews";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }
    
    // Đếm số bình luận theo sản phẩm
    public function countReviewsByProduct($productId) {
        $sql = "SELECT COUNT(*) as total FROM reviews WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }
    
    // Tính điểm đánh giá trung bình của sản phẩm
    public function getAverageRating($productId) {
        $sql = "SELECT AVG(rating) as average_rating FROM reviews WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();
        $result = $stmt->fetch();
        return round($result['average_rating'], 1);
    }
    
    // Kiểm tra người dùng đã bình luận sản phẩm chưa
    public function hasUserReviewed($userId, $productId) {
        $sql = "SELECT COUNT(*) as count FROM reviews WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['count'] > 0;
    }
    
    // Lấy bình luận của người dùng cho sản phẩm
    public function getUserReview($userId, $productId) {
        $sql = "SELECT * FROM reviews WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();
        return $stmt->fetch();
    }
}
