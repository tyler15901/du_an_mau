<?php

class AuthController
{
    public $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function showLogin()
    {
        $title = 'Đăng nhập';
        $error = $_SESSION['auth_error'] ?? null; unset($_SESSION['auth_error']);
        require_once './views/auth/login.php';
    }

    public function loginPost()
    {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($email === '' || $password === '') {
            $_SESSION['auth_error'] = 'Vui lòng nhập email và mật khẩu';
            header('Location: ' . BASE_URL . '?act=login');
            return;
        }

        $user = $this->userModel->findByEmail($email);
        if (!$user) {
            $_SESSION['auth_error'] = 'Thông tin đăng nhập không đúng';
            header('Location: ' . BASE_URL . '?act=login');
            return;
        }

        $valid = password_verify($password, $user['mat_khau']);
        // Fallback: nếu DB đang lưu plain text (do nhập tay), tự động hash lại 1 lần
        if (!$valid && hash_equals((string)$user['mat_khau'], (string)$password)) {
            $newHash = password_hash($password, PASSWORD_BCRYPT);
            $this->userModel->updatePasswordHash((int)$user['id'], $newHash);
            $valid = true;
        }
        if (!$valid) {
            $_SESSION['auth_error'] = 'Thông tin đăng nhập không đúng';
            header('Location: ' . BASE_URL . '?act=login');
            return;
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['ho_ten'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];
        if (($user['role'] ?? 'user') === 'admin') {
            header('Location: ' . BASE_URL . '?act=admin');
        } else {
            header('Location: ' . BASE_URL);
        }
    }

    public function showRegister()
    {
        $title = 'Đăng ký';
        $error = $_SESSION['auth_error'] ?? null; unset($_SESSION['auth_error']);
        require_once './views/auth/register.php';
    }

    public function registerPost()
    {
        // Hỗ trợ cả name đơn hoặc họ+tên
        $name = trim($_POST['name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? $_POST['ho'] ?? '');
        $firstName = trim($_POST['first_name'] ?? $_POST['ten'] ?? '');
        if ($name === '' && ($lastName !== '' || $firstName !== '')) {
            $name = trim($lastName . ' ' . $firstName);
        }
        $gender = trim($_POST['gender'] ?? 'Nam');
        $dob = trim($_POST['dob'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirm = trim($_POST['confirm_password'] ?? '');

        if ($name === '' || $dob === '' || $email === '' || $password === '' || $confirm === '') {
            $_SESSION['auth_error'] = 'Vui lòng nhập đầy đủ thông tin';
            header('Location: ' . BASE_URL . '?act=register');
            return;
        }
        // YYYY-MM-DD validate simple
        $isDate = preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob);
        if (!$isDate) {
            $_SESSION['auth_error'] = 'Ngày sinh không hợp lệ (YYYY-MM-DD)';
            header('Location: ' . BASE_URL . '?act=register');
            return;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['auth_error'] = 'Email không hợp lệ';
            header('Location: ' . BASE_URL . '?act=register');
            return;
        }
        if ($password !== $confirm) {
            $_SESSION['auth_error'] = 'Mật khẩu xác nhận không khớp';
            header('Location: ' . BASE_URL . '?act=register');
            return;
        }
        if ($this->userModel->findByEmail($email)) {
            $_SESSION['auth_error'] = 'Email đã tồn tại';
            header('Location: ' . BASE_URL . '?act=register');
            return;
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);
        $this->userModel->createUser($name, $gender, $dob, $email, $hash);
        $_SESSION['user'] = [
            'id' => $this->userModel->lastInsertId(),
            'name' => $name,
            'email' => $email,
            'role' => 'user',
        ];
        header('Location: ' . BASE_URL);
    }

    public function logout()
    {
        unset($_SESSION['user']);
        header('Location: ' . BASE_URL);
    }
}


