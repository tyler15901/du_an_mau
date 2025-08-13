<?php
require_once 'commons/env.php';
require_once 'commons/function.php';

class UserModel {
    private $conn;
    
    public function __construct() {
        $this->conn = connectDB();
    }
    
    // Lấy tất cả người dùng
    public function getAllUsers() {
        $sql = "SELECT * FROM users ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Lấy người dùng theo ID
    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    // Lấy người dùng theo email
    public function getUserByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    // Đăng ký người dùng mới
    public function registerUser($data) {
        $sql = "INSERT INTO users (ho_ten, gioi_tinh, ngay_sinh, email, mat_khau, role) 
                VALUES (:ho_ten, :gioi_tinh, :ngay_sinh, :email, :mat_khau, :role)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ho_ten', $data['ho_ten']);
        $stmt->bindParam(':gioi_tinh', $data['gioi_tinh']);
        $stmt->bindParam(':ngay_sinh', $data['ngay_sinh']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':mat_khau', $data['mat_khau']);
        $stmt->bindParam(':role', $data['role']);
        
        return $stmt->execute();
    }
    
    // Cập nhật thông tin người dùng
    public function updateUser($id, $data) {
        $sql = "UPDATE users SET ho_ten = :ho_ten, gioi_tinh = :gioi_tinh, 
                ngay_sinh = :ngay_sinh, email = :email WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ho_ten', $data['ho_ten']);
        $stmt->bindParam(':gioi_tinh', $data['gioi_tinh']);
        $stmt->bindParam(':ngay_sinh', $data['ngay_sinh']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
    
    // Cập nhật mật khẩu
    public function updatePassword($id, $newPassword) {
        $sql = "UPDATE users SET mat_khau = :mat_khau WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':mat_khau', $newPassword);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    // Xóa người dùng
    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    // Đếm tổng số người dùng
    public function countUsers() {
        $sql = "SELECT COUNT(*) as total FROM users";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }
    
    // Đếm số người dùng theo vai trò
    public function countUsersByRole($role) {
        $sql = "SELECT COUNT(*) as total FROM users WHERE role = :role";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }
    
    // Kiểm tra email đã tồn tại chưa
    public function isEmailExists($email, $excludeId = null) {
        $sql = "SELECT COUNT(*) as count FROM users WHERE email = :email";
        if ($excludeId) {
            $sql .= " AND id != :exclude_id";
        }
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        if ($excludeId) {
            $stmt->bindParam(':exclude_id', $excludeId);
        }
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['count'] > 0;
    }
    
    // Xác thực đăng nhập
    public function authenticate($email, $password) {
        $user = $this->getUserByEmail($email);
        if ($user && password_verify($password, $user['mat_khau'])) {
            return $user;
        }
        return false;
    }
}
