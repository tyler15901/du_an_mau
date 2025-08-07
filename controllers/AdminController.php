<?php
// Có class chứa các function thực thi xử lý logic cho admin
class AdminController
{
    public $modelAdmin;
    public $modelCategory;
    public $modelProduct;
    public $modelUser;
    public $modelComment;

    public function __construct()
    {
        $this->modelAdmin = new AdminModel();
        $this->modelCategory = new CategoryModel();
        $this->modelProduct = new ProductModel();
        $this->modelUser = new UserModel();
        $this->modelComment = new CommentModel();
    }

    // ... (các function khác giữ nguyên, như showDashboard, manageCategories, v.v.)

    // Quản lý người dùng (đã có, giữ nguyên để hiển thị bảng)
    public function manageUsers()
    {
        $title = "Quản lý người dùng";
        $users = $this->modelUser->getAllUsers();
        require_once './views/admin/users.php';
    }


    // Mới: Xóa người dùng
    public function deleteUser($id)
    {
        if ($this->modelUser->deleteUser($id)) { // Gọi hàm deleteUser từ model
            header("Location: index.php?act=admin-users");
            exit();
        }
    }
}