<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $product['name'] ?> - Fashion Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>assets/css/base.css?v=1.0.1" rel="stylesheet">
    <link href="<?= BASE_URL ?>assets/css/public.css?v=1.0.1" rel="stylesheet">
</head>
<body class="product-detail-page">
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

    <!-- Product Detail -->
    <section class="product-detail">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>products">Sản phẩm</a></li>
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>products?category=<?= $product['category_id'] ?>"><?= $product['category_name'] ?></a></li>
                    <li class="breadcrumb-item active"><?= $product['name'] ?></li>
                </ol>
            </nav>
            
            <div class="row">
                <div class="col-lg-6">
                    <div class="product-image">
                        <img src="<?= BASE_URL . $product['image'] ?>" alt="<?= $product['name'] ?>">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product-info">
                        <h1 class="product-title"><?= $product['name'] ?></h1>
                        <div class="product-category">
                            <i class="fas fa-tag me-2"></i><?= $product['category_name'] ?>
                        </div>
                        <div class="product-price"><?= number_format($product['price']) ?> VNĐ</div>
                        
                        <div class="product-stock">
                            <span class="badge bg-<?= $product['stock'] > 0 ? 'success' : 'danger' ?> stock-badge">
                                <i class="fas fa-<?= $product['stock'] > 0 ? 'check' : 'times' ?> me-2"></i>
                                <?= $product['stock'] > 0 ? 'Còn hàng' : 'Hết hàng' ?> (<?= $product['stock'] ?>)
                            </span>
                        </div>
                        
                        <div class="product-description">
                            <?= nl2br(htmlspecialchars($product['description'])) ?>
                        </div>
                        
                        <?php if ($product['stock'] > 0): ?>
                        <div class="quantity-controls">
                            <button class="quantity-btn" onclick="changeQuantity(-1)">-</button>
                            <input type="number" class="quantity-input" id="quantity" value="1" min="1" max="<?= $product['stock'] ?>">
                            <button class="quantity-btn" onclick="changeQuantity(1)">+</button>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary btn-lg">
                                <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ hàng
                            </button>
                            <button class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-heart me-2"></i>Thêm vào yêu thích
                            </button>
                        </div>
                        <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>Sản phẩm hiện tại đã hết hàng
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Reviews Section -->
    <section class="reviews-section">
        <div class="container">
            <h2 class="text-center mb-5">Đánh giá và bình luận</h2>
            
            <!-- Average Rating -->
            <div class="average-rating">
                <div class="rating-number"><?= $averageRating ?>/5</div>
                <div class="rating-stars">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="<?= $i <= $averageRating ? 'fas' : 'far' ?> fa-star"></i>
                    <?php endfor; ?>
                </div>
                <p class="text-muted"><?= count($reviews) ?> đánh giá</p>
            </div>
            
            <!-- Add Review Form -->
            <?php if (isset($_SESSION['user_id'])): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-comment me-2"></i>Viết đánh giá</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= BASE_URL ?>products/review">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <div class="mb-3">
                            <label class="form-label">Đánh giá của bạn</label>
                            <div class="rating-input">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>" required>
                                <label for="star<?= $i ?>"><i class="far fa-star"></i></label>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">Bình luận</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" required 
                                      placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Gửi đánh giá
                        </button>
                    </form>
                </div>
            </div>
            <?php else: ?>
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle me-2"></i>
                <a href="<?= BASE_URL ?>login">Đăng nhập</a> để viết đánh giá
            </div>
            <?php endif; ?>
            
            <!-- Reviews List -->
            <?php if (!empty($reviews)): ?>
            <div class="row">
                <?php foreach ($reviews as $review): ?>
                <div class="col-md-6">
                    <div class="review-card">
                        <div class="review-header">
                            <div>
                                <div class="review-author"><?= $review['user_name'] ?></div>
                                <div class="review-date"><?= date('d/m/Y H:i', strtotime($review['created_at'])) ?></div>
                            </div>
                            <div class="review-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="<?= $i <= $review['rating'] ? 'fas' : 'far' ?> fa-star"></i>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <div class="review-content">
                            <?= nl2br(htmlspecialchars($review['comment'])) ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="text-center py-4">
                <i class="fas fa-comments" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i>
                <h4>Chưa có đánh giá nào</h4>
                <p class="text-muted">Hãy là người đầu tiên đánh giá sản phẩm này</p>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Related Products -->
    <?php if (!empty($relatedProducts)): ?>
    <section class="related-products">
        <div class="container">
            <h2 class="text-center mb-5">Sản phẩm liên quan</h2>
            <div class="row">
                <?php foreach ($relatedProducts as $relatedProduct): ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="related-product-card">
                        <div class="related-product-image" style="background-image: url('<?= BASE_URL . $relatedProduct['image'] ?>')"></div>
                        <div class="related-product-info">
                            <h5 class="related-product-title"><?= $relatedProduct['name'] ?></h5>
                            <div class="related-product-price"><?= number_format($relatedProduct['price']) ?> VNĐ</div>
                            <a href="<?= BASE_URL ?>products/detail/<?= $relatedProduct['slug'] ?>" class="btn btn-outline-primary btn-sm w-100 mt-2">
                                <i class="fas fa-eye me-2"></i>Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL ?>assets/js/custom.js"></script>
</body>
</html>
