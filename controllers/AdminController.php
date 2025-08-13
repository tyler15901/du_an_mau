<?php
require_once 'models/ProductModel.php';
require_once 'models/CategoryModel.php';
require_once 'models/UserModel.php';
require_once 'models/ReviewModel.php';

class AdminController {
    private $productModel;
    private $categoryModel;
    private $userModel;
    private $reviewModel;
    
    public function __construct() {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->userModel = new UserModel();
        $this->reviewModel = new ReviewModel();
    }
    
    // Trang chủ admin
    public function index() {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
        
        // Thống kê
        $totalProducts = $this->productModel->countProducts();
        $totalCategories = count($this->categoryModel->getAllCategories());
        $totalUsers = $this->userModel->countUsers();
        $totalReviews = $this->reviewModel->countReviews();
        
        // Sản phẩm mới nhất
        $latestProducts = $this->productModel->getAllProducts(5);
        
        // Người dùng mới nhất
        $latestUsers = $this->userModel->getAllUsers();
        $latestUsers = array_slice($latestUsers, 0, 5);
        
        include 'admin/views/dashboard.php';
    }
    
    // Quản lý danh mục
    public function categories() {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
        
        $categories = $this->categoryModel->getAllCategories();
        include 'admin/views/categories.php';
    }
    
    // Thêm danh mục
    public function addCategory() {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            
            // Validate
            if (empty($name)) {
                $_SESSION['error'] = 'Vui lòng nhập tên danh mục';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
            
            $data = [
                'name' => $name,
                'slug' => $this->categoryModel->createSlug($name)
            ];
            
            if ($this->categoryModel->addCategory($data)) {
                $_SESSION['success'] = 'Thêm danh mục thành công';
                header('Location: ' . BASE_URL . 'admin/categories');
                exit;
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra';
            }
        }
        
        include 'admin/views/add-category.php';
    }
    
    // Sửa danh mục
    public function editCategory($id) {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
        
        $category = $this->categoryModel->getCategoryById($id);
        if (!$category) {
            header('Location: ' . BASE_URL . 'admin/categories');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            
            // Validate
            if (empty($name)) {
                $_SESSION['error'] = 'Vui lòng nhập tên danh mục';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
            
            $data = [
                'name' => $name,
                'slug' => $this->categoryModel->createSlug($name)
            ];
            
            if ($this->categoryModel->updateCategory($id, $data)) {
                $_SESSION['success'] = 'Cập nhật danh mục thành công';
                header('Location: ' . BASE_URL . 'admin/categories');
                exit;
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra';
            }
        }
        
        include 'admin/views/edit-category.php';
    }
    
    // Xóa danh mục
    public function deleteCategory($id) {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
        
        // Kiểm tra có sản phẩm trong danh mục không
        $productCount = $this->categoryModel->countProductsInCategory($id);
        if ($productCount > 0) {
            $_SESSION['error'] = 'Không thể xóa danh mục có sản phẩm';
            header('Location: ' . BASE_URL . 'admin/categories');
            exit;
        }
        
        if ($this->categoryModel->deleteCategory($id)) {
            $_SESSION['success'] = 'Xóa danh mục thành công';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra';
        }
        
        header('Location: ' . BASE_URL . 'admin/categories');
        exit;
    }
    
    // Quản lý bình luận
    public function reviews() {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
        
        $reviews = $this->reviewModel->getAllReviews();
        include 'admin/views/manage-reviews.php';
    }
    
    // Xóa bình luận
    public function deleteReview($id) {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
        
        if ($this->reviewModel->deleteReview($id)) {
            $_SESSION['success'] = 'Xóa bình luận thành công';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra';
        }
        
        header('Location: ' . BASE_URL . 'admin/reviews');
        exit;
    }
}
