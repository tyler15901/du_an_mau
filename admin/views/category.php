<?php
// Kiểm tra session để xác thực admin
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php?act=login");
    exit();
}
$title = $title ?? "Quản lý danh mục";

// Lấy danh sách danh mục từ model (giả định, bạn có thể mở rộng trong CategoryModel.php)
$categories = [
    ['id' => 1, 'name' => 'Áo nam'],
    ['id' => 2, 'name' => 'Quần nam'],
    // Thêm dữ liệu từ CSDL thực tế
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <!-- Bootstrap CSS để sử dụng table và nav -->
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
        .table {
            background-color: #222222; /* Nền bảng xám tối */
            color: #FFFFFF; /* Chữ trắng */
        }
        .table th, .table td {
            border-color: #555555; /* Viền xám */
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
    <!-- Sidebar bên trái: Thanh menu dọc (giống dashboard) -->
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
        <!-- Header trên đầu bên phải: Thông báo và người dùng (giống dashboard) -->
        <div class="header-top">
            <!-- Thông báo -->
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

        <!-- Khu vực quản lý danh mục: Bảng liệt kê và nút Add -->
        <h2>Danh mục</h2>
        <div class="d-flex justify-content-end mb-3">
            <a href="index.php?act=add-category" class="btn btn-success">Add Category</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?php echo $category['id']; ?></td>
                        <td><?php echo $category['name']; ?></td>
                        <td>
                            <a href="index.php?act=edit-category&id=<?php echo $category['id']; ?>" class="btn btn-primary btn-sm">Sửa</a>
                            <a href="index.php?act=delete-category&id=<?php echo $category['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS và Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>