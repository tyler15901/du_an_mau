<?php
// Kiểm tra session để xác thực admin
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php?act=login");
    exit();
}
$title = $title ?? "Bảng điều khiển Admin";

// Lấy dữ liệu từ model (giả định các model đã được khởi tạo trong controller)
$categories = $categories ?? []; // Danh sách danh mục
$products = $products ?? []; // Danh sách sản phẩm
$users = $users ?? []; // Danh sách người dùng
$comments = $comments ?? []; // Danh sách bình luận
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
        .table {
            background-color: #222222; /* Nền bảng */
            color: #FFFFFF; /* Chữ trắng */
        }
        .table th, .table td {
            border-color: #555555; /* Viền bảng */
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

    <!-- Admin Dashboard with Unified Table -->
    <div class="container mt-4 admin-panel">
        <h2>Bảng điều khiển</h2>
        <p>Quản lý nhanh các loại dữ liệu. Nhấn vào "Quản lý chi tiết" để xem toàn bộ hoặc thực hiện thêm/sửa.</p>
        <table class="table">
            <thead>
                <tr>
                    <th>Loại</th>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Thông tin thêm</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <!-- Danh mục -->
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td>Danh mục</td>
                        <td><?php echo $category['id'] ?? ''; ?></td>
                        <td><?php echo $category['name'] ?? ''; ?></td>
                        <td>-</td>
                        <td>
                            <a href="index.php?act=admin-categories" class="btn btn-info btn-sm me-1">Quản lý chi tiết</a>
                            <a href="index.php?act=edit-category&id=<?php echo $category['id'] ?? ''; ?>" class="btn btn-primary btn-sm">Sửa</a>
                            <a href="index.php?act=delete-category&id=<?php echo $category['id'] ?? ''; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <!-- Sản phẩm -->
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td>Sản phẩm</td>
                        <td><?php echo $product['id'] ?? ''; ?></td>
                        <td><?php echo $product['name'] ?? ''; ?></td>
                        <td><?php echo number_format($product['price'] ?? 0, 0, ',', '.') . ' VNĐ'; ?></td>
                        <td>
                            <a href="index.php?act=admin-products" class="btn btn-info btn-sm me-1">Quản lý chi tiết</a>
                            <a href="index.php?act=edit-product&id=<?php echo $product['id'] ?? ''; ?>" class="btn btn-primary btn-sm">Sửa</a>
                            <a href="index.php?act=delete-product&id=<?php echo $product['id'] ?? ''; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <!-- Người dùng -->
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td>Người dùng</td>
                        <td><?php echo $user['id'] ?? ''; ?></td>
                        <td><?php echo $user['name'] ?? ''; ?></td>
                        <td><?php echo $user['email'] ?? ''; ?></td>
                        <td>
                            <a href="index.php?act=admin-users" class="btn btn-info btn-sm me-1">Quản lý chi tiết</a>
                            <a href="index.php?act=edit-user&id=<?php echo $user['id'] ?? ''; ?>" class="btn btn-primary btn-sm">Sửa</a>
                            <a href="index.php?act=delete-user&id=<?php echo $user['id'] ?? ''; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <!-- Bình luận -->
                <?php foreach ($comments as $comment): ?>
                    <tr>
                        <td>Bình luận</td>
                        <td><?php echo $comment['id'] ?? ''; ?></td>
                        <td><?php echo $comment['user'] ?? ''; ?></td>
                        <td><?php echo $comment['content'] ?? ''; ?></td>
                        <td>
                            <a href="index.php?act=admin-comments" class="btn btn-info btn-sm me-1">Quản lý chi tiết</a>
                            <a href="index.php?act=delete-comment&id=<?php echo $comment['id'] ?? ''; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="mt-3">
            <a href="index.php?act=add-category" class="btn btn-success me-2">Thêm danh mục</a>
            <a href="index.php?act=add-product" class="btn btn-success">Thêm sản phẩm</a>
        </div>
    </div>

    <!-- Footer -->
    <?php include '../layouts/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>