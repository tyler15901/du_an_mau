<?php
// Kiểm tra session để xác thực admin
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php?act=login");
    exit();
}
$title = $title ?? "Quản lý bình luận";
$comments = $comments ?? []; // Danh sách bình luận từ model
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

    <!-- Comments Management -->
    <div class="container mt-4 admin-panel">
        <h2>Quản lý bình luận</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Người dùng</th>
                    <th>Nội dung</th>
                    <th>Ngày</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($comments as $comment): ?>
                    <tr>
                        <td><?php echo $comment['id'] ?? ''; ?></td>
                        <td><?php echo $comment['user'] ?? ''; ?></td>
                        <td><?php echo $comment['content'] ?? ''; ?></td>
                        <td><?php echo $comment['date'] ?? ''; ?></td>
                        <td>
                            <a href="index.php?act=delete-comment&id=<?php echo $comment['id'] ?? ''; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</a>
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