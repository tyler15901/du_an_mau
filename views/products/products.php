<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm - Fashion Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>assets/css/base.css?v=1.0.1" rel="stylesheet">
    <link href="<?= BASE_URL ?>assets/css/public.css?v=1.0.1" rel="stylesheet">
</head>
<body class="products-page">
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
                        <a class="nav-link active" href="<?= BASE_URL ?>products">Tất cả sản phẩm</a>
                    </li>
                </ul>
                
                <!-- Search Box -->
                <form class="d-flex search-box me-3" action="<?= BASE_URL ?>products" method="GET">
                    <input class="form-control me-2" type="search" name="search" placeholder="Tìm kiếm sản phẩm..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
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

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Sản Phẩm</h1>
            <p>Khám phá bộ sưu tập thời trang nam đa dạng</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Filter Sidebar -->
                <div class="col-lg-3">
                    <div class="filter-sidebar">
                        <h5 class="filter-title">Bộ lọc</h5>
                        
                        <!-- Category Filter -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Danh mục</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" id="all" value="" <?= !isset($_GET['category']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="all">Tất cả</label>
                            </div>
                            <?php foreach ($categories as $category): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" id="cat_<?= $category['id'] ?>" value="<?= $category['id'] ?>" <?= (isset($_GET['category']) && $_GET['category'] == $category['id']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="cat_<?= $category['id'] ?>"><?= $category['name'] ?></label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Price Filter -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Khoảng giá</label>
                            <form action="<?= BASE_URL ?>products" method="GET">
                                <?php if (isset($_GET['search'])): ?>
                                <input type="hidden" name="search" value="<?= htmlspecialchars($_GET['search']) ?>">
                                <?php endif; ?>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="number" class="form-control" name="min_price" placeholder="Từ" value="<?= isset($_GET['min_price']) ? $_GET['min_price'] : '' ?>">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" class="form-control" name="max_price" placeholder="Đến" value="<?= isset($_GET['max_price']) ? $_GET['max_price'] : '' ?>">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm w-100 mt-2">Lọc</button>
                            </form>
                        </div>
                        
                        <!-- Clear Filters -->
                        <a href="<?= BASE_URL ?>products" class="btn btn-outline-primary w-100">Xóa bộ lọc</a>
                    </div>
                </div>
                
                <!-- Products Grid -->
                <div class="col-lg-9">
                    <!-- Sort Controls -->
                    <div class="sort-controls">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <span class="fw-bold">Hiển thị <?= count($products) ?> sản phẩm</span>
                            </div>
                            <div class="col-md-6">
                                <form action="<?= BASE_URL ?>products" method="GET" class="d-flex">
                                    <?php if (isset($_GET['category'])): ?>
                                    <input type="hidden" name="category" value="<?= $_GET['category'] ?>">
                                    <?php endif; ?>
                                    <?php if (isset($_GET['search'])): ?>
                                    <input type="hidden" name="search" value="<?= htmlspecialchars($_GET['search']) ?>">
                                    <?php endif; ?>
                                    <?php if (isset($_GET['min_price'])): ?>
                                    <input type="hidden" name="min_price" value="<?= $_GET['min_price'] ?>">
                                    <?php endif; ?>
                                    <?php if (isset($_GET['max_price'])): ?>
                                    <input type="hidden" name="max_price" value="<?= $_GET['max_price'] ?>">
                                    <?php endif; ?>
                                    <label class="form-label me-2">Sắp xếp:</label>
                                    <select name="sort" class="form-select" onchange="this.form.submit()">
                                        <option value="newest" <?= (isset($_GET['sort']) && $_GET['sort'] === 'newest') ? 'selected' : '' ?>>Mới nhất</option>
                                        <option value="price_asc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'price_asc') ? 'selected' : '' ?>>Giá tăng dần</option>
                                        <option value="price_desc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'price_desc') ? 'selected' : '' ?>>Giá giảm dần</option>
                                        <option value="name_asc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'name_asc') ? 'selected' : '' ?>>Tên A-Z</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Products -->
                    <?php if (!empty($products)): ?>
                    <div class="row">
                        <?php foreach ($products as $product): ?>
                        <div class="col-lg-4 col-md-6 col-sm-6">
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
                    <?php else: ?>
                    <div class="no-products">
                        <i class="fas fa-search"></i>
                        <h4>Không tìm thấy sản phẩm</h4>
                        <p>Hãy thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
                        <a href="<?= BASE_URL ?>products" class="btn btn-primary">Xem tất cả sản phẩm</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL ?>assets/js/custom.js"></script>
</body>
</html>
