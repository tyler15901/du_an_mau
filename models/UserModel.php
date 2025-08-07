<?php
// Có class chứa các function thực thi tương tác với cơ sở dữ liệu cho người dùng
class UserModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDatabase(); // Kết nối CSDL
    }

    // Kiểm tra đăng nhập
    public function checkLogin($email, $password)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', md5($password)); // Sử dụng md5 để mã hóa mật khẩu (nên thay bằng bcrypt trong thực tế)
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return null;
        }
    }

    // Đăng ký người dùng
    public function registerUser($name, $email, $password)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', md5($password)); // Sử dụng md5 (nên thay bằng bcrypt)
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // Lấy danh sách tất cả người dùng
    public function getAllUsers()
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }
}