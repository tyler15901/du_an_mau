<?php
// Kiểm tra session để xác thực admin
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php?act=login");
    exit();
}
$title = $title ?? "Bảng điều khiển Admin";

// Lấy dữ liệu thống kê từ model (giả định, bạn có thể mở rộng trong AdminModel.php)
$viewCount = 1000; // Lượt xem sản phẩm (lấy từ CSDL)
$saleCount = 200; // Lượt bán (lấy từ CSDL)
$conversionRate = ($saleCount / $viewCount) * 100; // Tỷ lệ chuyển đổi
$currentDate = date('d/m/Y'); // Ngày tháng hiện tại
$balance = 50000000; // Số dư (giả định, đơn vị VNĐ)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <!-- Bootstrap CSS để sử dụng grid và nav -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Tùy chỉnh phong cách đen trắng toàn trang */
        body {
            background-color: #000000; /* Nền đen */
            color: #FFFFFF; /* Chữ trắng */
        }
        .sidebar {
            background-color: #000000; /* Nền sidebar đen */
            height: 100vh; /* Chiều cao full màn hình */
            position: fixed; /* Cố định bên trái */
            width: 250px; /* Chiều rộng sidebar */
            padding-top: 20px;
        }
        .sidebar a {
            color: #FFFFFF; /* Chữ trắng trong menu */
            text-decoration: none;
        }
        .sidebar a:hover {
            color: #CCCCCC; /* Màu xám nhạt khi hover */
        }
        .content {
            margin-left: 250px; /* Khoảng cách để tránh che sidebar */
            padding: 20px;
        }
        .header-top {
            background-color: #1a1a1a; /* Nền header xám đậm */
            padding: 10px;
            display: flex;
            justify-content: flex-end; /* Căn phải */
        }
        .stats-card {
            background-color: #222222; /* Nền card xám tối */
            border: 1px solid #555555; /* Viền xám */
            padding: 15px;
            margin-bottom: 20px;
        }
        .btn-success {
            background-color: #FFFFFF; /* Nút trắng để phù hợp đen trắng */
            color: #000000;
        }
        .btn-success:hover {
            background-color: #CCCCCC;
        }
    </style>
</head>
<body>
    <!-- Sidebar bên trái: Thanh menu dọc -->
    <div class="sidebar">
        <!-- Logo trên cùng (thay bằng logo của bạn) -->
        <div class="text-center mb-4">
            <img src="https://via.placeholder.com/150x50?text=Logo" alt="Logo" class="img-fluid">
        </div>
        <!-- Menu các mục -->
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="index.php?act=admin-dashboard">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?act=admin-categories">Danh mục sản phẩm</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?act=admin-users">Người dùng</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?act=admin-comments">Bình luận</a>
            </li>
        </ul>
        <!-- Nút đăng xuất dưới cùng -->
        <div class="position-absolute bottom-0 w-100 p-3">
            <a href="index.php?act=admin-logout" class="btn btn-danger w-100">Log out</a>
        </div>
    </div>

    <!-- Nội dung bên phải -->
    <div class="content">
        <!-- Header trên đầu bên phải: Thông báo và người dùng -->
        <div class="header-top">
            <!-- Thông báo (giả định, có thể thêm badge cho số lượng) -->
            <a href="#" class="me-3">
                <i class="bi bi-bell"></i> Thông báo <span class="badge bg-danger">3</span>
            </a>
            <!-- Người dùng dropdown -->
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                    <i class="bi bi-person"></i> Admin
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="index.php?act=admin-logout">Log out</a></li>
                </ul>
            </div>
        </div>

        <!-- Khu vực thống kê -->
        <h2>Thống kê</h2>
        <div class="row">
            <!-- Card lượt xem sản phẩm -->
            <div class="col-md-4">
                <div class="stats-card">
                    <h4>Lượt xem sản phẩm</h4>
                    <p><?php echo $viewCount; ?></p>
                </div>
            </div>
            <!-- Card lượt bán -->
            <div class="col-md-4">
                <div class="stats-card">
                    <h4>Lượt bán</h4>
                    <p><?php echo $saleCount; ?></p>
                </div>
            </div>
            <!-- Card tỷ lệ chuyển đổi -->
            <div class="col-md-4">
                <div class="stats-card">
                    <h4>Tỷ lệ chuyển đổi</h4>
                    <p><?php echo number_format($conversionRate, 2); ?>%</p>
                </div>
            </div>
            <!-- Card ngày tháng -->
            <div class="col-md-4">
                <div class="stats-card">
                    <h4>Ngày tháng</h4>
                    <p><?php echo $currentDate; ?></p>
                </div>
            </div>
            <!-- Card số dư -->
            <div class="col-md-4">
                <div class="stats-card">
                    <h4>Số dư</h4>
                    <p><?php echo number_format($balance, 0, ',', '.') . ' VNĐ'; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS và Bootstrap Icons (cho icon bell và person) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>