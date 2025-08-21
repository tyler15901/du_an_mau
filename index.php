<?php 
// Require toàn bộ các file khai báo môi trường, thực thi,...(không require view)

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Require toàn bộ file Controllers
require_once './controllers/ProductController.php';
require_once './controllers/AuthController.php';
require_once './controllers/AdminController.php';

// Require toàn bộ file Models
require_once './models/ProductModel.php';
require_once './models/UserModel.php';
require_once './models/AdminModel.php';

// Route
$act = $_GET['act'] ?? '/';


// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {
    // Trang chủ
    '/' => (new ProductController())->Home(),

    // Danh sách sản phẩm (collection)
    'san-pham' => (new ProductController())->ListProduct(),

    // Chi tiết sản phẩm: ?act=chi-tiet-san-pham&slug=...
    'chi-tiet-san-pham' => (new ProductController())->Detail(),

    // Trang liên hệ
    'lien-he' => (new ProductController())->Contact(),

    // Trang giới thiệu / sứ mệnh
    've-chung-toi' => (new ProductController())->About(),
    // Sản phẩm mới
    'san-pham-moi' => (new ProductController())->NewProducts(),
    // Tìm kiếm sản phẩm
    'tim-kiem' => (new ProductController())->Search(),
    'post-review' => (new ProductController())->PostReview(),

    // Auth
    'login' => (new AuthController())->showLogin(),
    'post-login' => (new AuthController())->loginPost(),
    'register' => (new AuthController())->showRegister(),
    'post-register' => (new AuthController())->registerPost(),
    'logout' => (new AuthController())->logout(),

    // Admin routes
    'admin' => (new AdminController())->dashboard(),
    // Categories
    'admin-categories' => (new AdminController())->categories(),
    'admin-category-create' => (new AdminController())->categoryCreate(),
    'admin-category-store' => (new AdminController())->categoryStore(),
    'admin-category-edit' => (new AdminController())->categoryEdit(),
    'admin-category-update' => (new AdminController())->categoryUpdate(),
    'admin-category-delete' => (new AdminController())->categoryDelete(),
    // Products
    'admin-products' => (new AdminController())->products(),
    'admin-product-create' => (new AdminController())->productCreate(),
    'admin-product-store' => (new AdminController())->productStore(),
    'admin-product-edit' => (new AdminController())->productEdit(),
    'admin-product-update' => (new AdminController())->productUpdate(),
    'admin-product-delete' => (new AdminController())->productDelete(),
    'admin-product-show' => (new AdminController())->productShow(),
    // Users & Reviews (readonly)
    'admin-users' => (new AdminController())->users(),
    'admin-reviews' => (new AdminController())->reviews(),
};