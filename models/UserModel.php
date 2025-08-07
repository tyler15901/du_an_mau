<?php
// Có class chứa các function thực thi tương tác với cơ sở dữ liệu cho người dùng
class UserModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDatabase(); // Kết nối CSDL
    }

    // Kiểm tra đăng nhập (đã có, giữ nguyên)
    public function checkLogin($email, $password)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch();
            if ($user && password_verify($password, $user['password'])) { // Sử dụng password_verify để kiểm tra mật khẩu mã hóa
                return $user;
            }
            return null;
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return null;
        }
    }

    // Đăng ký người dùng (đã có, cập nhật dùng password_hash)
    public function registerUser($name, $email, $password)
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Mã hóa mật khẩu bằng bcrypt (an toàn hơn md5)
            $stmt = $this->conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // Lấy danh sách tất cả người dùng (đã có, giữ nguyên)
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

    // Mới: Thêm người dùng
    public function addUser($name, $email, $password)
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Mã hóa mật khẩu
            $stmt = $this->conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // Mới: Xóa người dùng
    public function deleteUser($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM users WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }
