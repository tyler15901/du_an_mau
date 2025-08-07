<?php
class CommentModel {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getCommentsByProduct($product_id) {
        $sql = "SELECT c.*, u.name as user_name FROM comments c
                JOIN users u ON c.user_id = u.id
                WHERE c.product_id = ?
                ORDER BY c.date DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addComment($user_id, $product_id, $content) {
        $sql = "INSERT INTO comments (user_id, product_id, content, date)
                VALUES (?, ?, ?, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$user_id, $product_id, $content]);
    }
}
?>