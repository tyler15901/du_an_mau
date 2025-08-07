<?php
// Có class chứa các function thực thi tương tác với cơ sở dữ liệu cho admin
class AdminModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDatabase(); // Kết nối CSDL
    }

    // Kiểm tra đăng nhập admin
    public function checkAdminLogin($email, $password)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM admins WHERE email = :email AND password = :password");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', md5($password)); // Sử dụng md5 (nên thay bằng bcrypt)
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return null;
        }
    }
}