<?php
// Kiểm tra session hoặc dữ liệu từ controller
$title = $title ?? "Danh mục sản phẩm";
$category = $category ?? []; // Thông tin danh mục từ model
$products = $products ?? []; // Danh sách sản phẩm từ model
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>assets/css/base.css?v=1.0.1" rel="stylesheet">
    <link href="<?= BASE_URL ?>assets/css/public.css?v=1.0.1" rel="stylesheet">
</head>
<body class="category-page">
    <!-- Header -->
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?= BASE_URL ?>">
                <i class="fas fa-tshirt me-2"></i>Fashion Store
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>products">Tất cả sản phẩm</a></li>
                </ul>
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i><?= $_SESSION['user_name'] ?>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if ($_SESSION['role'] === 'admin'): ?>
                                    <li><a class="dropdown-item" href="<?= BASE_URL ?>admin">Quản lý</a></li>
                                <?php endif; ?>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>logout">Đăng xuất</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>login">Đăng nhập</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>register">Đăng ký</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Category Section -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h2><?php echo $category['name'] ?? 'Danh mục'; ?></h2>
                <p><?php echo $category['description'] ?? 'Các sản phẩm trong danh mục này'; ?></p>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-12 col-md-3 mb-3">
                    <div class="card h-100">
                        <img src="https://via.placeholder.com/200x200" class="card-img-top" alt="<?php echo $product['name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['name']; ?></h5>
                            <p class="card-text"><?php echo number_format($product['price'], 0, ',', '.') . ' VNĐ'; ?></p>
                            <a href="index.php?act=product-detail&id=<?php echo $product['id']; ?>" class="btn">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <?php if (empty($products)): ?>
            <div class="row">
                <div class="col-12 text-center">
                    <p>Không có sản phẩm nào trong danh mục này.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fas fa-tshirt me-2"></i>Fashion Store</h5>
                    <p>Chuyên cung cấp thời trang nam chất lượng cao với phong cách hiện đại và giá cả hợp lý.</p>
                </div>
                <div class="col-md-2">
                    <h5>Danh mục</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?= BASE_URL ?>products">Tất cả sản phẩm</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Thông tin</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?= BASE_URL ?>about">Về chúng tôi</a></li>
                        <li><a href="<?= BASE_URL ?>contact">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Liên hệ</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-map-marker-alt me-2"></i>123 Đường ABC, Quận 1, TP.HCM</li>
                        <li><i class="fas fa-phone me-2"></i>0123 456 789</li>
                        <li><i class="fas fa-envelope me-2"></i>info@fashionstore.com</li>
                    </ul>
                </div>
            </div>
            <hr class="mt-4 mb-3">
            <div class="text-center">
                <p>&copy; 2024 Fashion Store. Tất cả quyền được bảo lưu.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL ?>assets/js/custom.js"></script>
</body>
</html>
