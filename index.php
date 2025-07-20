<?php 
// Comment: Require toàn bộ file commons, controllers, models.
require_once './commons/env.php'; // Khai báo biến môi trường.
require_once './commons/function.php'; // Hàm hỗ trợ.

require_once './controllers/ProductController.php'; // Controller cho sản phẩm và trang chủ.
require_once './controllers/CategoryController.php'; // Thêm Controller cho danh mục.

require_once './models/ProductModel.php'; // Model cho sản phẩm.
require_once './models/CategoryModel.php'; // Thêm Model cho danh mục.
require_once './models/BannerModel.php'; // Thêm Model cho banner (tạo mới dưới).

// Comment: Route qua $_GET['act'], sử dụng match để gọi hàm Controller.
$act = $_GET['act'] ?? '/';

match ($act) {
    // Trang chủ.
    '/' => (new ProductController())->home(), // Gọi method home() trong ProductController để load trang chủ.

    // Trang danh mục (e.g., /category/ao-polo).
    '/category/{slug}' => (new CategoryController())->show($_GET['slug']), // Giả sử route động, nhưng để đơn giản, dùng $_GET['act'] = 'category' và $_GET['slug'].

    default => echo '404 Not Found', // Xử lý lỗi route không tồn tại.
};