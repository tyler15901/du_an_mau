<?php
// Kiểm tra session để xác thực admin
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php?act=login");
    exit();
}
$title = $title ?? "Sửa sản phẩm";

// Giả định $product là dữ liệu sản phẩm từ controller (lấy theo ID)
$product = $product ?? ['id' => '', 'name' => '', 'price' => '', 'category_id' => '', 'description' => '', 'image' => ''];
// Lấy danh sách danh mục
$categories = $categories ?? [];
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
            background-color: #000000; /* Nền sidebar đen */
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
        .form-control {
            background-color: #222222;
            color: #FFFFFF;
            border-color: #555555;
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
    <!-- Sidebar (giống add-product.php) -->
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

        <!-- Form sửa sản phẩm -->
        <h2>Sửa sản phẩm</h2>
        <form action="index.php?act=edit-product&id=<?php echo $product['id']; ?>" method="POST" enctype="multipart/form-data"> <!-- Action dẫn đến controller xử lý sửa -->
            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $product['name']; ?>" required> <!-- Giá trị từ dữ liệu sản phẩm -->
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Giá</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo $product['price']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Danh mục</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="">Chọn danh mục</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>" <?php if ($category['id'] == $product['category_id']) echo 'selected'; ?>><?php echo $category['name']; ?></option> <!-- Selected nếu trùng -->
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description" rows="5"><?php echo $product['description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh (hiện tại: <?php echo $product['image']; ?>)</label>
                <input type="file" class="form-control" id="image" name="image"> <!-- Upload ảnh mới, hiển thị tên ảnh hiện tại -->
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
        </form>
    </div>

    <!-- Bootstrap JS và Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>