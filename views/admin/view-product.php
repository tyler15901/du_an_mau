<?php
// Kiểm tra session để xác thực admin
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php?act=login");
    exit();
}
$title = $title ?? "Xem chi tiết sản phẩm";

// Giả định $product là dữ liệu sản phẩm từ controller (lấy theo ID)
$product = $product ?? ['id' => '', 'name' => '', 'price' => '', 'category_name' => '', 'description' => '', 'image' => ''];
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
            background-color: #000000; /* Nền đen */
            color: #FFFFFF; /* Chữ trắng */
        }
        .sidebar {
            background-color: #000000;
            height: 100vh;
            position: fixed;
            width: 250px;
            padding-top: 20px;
        }
        .sidebar a {
            color: #FFFFFF;
            text-decoration: none;
        }
        .sidebar a:hover {
            color: #CCCCCC;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .header-top {
            background-color: #1a1a1a;
            padding: 10px;
            display: flex;
            justify-content: flex-end;
        }
        .detail-card {
            background-color: #222222; /* Nền card xám tối */
            border: 1px solid #555555; /* Viền xám */
            padding: 15px;
        }
        .btn-primary {
            background-color: #FFFFFF;
            color: #000000;
        }
        .btn-primary:hover {
            background-color: #CCCCCC;
        }
    </style>
</head>
<body>
    <!-- Sidebar (giống các file khác) -->
    <div class="sidebar">
        <div class="text-center mb-4">
            <img src="https://via.placeholder.com/150x50?text=Logo" alt="Logo" class="img-fluid">
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
            <a href="index.php?act=admin-logout" class="btn btn-danger w-100">Log out</a>
        </div>
    </div>

    <!-- Nội dung -->
    <div class="content">
        <!-- Header top -->
        <div class="header-top">
            <a href="#" class="me-3">
                <i class="bi bi-bell"></i> Thông báo <span class="badge bg-danger">3</span>
            </a>
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

        <!-- Hiển thị chi tiết sản phẩm -->
        <h2>Chi tiết sản phẩm</h2>
        <div class="detail-card">
            <h4>Tên: <?php echo $product['name']; ?></h4>
            <p>Giá: <?php echo number_format($product['price'], 0, ',', '.') . ' VNĐ'; ?></p>
            <p>Danh mục: <?php echo $product['category_name']; ?></p>
            <p>Mô tả: <?php echo $product['description']; ?></p>
            <img src="<?php echo $product['image']; ?>" alt="Hình ảnh sản phẩm" class="img-fluid" style="max-width: 300px;"> <!-- Hiển thị ảnh -->
        </div>
        <a href="index.php?act=admin-products" class="btn btn-primary mt-3">Quay lại danh sách</a> <!-- Nút quay lại -->
    </div>

    <!-- Bootstrap JS và Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>