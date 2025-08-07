<?php 

require_once './commons/env.php'; // Khai báo biến môi trường (ví dụ: DB_HOST, DB_NAME, DB_USER, DB_PASS từ file .env hoặc config)
require_once './commons/function.php'; // Hàm hỗ trợ (bao gồm hàm connect_db() để kết nối MySQL qua PDO)

// Require toàn bộ file Controllers 
require_once(__DIR__ . '/controllers/ProductController.php');
require_once(__DIR__ . '/controllers/CategoryController.php');

// Require toàn bộ file Models
require_once(__DIR__ . '/models/ProductModel.php');
require_once(__DIR__ . '/models/CategoryModel.php'); 

// Kết nối database MySQL một lần ở entry point (index.php) để tránh connect nhiều lần, tốt cho hiệu suất
// Giả sử hàm connect_db() ở function.php trả về object PDO (OOP style, an toàn với prepare statement)
$pdo = connect_db(); // Gọi hàm connect_db() để lấy $pdo. Nếu lỗi, hàm này sẽ throw exception hoặc return null

// Kiểm tra kết nối thành công (debug cho sinh viên mới học: in lỗi nếu connect thất bại)
if ($pdo === null) {
    die('Lỗi kết nối MySQL: Kiểm tra biến môi trường ở env.php hoặc hàm connect_db() ở function.php');
}

$act = $_GET['act'] ?? '/';

if (strpos($act, 'category/') === 0) {
    $slug = substr($act, 9);
    // Tạo instance CategoryController và truyền $pdo vào constructor (dependency injection - OOP cơ bản)
    // Giúp controller dùng model để query dữ liệu category từ MySQL
    (new CategoryController($pdo))->show($slug); // Gọi method show trong CategoryController.
} else {
    match ($act) {
        // Trang chủ: Hiển thị danh sách sản phẩm (từ MySQL qua model), view dùng Bootstrap table kiểu đen trắng
        '/' => (new ProductController($pdo))->showHomePage(), // SỬA Ở ĐÂY: Đổi từ home() sang index(), vì index() đã tồn tại trong class ProductController (lấy all products và require view list.php)
        
        // Thêm sản phẩm vào giỏ hàng (logic addToCart trong controller, có thể lưu session hoặc DB)
        // 'add-to-cart' => (new ProductController($pdo))->addToCart(),
        
        // Default: Xử lý 404 nếu act không tồn tại (tốt cho MVC đơn giản)
        default => function() {
            header("HTTP/1.0 404 Not Found");
            echo '<h1>404 Not Found</h1><p>Trang bạn tìm không tồn tại. Quay về <a href="' . BASE_URL . '">trang chủ</a>.</p>';
        },
    };
}