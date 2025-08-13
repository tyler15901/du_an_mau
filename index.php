<?php 

require_once './commons/env.php'; // Khai báo biến môi trường (ví dụ: DB_HOST, DB_NAME, DB_USER, DB_PASS từ file .env hoặc config)
require_once './commons/function.php'; // Hàm hỗ trợ (bao gồm hàm connect_db() để kết nối MySQL qua PDO)

// Require toàn bộ file Controllers 
require_once(__DIR__ . '/controllers/ProductController.php');
require_once(__DIR__ . '/controllers/CategoryController.php');
require_once(__DIR__ . '/controllers/AdminController.php');

// Require toàn bộ file Models
require_once(__DIR__ . '/models/ProductModel.php');
require_once(__DIR__ . '/models/CategoryModel.php'); 
require_once(__DIR__ . '/models/UserModel.php');
require_once(__DIR__ . '/models/CommentModel.php');

// Kết nối database MySQL một lần ở entry point (index.php) để tránh connect nhiều lần, tốt cho hiệu suất
// Giả sử hàm connect_db() ở function.php trả về object PDO (OOP style, an toàn với prepare statement)
$pdo = connect_db(); // Gọi hàm connect_db() để lấy $pdo. Nếu lỗi, hàm này sẽ throw exception hoặc return null

// Kiểm tra kết nối thành công (debug cho sinh viên mới học: in lỗi nếu connect thất bại)
if ($pdo === null) {
    die('Lỗi kết nối MySQL: Kiểm tra biến môi trường ở env.php hoặc hàm connect_db() ở function.php');
}

$act = $_GET['act'] ?? '/';

// Tạo instance Controllers để xử lý routing
$productController = new ProductController($pdo);
$adminController = new AdminController($pdo);

// Routing logic
switch ($act) {
    case '/':
        $productController->showHomePage();
        break;
    case 'products':
        $productController->showProductsPage();
        break;
    case 'product-detail':
        $id = $_GET['id'] ?? 1;
        $productController->showProductDetail($id);
        break;
    case 'about':
        $productController->showAboutPage();
        break;
    case 'contact':
        $productController->showContactPage();
        break;
    case 'send-contact':
        $productController->sendContact();
        break;
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productController->login();
        } else {
            $productController->showLoginPage();
        }
        break;
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productController->register();
        } else {
            $productController->showRegisterPage();
        }
        break;
    case 'logout':
        $productController->logout();
        break;
    case 'cart':
        $productController->showCart();
        break;
    case 'wishlist':
        $productController->showWishlist();
        break;
    case 'profile':
        $productController->showProfile();
        break;
    case 'orders':
        $productController->showOrders();
        break;
    case 'add-comment':
        $productController->addComment();
        break;
    
    // Admin routes
    case 'admin-dashboard':
        $adminController->dashboard();
        break;
    case 'admin-users':
        $adminController->manageUsers();
        break;
    case 'admin-products':
        $adminController->manageProducts();
        break;
    case 'admin-categories':
        $adminController->manageCategories();
        break;
    case 'admin-comments':
        $adminController->manageComments();
        break;
    case 'admin-add-product':
        $adminController->addProduct();
        break;
    case 'admin-edit-product':
        $adminController->editProduct();
        break;
    case 'admin-delete-user':
        $adminController->deleteUser();
        break;
    case 'admin-delete-product':
        $adminController->deleteProduct();
        break;
    case 'admin-delete-category':
        $adminController->deleteCategory();
        break;
    case 'admin-delete-comment':
        $adminController->deleteComment();
        break;
    
    default:
        if (strpos($act, 'category/') === 0) {
            $slug = substr($act, 9);
            (new CategoryController($pdo))->show($slug);
        } else {
            header("HTTP/1.0 404 Not Found");
            echo '<h1>404 Not Found</h1><p>Trang bạn tìm không tồn tại. Quay về <a href="' . BASE_URL . '">trang chủ</a>.</p>';
        }
        break;
}