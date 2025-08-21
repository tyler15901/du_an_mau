<?php 

// Biến môi trường, dùng chung toàn hệ thống
// Khai báo dưới dạng HẰNG SỐ để không phải dùng $GLOBALS

// Lưu ý: đường dẫn đúng theo thư mục dự án hiện tại `du_an_mau`
define('BASE_URL'       , 'http://localhost/du_an_mau/');

define('DB_HOST'    , 'localhost');
define('DB_PORT'    , 3306);
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME'    , 'du_an_mau');

define('PATH_ROOT'    , __DIR__ . '/../');
