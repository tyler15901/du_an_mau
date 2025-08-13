<?php
require_once 'models/ProductModel.php';
require_once 'models/CategoryModel.php';
require_once 'models/ReviewModel.php';

class ProductController {
    private $productModel;
    private $categoryModel;
    private $reviewModel;
    
    public function __construct() {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->reviewModel = new ReviewModel();
    }
    
    // Hiển thị trang chủ
    public function index() {
        $categories = $this->categoryModel->getAllCategories();
        $featuredProducts = $this->productModel->getAllProducts(8); // Lấy 8 sản phẩm nổi bật
        
        include 'views/homepage.php';
    }
    
    // Hiển thị danh sách sản phẩm
    public function listProducts() {
        $categories = $this->categoryModel->getAllCategories();
        
        // Xử lý filter và search
        $categoryId = isset($_GET['category']) ? $_GET['category'] : null;
        $search = isset($_GET['search']) ? $_GET['search'] : null;
        $minPrice = isset($_GET['min_price']) ? $_GET['min_price'] : null;
        $maxPrice = isset($_GET['max_price']) ? $_GET['max_price'] : null;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
        
        // Lấy sản phẩm theo điều kiện
        if ($search) {
            $products = $this->productModel->searchProducts($search);
        } elseif ($categoryId) {
            $products = $this->productModel->getProductsByCategory($categoryId);
        } elseif ($minPrice && $maxPrice) {
            $products = $this->productModel->filterProductsByPrice($minPrice, $maxPrice);
        } else {
            $products = $this->productModel->getAllProducts();
        }
        
        // Sắp xếp sản phẩm
        if ($sort === 'price_asc') {
            usort($products, function($a, $b) {
                return $a['price'] - $b['price'];
            });
        } elseif ($sort === 'price_desc') {
            usort($products, function($a, $b) {
                return $b['price'] - $a['price'];
            });
        } elseif ($sort === 'name_asc') {
            usort($products, function($a, $b) {
                return strcmp($a['name'], $b['name']);
            });
        }
        
        include 'views/products.php';
    }
    
    // Hiển thị chi tiết sản phẩm
    public function detail($slug) {
        $product = $this->productModel->getProductBySlug($slug);
        if (!$product) {
            header('Location: ' . BASE_URL);
            exit;
        }
        
        $categories = $this->categoryModel->getAllCategories();
        $reviews = $this->reviewModel->getReviewsByProduct($product['id']);
        $averageRating = $this->reviewModel->getAverageRating($product['id']);
        
        // Lấy sản phẩm liên quan (cùng danh mục)
        $relatedProducts = $this->productModel->getProductsByCategory($product['category_id'], 4);
        
        include 'views/product-detail.php';
    }
    
    // Thêm bình luận
    public function addReview() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL);
            exit;
        }
        
        // Kiểm tra đăng nhập
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
        
        $productId = $_POST['product_id'];
        $comment = trim($_POST['comment']);
        $rating = $_POST['rating'];
        
        // Validate
        if (empty($comment)) {
            $_SESSION['error'] = 'Vui lòng nhập nội dung bình luận';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        
        if ($rating < 1 || $rating > 5) {
            $_SESSION['error'] = 'Đánh giá không hợp lệ';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        
        // Kiểm tra đã bình luận chưa
        if ($this->reviewModel->hasUserReviewed($_SESSION['user_id'], $productId)) {
            $_SESSION['error'] = 'Bạn đã bình luận sản phẩm này rồi';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
        
        $data = [
            'product_id' => $productId,
            'user_id' => $_SESSION['user_id'],
            'comment' => $comment,
            'rating' => $rating
        ];
        
        if ($this->reviewModel->addReview($data)) {
            $_SESSION['success'] = 'Bình luận đã được gửi thành công';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại';
        }
        
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    
    // Admin: Quản lý sản phẩm
    public function adminList() {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
        
        $products = $this->productModel->getAllProducts();
        include 'admin/views/manage-products.php';
    }
    
    // Admin: Thêm sản phẩm
    public function adminAdd() {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $price = (int)$_POST['price'];
            $categoryId = (int)$_POST['category_id'];
            $description = trim($_POST['description']);
            $stock = (int)$_POST['stock'];
            
            // Validate
            if (empty($name) || $price <= 0 || $categoryId <= 0 || $stock < 0) {
                $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin hợp lệ';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
            
            // Upload ảnh
            $image = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $image = uploadFile($_FILES['image'], 'uploads/imgproduct/');
                if (!$image) {
                    $_SESSION['error'] = 'Lỗi upload ảnh';
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                    exit;
                }
            }
            
            $slug = $this->productModel->createSlug($name);
            
            $data = [
                'name' => $name,
                'price' => $price,
                'category_id' => $categoryId,
                'description' => $description,
                'image' => $image,
                'stock' => $stock,
                'slug' => $slug
            ];
            
            if ($this->productModel->addProduct($data)) {
                $_SESSION['success'] = 'Thêm sản phẩm thành công';
                header('Location: ' . BASE_URL . 'admin/products');
                exit;
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra';
            }
        }
        
        $categories = $this->categoryModel->getAllCategories();
        include 'admin/views/add-product.php';
    }
    
    // Admin: Sửa sản phẩm
    public function adminEdit($id) {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
        
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            header('Location: ' . BASE_URL . 'admin/products');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $price = (int)$_POST['price'];
            $categoryId = (int)$_POST['category_id'];
            $description = trim($_POST['description']);
            $stock = (int)$_POST['stock'];
            
            // Validate
            if (empty($name) || $price <= 0 || $categoryId <= 0 || $stock < 0) {
                $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin hợp lệ';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
            
            $data = [
                'name' => $name,
                'price' => $price,
                'category_id' => $categoryId,
                'description' => $description,
                'stock' => $stock,
                'slug' => $this->productModel->createSlug($name)
            ];
            
            // Upload ảnh mới nếu có
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $image = uploadFile($_FILES['image'], 'uploads/imgproduct/');
                if ($image) {
                    $data['image'] = $image;
                    // Xóa ảnh cũ
                    if (!empty($product['image'])) {
                        deleteFile($product['image']);
                    }
                }
            }
            
            if ($this->productModel->updateProduct($id, $data)) {
                $_SESSION['success'] = 'Cập nhật sản phẩm thành công';
                header('Location: ' . BASE_URL . 'admin/products');
                exit;
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra';
            }
        }
        
        $categories = $this->categoryModel->getAllCategories();
        include 'admin/views/edit-product.php';
    }
    
    // Admin: Xóa sản phẩm
    public function adminDelete($id) {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
        
        if ($this->productModel->deleteProduct($id)) {
            $_SESSION['success'] = 'Xóa sản phẩm thành công';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra';
        }
        
        header('Location: ' . BASE_URL . 'admin/products');
        exit;
    }
}
