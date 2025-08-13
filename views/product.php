<?php
// Kiểm tra session hoặc dữ liệu từ controller
$title = $title ?? "Danh sách sản phẩm thời trang nam";
$products = $products ?? []; // Danh sách sản phẩm từ model
$categories = $categories ?? []; // Danh mục từ model
$search = $_GET['search'] ?? '';
$selected_category = $_GET['category'] ?? '';
$selected_price = $_GET['price_range'] ?? 'all';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #000000;
            color: #FFFFFF;
        }
        .navbar {
            background-color: #333333;
        }
        .card {
            background-color: #1a1a1a;
            border: 1px solid #555555;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(255,255,255,0.1);
        }
        .sidebar {
            background-color: #222222;
            padding: 20px;
            border-radius: 10px;
        }
        .btn {
            background-color: #FFFFFF;
            color: #000000;
            border: none;
            transition: all 0.3s ease;
        }
        .btn:hover {
            background-color: #CCCCCC;
            transform: translateY(-2px);
        }
        .form-control {
            background-color: #222222;
            color: #FFFFFF;
            border-color: #555555;
        }
        .form-control:focus {
            background-color: #333333;
            color: #FFFFFF;
            border-color: #666666;
            box-shadow: 0 0 0 0.2rem rgba(255,255,255,0.25);
        }
        .form-select {
            background-color: #222222;
            color: #FFFFFF;
            border-color: #555555;
        }
        .form-select:focus {
            background-color: #333333;
            color: #FFFFFF;
            border-color: #666666;
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        .search-results {
            background-color: #222222;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .no-products {
            text-align: center;
            padding: 50px;
            color: #AAAAAA;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php include 'layouts/header.php'; ?>

    <!-- Product and Sidebar Section -->
    <div class="container mt-4">
        <div class="row">
            <!-- Sidebar (Bộ lọc) -->
            <div class="col-12 col-md-3">
                <div class="sidebar">
                    <h4><i class="bi bi-funnel"></i> Bộ lọc</h4>
                    
                    <!-- Search Form -->
                    <form method="GET" class="mb-4">
                        <input type="hidden" name="act" value="products">
                        <div class="mb-3">
                            <label class="form-label">Tìm kiếm</label>
                            <input type="text" class="form-control" name="search" 
                                   placeholder="Tên sản phẩm..." value="<?php echo htmlspecialchars($search); ?>">
                        </div>
                        
                        <!-- Category Filter -->
                        <div class="mb-3">
                            <label class="form-label">Danh mục</label>
                            <select class="form-select" name="category">
                                <option value="">Tất cả danh mục</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['id']; ?>" 
                                            <?php echo $selected_category == $category['id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <!-- Price Range Filter -->
                        <div class="mb-3">
                            <label class="form-label">Khoảng giá</label>
                            <select class="form-select" name="price_range">
                                <option value="all" <?php echo $selected_price == 'all' ? 'selected' : ''; ?>>Tất cả</option>
                                <option value="0-500000" <?php echo $selected_price == '0-500000' ? 'selected' : ''; ?>>Dưới 500.000 VNĐ</option>
                                <option value="500000-1000000" <?php echo $selected_price == '500000-1000000' ? 'selected' : ''; ?>>500.000 - 1.000.000 VNĐ</option>
                                <option value="1000000" <?php echo $selected_price == '1000000' ? 'selected' : ''; ?>>Trên 1.000.000 VNĐ</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn w-100">
                            <i class="bi bi-search"></i> Tìm kiếm
                        </button>
                    </form>
                    
                    <!-- Clear Filters -->
                    <?php if (!empty($search) || !empty($selected_category) || $selected_price !== 'all'): ?>
                        <a href="index.php?act=products" class="btn btn-outline-light w-100">
                            <i class="bi bi-x-circle"></i> Xóa bộ lọc
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Product Section -->
            <div class="col-12 col-md-9">
                <!-- Search Results Info -->
                <?php if (!empty($search) || !empty($selected_category) || $selected_price !== 'all'): ?>
                    <div class="search-results">
                        <h5><i class="bi bi-search"></i> Kết quả tìm kiếm</h5>
                        <p class="mb-0">
                            <?php if (!empty($search)): ?>
                                Từ khóa: <strong><?php echo htmlspecialchars($search); ?></strong>
                            <?php endif; ?>
                            <?php if (!empty($selected_category)): ?>
                                <?php 
                                $category_name = '';
                                foreach ($categories as $cat) {
                                    if ($cat['id'] == $selected_category) {
                                        $category_name = $cat['name'];
                                        break;
                                    }
                                }
                                ?>
                                | Danh mục: <strong><?php echo htmlspecialchars($category_name); ?></strong>
                            <?php endif; ?>
                            <?php if ($selected_price !== 'all'): ?>
                                | Giá: <strong>
                                <?php 
                                switch ($selected_price) {
                                    case '0-500000': echo 'Dưới 500.000 VNĐ'; break;
                                    case '500000-1000000': echo '500.000 - 1.000.000 VNĐ'; break;
                                    case '1000000': echo 'Trên 1.000.000 VNĐ'; break;
                                }
                                ?>
                                </strong>
                            <?php endif; ?>
                        </p>
                        <small>Tìm thấy <?php echo count($products); ?> sản phẩm</small>
                    </div>
                <?php endif; ?>

                <!-- Products Grid -->
                <?php if (!empty($products)): ?>
                    <div class="product-grid">
                        <?php foreach ($products as $product): ?>
                            <div class="card h-100">
                                <img src="https://via.placeholder.com/300x300" class="card-img-top" 
                                     alt="<?php echo htmlspecialchars($product['name']); ?>">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                    <p class="card-text text-muted"><?php echo htmlspecialchars($product['category_name']); ?></p>
                                    <p class="card-text fw-bold"><?php echo number_format($product['price'], 0, ',', '.') . ' VNĐ'; ?></p>
                                    <div class="mt-auto">
                                        <div class="d-flex gap-2">
                                            <a href="index.php?act=product-detail&id=<?php echo $product['id']; ?>" 
                                               class="btn flex-fill">
                                                <i class="bi bi-eye"></i> Xem chi tiết
                                            </a>
                                            <button class="btn btn-outline-light" title="Thêm vào giỏ hàng">
                                                <i class="bi bi-cart-plus"></i>
                                            </button>
                                            <button class="btn btn-outline-light" title="Thêm vào yêu thích">
                                                <i class="bi bi-heart"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="no-products">
                        <i class="bi bi-search" style="font-size: 3rem; color: #666;"></i>
                        <h4>Không tìm thấy sản phẩm</h4>
                        <p>Thử thay đổi từ khóa tìm kiếm hoặc bộ lọc</p>
                        <a href="index.php?act=products" class="btn">
                            <i class="bi bi-arrow-left"></i> Xem tất cả sản phẩm
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'layouts/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>