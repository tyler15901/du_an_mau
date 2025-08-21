<?php
require_once 'models/UserModel.php';

class UserController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new UserModel();
    }
    
    // Hiển thị form đăng nhập
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            
            // Validate
            if (empty($email) || empty($password)) {
                $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
            
            // Xác thực
            $user = $this->userModel->authenticate($email, $password);
            if ($user) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['ho_ten'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                
                if ($user['role'] === 'admin') {
                    header('Location: ' . BASE_URL . 'admin');
                } else {
                    header('Location: ' . BASE_URL);
                }
                exit;
            } else {
                $_SESSION['error'] = 'Email hoặc mật khẩu không đúng';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
        }
        
        include 'views/login.php';
    }
    
    // Hiển thị form đăng ký
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hoTen = trim($_POST['ho_ten']);
            $gioiTinh = $_POST['gioi_tinh'];
            $ngaySinh = $_POST['ngay_sinh'];
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
            
            // Validate
            if (empty($hoTen) || empty($email) || empty($password)) {
                $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Email không hợp lệ';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
            
            if (strlen($password) < 6) {
                $_SESSION['error'] = 'Mật khẩu phải có ít nhất 6 ký tự';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
            
            if ($password !== $confirmPassword) {
                $_SESSION['error'] = 'Mật khẩu xác nhận không khớp';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
            
            // Kiểm tra email đã tồn tại chưa
            if ($this->userModel->isEmailExists($email)) {
                $_SESSION['error'] = 'Email đã được sử dụng';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
            
            $data = [
                'ho_ten' => $hoTen,
                'gioi_tinh' => $gioiTinh,
                'ngay_sinh' => $ngaySinh,
                'email' => $email,
                'mat_khau' => password_hash($password, PASSWORD_DEFAULT),
                'role' => 'user'
            ];
            
            if ($this->userModel->registerUser($data)) {
                $_SESSION['success'] = 'Đăng ký thành công! Vui lòng đăng nhập';
                header('Location: ' . BASE_URL . 'login');
                exit;
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
        }
        
        include 'views/register.php';
    }
    
    // Đăng xuất
    public function logout() {
        session_start();
        session_destroy();
        header('Location: ' . BASE_URL);
        exit;
    }
    
    // Admin: Quản lý người dùng
    public function adminList() {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
        
        $users = $this->userModel->getAllUsers();
        include 'admin/views/manage-users.php';
    }
    
    // Admin: Xem chi tiết người dùng
    public function adminDetail($id) {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
        
        $user = $this->userModel->getUserById($id);
        if (!$user) {
            header('Location: ' . BASE_URL . 'admin/users');
            exit;
        }
        
        include 'admin/views/user-detail.php';
    }
    
    // Admin: Xóa người dùng
    public function adminDelete($id) {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
        
        // Không cho phép xóa chính mình
        if ($id == $_SESSION['user_id']) {
            $_SESSION['error'] = 'Không thể xóa tài khoản của chính mình';
            header('Location: ' . BASE_URL . 'admin/users');
            exit;
        }
        
        if ($this->userModel->deleteUser($id)) {
            $_SESSION['success'] = 'Xóa người dùng thành công';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra';
        }
        
        header('Location: ' . BASE_URL . 'admin/users');
        exit;
    }
}
