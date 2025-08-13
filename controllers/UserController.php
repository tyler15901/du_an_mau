<?php
// Comment: Controller cho user/admin login/register/logout, check role

class UserController {
    private $userModel;
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        require_once PATH_ROOT . 'models/UserModel.php';
        $this->userModel = new UserModel($pdo);
    }

    // Comment: Login (POST, check email/pass, set session with role)
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $user = $this->userModel->checkLogin($email, $password); // Return user if verify ok
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['role'] = $user['role'];
                if ($user['role'] == 1) {
                    header("Location: index.php?act=admin-dashboard");
                } else {
                    header("Location: index.php");
                }
                exit();
            } else {
                $errorMessage = "Email hoặc mật khẩu sai!";
            }
        }
        $title = "Đăng Nhập";
        require_once PATH_ROOT . 'views/login.php';
    }

    // Comment: Register (POST, check email exists, hash pass, insert)
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';
            if ($password != $confirm) {
                $errorMessage = "Mật khẩu không khớp!";
            } elseif ($this->userModel->checkEmailExists($email)) {
                $errorMessage = "Email đã tồn tại!";
            } else {
                if ($this->userModel->registerUser($name, $email, $password)) {
                    $successMessage = "Đăng ký thành công! Đăng nhập ngay.";
                } else {
                    $errorMessage = "Lỗi đăng ký!";
                }
            }
        }
        $title = "Đăng Ký";
        require_once PATH_ROOT . 'views/register.php';
    }

    // Comment: Logout (destroy session)
    public function logout() {
        session_destroy();
        header("Location: index.php");
        exit();
    }
}
?>