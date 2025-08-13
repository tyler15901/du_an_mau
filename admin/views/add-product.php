<?php
// Kiểm tra session để xác thực admin
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php?act=login");
    exit();
}
$title = $title ?? "Thêm sản phẩm";

// Lấy danh sách danh mục từ model để chọn (giả định từ controller truyền vào)
$categories = $categories ?? []; // Mảng danh mục từ CategoryModel
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #000000; /* Nền đen toàn trang */
            color: #FFFFFF; /* Chữ trắng */
        }
        .sidebar {
            background-color: #000000; /* Nền sidebar đen */
            height: 100vh; /* Full chiều cao */
            position: fixed; /* Cố định bên trái */
            width: 250px; /* Chiều rộng */
            padding-top: 20px; /* Khoảng cách trên */
        }
        .sidebar a {
            color: #FFFFFF; /* Chữ trắng menu */
            text-decoration: none; /* Không gạch chân */
        }
        .sidebar a:hover {
            color: #CCCCCC; /* Xám nhạt khi hover */
        }
        .content {
            margin-left: 250px; /* Khoảng cách tránh che sidebar */
            padding: 20px; /* Padding nội dung */
        }
        .header-top {
            background-color: #1a1a1a; /* Nền header xám đậm */
            padding: 10px; /* Padding */
            display: flex; /* Flex để căn phải */
            justify-content: flex-end; /* Căn phải */
        }
        .form-control {
            background-color: #222222; /* Nền input xám tối */
            color: #FFFFFF; /* Chữ trắng */
            border-color: #555555; /* Viền xám */
        }
        .btn-primary {
            background-color: #FFFFFF; /* Nút trắng */
            color: #000000; /* Chữ đen */
        }
        .btn-primary:hover {
            background-color: #CCCCCC; /* Xám nhạt khi hover */
        }
    </style>
</head>
<body>
    <!-- Sidebar bên trái (giống các trang admin khác) -->
    <div class="sidebar">
        <div class="text-center mb-4">
            <img src="https://via.placeholder.com/150x50?text=Logo" alt="Logo" class="img-fluid"> <!-- Logo, thay bằng logo thực -->
        </div>
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
        <div class="position-absolute bottom-0 w-100 p-3">
            <a href="index.php?act=admin-logout" class="btn btn-danger w-100">Log out</a> <!-- Nút logout dưới cùng -->
        </div>
    </div>

    <!-- Nội dung bên phải -->
    <div class="content">
        <!-- Header trên đầu bên phải -->
        <div class="header-top">
            <a href="#" class="me-3">
                <i class="bi bi-bell"></i> Thông báo <span class="badge bg-danger">3</span> <!-- Icon thông báo với badge -->
            </a>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                    <i class="bi bi-person"></i> Admin <!-- Icon người dùng -->
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="index.php?act=admin-logout">Log out</a></li>
                </ul>
            </div>
        </div>

        <!-- Form thêm sản phẩm -->
        <h2>Thêm sản phẩm</h2>
        <form action="index.php?act=add-product" method="POST" enctype="multipart/form-data"> <!-- Action dẫn đến controller xử lý thêm, enctype cho upload ảnh -->
            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm</label>
                <input type="text" class="form-control" id="name" name="name" required> <!-- Input tên sản phẩm -->
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Giá</label>
                <input type="number" class="form-control" id="price" name="price" required> <!-- Input giá -->
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Danh mục</label>
                <select class="form-select" id="category_id" name="category_id" required> <!-- Select danh mục -->
                    <option value="">Chọn danh mục</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option> <!-- Lặp danh mục từ mảng -->
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description" rows="5"></textarea> <!-- Textarea mô tả -->
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh</label>
                <input type="file" class="form-control" id="image" name="image"> <!-- Input upload ảnh -->
            </div>
            <button type="submit" class="btn btn-primary">Thêm sản phẩm</button> <!-- Nút submit -->
        </form>
    </div>

    <!-- Bootstrap JS và Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>