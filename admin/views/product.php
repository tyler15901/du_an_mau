<?php
// Kiểm tra session để xác thực admin
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php?act=login");
    exit();
}
$title = $title ?? "Quản lý sản phẩm";

// Lấy danh sách sản phẩm từ model
$products = $products ?? []; // Từ controller
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
            background-color: #000000;
            color: #FFFFFF;
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
        .table {
            background-color: #222222;
            color: #FFFFFF;
        }
        .table th, .table td {
            border-color: #555555;
        }
        .btn-success {
            background-color: #FFFFFF;
            color: #000000;
        }
        .btn-success:hover {
            background-color: #CCCCCC;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
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

        <h2>Sản phẩm</h2>
        <div class="d-flex justify-content-end mb-3">
            <a href="index.php?act=add-product" class="btn btn-success">Add Product</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Danh mục</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo number_format($product['price'], 0, ',', '.') . ' VNĐ'; ?></td>
                        <td><?php echo $product['category_name']; ?></td>
                        <td>
                            <a href="index.php?act=view-product&id=<?php echo $product['id']; ?>" class="btn btn-info btn-sm">Xem</a> <!-- Liên kết xem chi tiết -->
                            <a href="index.php?act=edit-product&id=<?php echo $product['id']; ?>" class="btn btn-primary btn-sm">Sửa</a>
                            <a href="index.php?act=delete-product&id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS và Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>