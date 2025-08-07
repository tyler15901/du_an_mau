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
        require_once './models/AdminModel.php';
        require_once './models/CategoryModel.php';
        require_once './models/ProductModel.php';
        require_once './models/UserModel.php';
        require_once './models/CommentModel.php';
        $this->modelAdmin = new AdminModel();
        $this->modelCategory = new CategoryModel();
        $this->modelProduct = new ProductModel();
        $this->modelUser = new UserModel();
        $this->modelComment = new CommentModel();
    }

    public function showDashboard()
    {
        $title = "Bảng điều khiển Admin";
        require_once './views/admin/dashboard.php';
    }

    public function manageCategories()
    {
        $title = "Quản lý danh mục";
        $categories = $this->modelCategory->getAllCategories();
        require_once './views/admin/categories.php';
    }

    public function addCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            if ($this->modelCategory->addCategory($name)) {
                header("Location: index.php?act=admin-categories");
            }
        }
        $title = "Thêm danh mục";
        require_once './views/admin/add-category.php'; // Cần tạo file này
    }

    public function editCategory($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            if ($this->modelCategory->updateCategory($id, $name)) {
                header("Location: index.php?act=admin-categories");
            }
        }
        $title = "Sửa danh mục";
        $category = $this->modelCategory->getAllCategories(); // Cần lấy chi tiết theo ID
        require_once './views/admin/edit-category.php'; // Cần tạo file này
    }

    public function deleteCategory($id)
    {
        if ($this->modelCategory->deleteCategory($id)) {
            header("Location: index.php?act=admin-categories");
        }
        exit();
    }

    public function manageComments()
    {
        $title = "Quản lý bình luận";
        $comments = $this->modelComment->getAllComments();
        require_once './views/admin/comments.php';
    }

    public function deleteComment($id)
    {
        if ($this->modelComment->deleteComment($id)) {
            header("Location: index.php?act=admin-comments");
        }
        exit();
    }

    public function manageProducts()
    {
        $title = "Quản lý sản phẩm";
        $products = $this->modelProduct->getAllProducts();
        require_once './views/admin/products.php';
    }

    public function addProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xử lý thêm sản phẩm (cần thêm logic upload hình ảnh)
            header("Location: index.php?act=admin-products");
        }
        $title = "Thêm sản phẩm";
        $categories = $this->modelCategory->getAllCategories();
        require_once './views/admin/add-product.php'; // Cần tạo file này
    }

    public function editProduct($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xử lý sửa sản phẩm
            header("Location: index.php?act=admin-products");
        }
        $title = "Sửa sản phẩm";
        $product = $this->modelProduct->getProductById($id);
        $categories = $this->modelCategory->getAllCategories();
        require_once './views/admin/edit-product.php'; // Cần tạo file này
    }

    public function deleteProduct($id)
    {
        // Xử lý xóa sản phẩm
        header("Location: index.php?act=admin-products");
        exit();
    }

    public function manageUsers()
    {
        $title = "Quản lý người dùng";
        $users = $this->modelUser->getAllUsers();
        require_once './views/admin/users.php';
    }

    public function editUser($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xử lý sửa người dùng
            header("Location: index.php?act=admin-users");
        }
        $title = "Sửa người dùng";
        $user = $this->modelUser->getAllUsers(); // Cần lấy chi tiết theo ID
        require_once './views/admin/edit-user.php'; // Cần tạo file này
    }

    public function deleteUser($id)
    {
        // Xử lý xóa người dùng
        header("Location: index.php?act=admin-users");
        exit();
    }

    public function adminLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $admin = $this->modelAdmin->checkAdminLogin($email, $password);
            if ($admin) {
                session_start();
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['name'];
                header("Location: index.php?act=admin");
            } else {
                header("Location: index.php?act=admin-login&error=1");
            }
            exit();
        }
        $title = "Đăng nhập Admin";
        $errorMessage = isset($_GET['error']) ? "Email hoặc mật khẩu không đúng!" : "";
        require_once './views/admin/login.php'; // Cần tạo file này
    }

    public function adminLogout()
    {
        session_start();
        session_destroy();
        header("Location: index.php?act=admin-login");
        exit();
    }
}