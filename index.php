<?php
require_once 'commons/env.php';
require_once 'commons/function.php';

// Khởi tạo session
session_start();

// Lấy URL path (ổn định với hoặc không có dấu gạch chéo cuối)
$requestUriPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = rtrim(parse_url(BASE_URL, PHP_URL_PATH), '/');

// Loại bỏ basePath ở đầu nếu có, chấp nhận cả có/không có '/'
$normalizedPath = preg_replace('#^' . preg_quote($basePath, '#') . '/?#', '', $requestUriPath);
$path = trim($normalizedPath, '/');

// Nếu path rỗng, chuyển về trang chủ
if (empty($path)) {
    $path = 'home';
}

// Tách path thành các phần
$segments = explode('/', $path);
$controller = $segments[0] ?? 'home';
$action = $segments[1] ?? 'index';
$params = array_slice($segments, 2);

// Xử lý routing
try {
    // Nếu là admin đã đăng nhập và đang ở trang chủ, chuyển vào dashboard admin
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin' && ($controller === 'home' || $controller === '')) {
        header('Location: ' . BASE_URL . 'admin');
        exit;
    }

    switch ($controller) {
        case 'home':
            require_once 'controllers/ProductController.php';
            $productController = new ProductController();
            $productController->index();
            break;
            
        case 'products':
            require_once 'controllers/ProductController.php';
            $productController = new ProductController();
            
            if ($action === 'list') {
                $productController->listProducts();
            } elseif ($action === 'detail' && isset($params[0])) {
                $productController->detail($params[0]);
            } elseif ($action === 'review') {
                $productController->addReview();
            } else {
                $productController->listProducts();
            }
            break;
            
        case 'login':
            require_once 'controllers/UserController.php';
            $userController = new UserController();
            $userController->login();
            break;
            
        case 'register':
            require_once 'controllers/UserController.php';
            $userController = new UserController();
            $userController->register();
            break;
            
        case 'logout':
            require_once 'controllers/UserController.php';
            $userController = new UserController();
            $userController->logout();
            break;
            
        case 'admin':
            require_once 'controllers/AdminController.php';
            $adminController = new AdminController();
            
            switch ($action) {
                case 'index':
                case '':
                    $adminController->index();
                    break;
                    
                case 'categories':
                    if (isset($params[0]) && $params[0] === 'add') {
                        $adminController->addCategory();
                    } elseif (isset($params[0]) && $params[0] === 'edit' && isset($params[1])) {
                        $adminController->editCategory($params[1]);
                    } elseif (isset($params[0]) && $params[0] === 'delete' && isset($params[1])) {
                        $adminController->deleteCategory($params[1]);
                    } else {
                        $adminController->categories();
                    }
                    break;
                    
                case 'products':
                    require_once 'controllers/ProductController.php';
                    $productController = new ProductController();
                    
                    if (isset($params[0]) && $params[0] === 'add') {
                        $productController->adminAdd();
                    } elseif (isset($params[0]) && $params[0] === 'edit' && isset($params[1])) {
                        $productController->adminEdit($params[1]);
                    } elseif (isset($params[0]) && $params[0] === 'delete' && isset($params[1])) {
                        $productController->adminDelete($params[1]);
                    } else {
                        $productController->adminList();
                    }
                    break;
                    
                case 'users':
                    require_once 'controllers/UserController.php';
                    $userController = new UserController();
                    
                    if (isset($params[0]) && $params[0] === 'detail' && isset($params[1])) {
                        $userController->adminDetail($params[1]);
                    } elseif (isset($params[0]) && $params[0] === 'delete' && isset($params[1])) {
                        $userController->adminDelete($params[1]);
                    } else {
                        $userController->adminList();
                    }
                    break;
                    
                case 'reviews':
                    if (isset($params[0]) && $params[0] === 'delete' && isset($params[1])) {
                        $adminController->deleteReview($params[1]);
                    } else {
                        $adminController->reviews();
                    }
                    break;
                    
                default:
                    $adminController->index();
                    break;
            }
            break;
            
        default:
            // Nếu không tìm thấy route, chuyển về trang chủ
            require_once 'controllers/ProductController.php';
            $productController = new ProductController();
            $productController->index();
            break;
    }
} catch (Exception $e) {
    // Xử lý lỗi
    echo "Có lỗi xảy ra: " . $e->getMessage();
}
?>