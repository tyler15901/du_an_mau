<?php
// Có class chứa các function thực thi tương tác với cơ sở dữ liệu cho bình luận
class CommentModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDatabase(); // Kết nối CSDL
    }

    // Lấy danh sách tất cả bình luận
    public function getAllComments()
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM comments");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }

    // Xóa bình luận
    public function deleteComment($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM comments WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }
}