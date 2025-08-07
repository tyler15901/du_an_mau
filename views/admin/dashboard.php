<?php
// Kiểm tra session để xác thực admin
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php?act=login");
    exit();
}
$title = $title ?? "Bảng điều khiển Admin";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Tùy chỉnh phong cách đen trắng */
        body {
            background-color: #000000; /* Nền đen */
            color: #FFFFFF; /* Chữ trắng */
        }
        .navbar {
            background-color: #333333; /* Navbar tối hơn */
        }
        .admin-panel {
            background-color: #1a1a1a; /* Nền panel màu xám đậm */
            padding: 20px;
            border: 1px solid #555555; /* Viền xám */
        }
        .card {
            background-color: #222222; /* Nền card */
            border: 1px solid #555555; /* Viền xám */
        }
        .btn {
            background-color: #FFFFFF; /* Nút trắng */
            color: #000000; /* Chữ đen trên nút */
        }
        .btn:hover {
            background-color: #CCCCCC; /* Nút xám nhạt khi hover */
        }
    </style>
</head>
<body>
    <!-- Header Admin -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="index.php?act=admin">Admin Panel</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">Xin chào, <?php echo $_SESSION['admin_name'] ?? 'Admin'; ?>!</span>
                <a href="index.php?act=admin-logout" class="btn btn-danger">Đăng xuất</a>
            </div>
        </div>
    </nav>

    <!-- Admin Dashboard -->
    <div class="container mt-4 admin-panel">
        <h2>Bảng điều khiển</h2>
        <div class="row">
            <!-- Quản lý danh mục -->
            <div class="col-12 col-md-3 mb-3">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Quản lý danh mục</h5>
                        <p class="card-text">Thêm, sửa, xóa danh mục sản phẩm.</p>
                        <a href="index.php?act=admin-categories" class="btn">Quản lý</a>
                    </div>
                </div>
            </div>

            <!-- Quản lý sản phẩm -->
            <div class="col-12 col-md-3 mb-3">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Quản lý sản phẩm</h5>
                        <p class="card-text">Thêm, sửa, xóa sản phẩm.</p>
                        <a href="index.php?act=admin-products" class="btn">Quản lý</a>
                    </div>
                </div>
            </div>

            <!-- Quản lý người dùng -->
            <div class="col-12 col-md-3 mb-3">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Quản lý người dùng</h5>
                        <p class="card-text">Xem, chỉnh sửa thông tin người dùng.</p>
                        <a href="index.php?act=admin-users" class="btn">Quản lý</a>
                    </div>
                </div>
            </div>

            <!-- Quản lý bình luận -->
            <div class="col-12 col-md-3 mb-3">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Quản lý bình luận</h5>
                        <p class="card-text">Duyệt, xóa bình luận từ khách hàng.</p>
                        <a href="index.php?act=admin-comments" class="btn">Quản lý</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include '../layouts/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>