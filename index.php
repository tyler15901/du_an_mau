<?php 

require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ 

// Require toàn bộ file Controllers 
require_once './controllers/ProductController.php'; 
require_once './controllers/CategoryController.php'; 

// Require toàn bộ file Models
require_once './models/ProductModel.php';
require_once './models/CategoryModel.php'; 
require_once './models/BannerModel.php'; 

$act = $_GET['act'] ?? '/';

if (strpos($act, 'category/') === 0) {
    $slug = substr($act, 9);
    (new CategoryController())->show($slug); // Gọi method show trong CategoryController.
} else {
    match ($act) {
        // Trang chủ.
        '/' => (new ProductController())->home(),

        // Default
        default => function() {
            header("HTTP/1.0 404 Not Found");
            echo '<h1>404 Not Found</h1><p>Trang bạn tìm không tồn tại. Quay về <a href="' . BASE_URL . '">trang chủ</a>.</p>';
        },
    };
}