<?php
class AdminController {
    private $userModel; // Comment: Merge AdminModel vào UserModel với role=1

    public function __construct() {
        require_once './models/UserModel.php';
        $this->userModel = new UserModel(); // Comment: UserModel giờ xử lý both user/admin
    }

    // Comment: Dashboard admin - Lấy stats từ model (query COUNT)
    public function dashboard() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
            header("Location: index.php?act=login");
            exit();
        }
        $stats = $this->userModel->getStats(); // Comment: Method mới ở model: COUNT products/users/comments
        $title = "Dashboard Admin";
        require_once PATH_ROOT . 'views/admin/dashboard.php';
    }

    // Comment: Quản lý users - Get all users
    public function manageUsers() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
            header("Location: index.php?act=login");
            exit();
        }
        $users = $this->userModel->getAllUsers(); // Comment: Method mới ở UserModel: SELECT * FROM users WHERE role=0
        $title = "Quản lý Người Dùng";
        require_once PATH_ROOT . 'views/admin/user.php';
    }

    // Comment: Xóa user
    public function deleteUser() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
            header("Location: index.php?act=login");
            exit();
        }
        $id = $_GET['id'] ?? 0;
        if ($this->userModel->deleteUser($id)) {
            header("Location: index.php?act=admin-users");
        } else {
            // Comment: Handle error, ví dụ echo 'Lỗi xóa'
            header("Location: index.php?act=admin-users");
        }
    }

    // Comment: Thêm method khác nếu cần (manage products/category/comments - gọi controller tương ứng)
}
