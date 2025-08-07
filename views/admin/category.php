<?php
// Kiểm tra session để xác thực admin
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php?act=login");
    exit();
}
$title = $title ?? "Quản lý danh mục";
$categories = $categories ?? []; // Danh sách danh mục từ model
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
    <?php include 'header-admin.php'; ?>

    <!-- Categories Management -->
    <div class="container mt-4 admin-panel">
        <h2>Quản lý danh mục</h2>
        <a href="index.php?act=add-category" class="btn mb-3">Thêm danh mục mới</a>
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
                        <td><?php echo $category['id'] ?? ''; ?></td>
                        <td><?php echo $category['name'] ?? ''; ?></td>
                        <td>
                            <a href="index.php?act=edit-category&id=<?php echo $category['id'] ?? ''; ?>" class="btn btn-primary btn-sm">Sửa</a>
                            <a href="index.php?act=delete-category&id=<?php echo $category['id'] ?? ''; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <?php include '../layouts/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>