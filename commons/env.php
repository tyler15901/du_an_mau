<?php
// Comment: Biến môi trường toàn cục, dùng define để constant (không thay đổi), phù hợp MVC
define('BASE_URL', 'http://localhost/du_an_mau/'); // Comment: URL gốc cho link/img (thay nếu deploy server)
define('PATH_ROOT', __DIR__ . '/../'); // Comment: Đường dẫn gốc folder dự án, dùng cho require/include
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'du_an_mau');
define('UPLOAD_DIR', PATH_ROOT . 'uploads/'); // Comment: Folder upload, thêm để dễ dùng trong function.php
define('SITE_NAME', 'Website Bán Hàng'); 
?>