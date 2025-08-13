<?php
require_once './commons/env.php';
require_once './commons/function.php';

// Kết nối database
$pdo = connect_db();
if ($pdo === null) {
    die('Lỗi kết nối MySQL');
}

try {
    // Đọc file SQL
    $sql = file_get_contents('database.sql');
    
    // Thực thi các câu lệnh SQL
    $pdo->exec($sql);
    
    echo "Setup database hoàn tất!\n";
    echo "Tài khoản admin: admin@example.com / password\n";
    echo "Tài khoản user: user@example.com / password\n";
    
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage() . "\n";
}
?>
