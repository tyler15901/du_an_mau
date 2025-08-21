<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Store - Thời trang nam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>assets/css/base.css?v=1.0.1" rel="stylesheet">
    <link href="<?= BASE_URL ?>assets/css/public.css?v=1.0.1" rel="stylesheet">
</head>
<body class="homepage public-theme with-fixed-top">
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
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>">Trang chủ</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Sản phẩm
                        </a>
                        <ul class="dropdown-menu">
                            <?php foreach ($categories as $category): ?>
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>products?category=<?= $category['id'] ?>"><?= $category['name'] ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>products">Tất cả sản phẩm</a>
                    </li>
                </ul>
                
                <!-- Search Box -->
                <form class="d-flex search-box me-3" action="<?= BASE_URL ?>products" method="GET">
                    <input class="form-control me-2" type="search" name="search" placeholder="Tìm kiếm sản phẩm...">
                    <button class="btn btn-outline-light" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                
                <!-- User Menu -->
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
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>login">Đăng nhập</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>register">Đăng ký</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title">Thời Trang Nam</h1>
            <p class="hero-subtitle">Phong cách hiện đại, chất lượng cao cấp</p>
            <a href="<?= BASE_URL ?>products" class="btn btn-primary btn-lg">
                <i class="fas fa-shopping-bag me-2"></i>Mua sắm ngay
            </a>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="category-section">
        <div class="container">
            <h2 class="text-center mb-5">Danh Mục Sản Phẩm</h2>
            <div class="row">
                <?php foreach ($categories as $category): ?>
                <div class="col-md-3 col-sm-6">
                    <div class="category-card">
                        <div class="category-icon">
                            <?php
                            $icon = 'fas fa-tshirt';
                            switch ($category['name']) {
                                case 'Áo': $icon = 'fas fa-tshirt'; break;
                                case 'Quần': $icon = 'fas fa-socks'; break;
                                case 'Giày': $icon = 'fas fa-shoe-prints'; break;
                                case 'Phụ kiện': $icon = 'fas fa-gem'; break;
                            }
                            ?>
                            <i class="<?= $icon ?>"></i>
                        </div>
                        <h4><?= $category['name'] ?></h4>
                        <a href="<?= BASE_URL ?>products?category=<?= $category['id'] ?>" class="btn btn-outline-dark">
                            Xem sản phẩm
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="product-section">
        <div class="container">
            <h2 class="text-center mb-5">Sản Phẩm Nổi Bật</h2>
            <div class="row">
                <?php foreach ($featuredProducts as $product): ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product-card">
                        <div class="product-image" style="background-image: url('<?= BASE_URL . $product['image'] ?>')">
                            <div class="product-overlay">
                                <div class="btn-group">
                                    <a href="<?= BASE_URL ?>products/detail/<?= $product['slug'] ?>" class="btn btn-light btn-sm">
                                        <i class="fas fa-eye"></i> Xem
                                    </a>
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fas fa-shopping-cart"></i> Mua
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="product-info">
                            <h5 class="product-title"><?= $product['name'] ?></h5>
                            <p class="text-muted mb-2"><?= $product['category_name'] ?></p>
                            <div class="product-price"><?= number_format($product['price']) ?> VNĐ</div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center mt-4">
                <a href="<?= BASE_URL ?>products" class="btn btn-primary btn-lg">
                    Xem tất cả sản phẩm
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fas fa-tshirt me-2"></i>Fashion Store</h5>
                    <p>Chuyên cung cấp thời trang nam chất lượng cao với phong cách hiện đại và giá cả hợp lý.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-2">
                    <h5>Danh mục</h5>
                    <ul class="list-unstyled">
                        <?php foreach ($categories as $category): ?>
                        <li><a href="<?= BASE_URL ?>products?category=<?= $category['id'] ?>"><?= $category['name'] ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Thông tin</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Về chúng tôi</a></li>
                        <li><a href="#">Chính sách bảo mật</a></li>
                        <li><a href="#">Điều khoản sử dụng</a></li>
                        <li><a href="#">Hướng dẫn mua hàng</a></li>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL ?>assets/js/custom.js"></script>
</body>
</html>