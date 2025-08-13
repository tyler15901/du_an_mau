<?php
// Có class chứa các function thực thi tương tác với cơ sở dữ liệu cho người dùng
class UserModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo; // Nhận $pdo từ constructor thay vì tự kết nối
    }

    // Kiểm tra đăng nhập
    public function checkLogin($email, $password)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && password_verify($password, $user['mat_khau'])) {
                return $user;
            }
            return null;
        } catch (PDOException $e) {
            return null;
        }
    }

    // Đăng ký người dùng
    public function registerUser($data)
    {
        try {
            $hashedPassword = password_hash($data['mat_khau'], PASSWORD_BCRYPT);
            $sql = "INSERT INTO users (ho_ten, gioi_tinh, ngay_sinh, email, mat_khau) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                $data['ho_ten'],
                $data['gioi_tinh'],
                $data['ngay_sinh'],
                $data['email'],
                $hashedPassword
            ]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    // Lấy danh sách tất cả người dùng
    public function getAllUsers($limit = null, $offset = 0)
    {
        try {
            $sql = "SELECT * FROM users ORDER BY id DESC";
            
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

    // Lấy thông tin user theo ID
    public function getUserById($id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    // Lấy thông tin user theo email
    public function getUserByEmail($email)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    // Thêm người dùng mới (admin)
    public function addUser($data)
    {
        try {
            $hashedPassword = password_hash($data['mat_khau'], PASSWORD_BCRYPT);
            $sql = "INSERT INTO users (ho_ten, gioi_tinh, ngay_sinh, email, mat_khau) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                $data['ho_ten'],
                $data['gioi_tinh'],
                $data['ngay_sinh'],
                $data['email'],
                $hashedPassword
            ]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    // Cập nhật thông tin người dùng
    public function updateUser($id, $data)
    {
        try {
            $sql = "UPDATE users SET ho_ten = ?, gioi_tinh = ?, ngay_sinh = ?, email = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $data['ho_ten'],
                $data['gioi_tinh'],
                $data['ngay_sinh'],
                $data['email'],
                $id
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Cập nhật mật khẩu
    public function updatePassword($id, $newPassword)
    {
        try {
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $stmt = $this->pdo->prepare("UPDATE users SET mat_khau = ? WHERE id = ?");
            return $stmt->execute([$hashedPassword, $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Xóa người dùng
    public function deleteUser($id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Kiểm tra email tồn tại
    public function emailExists($email, $excludeId = null)
    {
        try {
            $sql = "SELECT COUNT(*) as count FROM users WHERE email = ?";
            $params = [$email];
            
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

    // Lấy tổng số user
    public function getTotalUsers()
    {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM users");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            return 0;
        }
    }

    // Tìm kiếm user
    public function searchUsers($keyword, $limit = null, $offset = 0)
    {
        try {
            $sql = "SELECT * FROM users WHERE ho_ten LIKE ? OR email LIKE ? ORDER BY id DESC";
            $searchTerm = "%$keyword%";
            
            if ($limit) {
                $sql .= " LIMIT ? OFFSET ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$searchTerm, $searchTerm, $limit, $offset]);
            } else {
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$searchTerm, $searchTerm]);
            }
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // Tạo admin mặc định
    public function createDefaultAdmin()
    {
        try {
            // Kiểm tra xem đã có admin chưa
            $stmt = $this->pdo->prepare("SELECT COUNT(*) as count FROM users WHERE email = ?");
            $stmt->execute(['admin@example.com']);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result['count'] == 0) {
                $hashedPassword = password_hash('password', PASSWORD_BCRYPT);
                $sql = "INSERT INTO users (ho_ten, gioi_tinh, ngay_sinh, email, mat_khau) 
                        VALUES (?, ?, ?, ?, ?)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                    'Admin',
                    'Nam',
                    '1990-01-01',
                    'admin@example.com',
                    $hashedPassword
                ]);
                return true;
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>