<?php
// Kiểm tra session hoặc dữ liệu từ controller
$title = $title ?? "Chi tiết sản phẩm";
$product = $product ?? []; // Thông tin sản phẩm từ model
$relatedProducts = $relatedProducts ?? []; // Sản phẩm liên quan
$comments = $comments ?? []; // Bình luận từ model
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
        /* Tùy chỉnh phong cách đen trắng */
        body {
            background-color: #000000; /* Nền đen */
            color: #FFFFFF; /* Chữ trắng */
        }
        .navbar {
            background-color: #333333; /* Navbar tối hơn */
        }
        .card {
            background-color: #1a1a1a; /* Card sản phẩm màu xám đậm */
            border: 1px solid #555555; /* Viền xám */
        }
        .product-info {
            background-color: #222222; /* Nền thông tin sản phẩm */
            padding: 15px;
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
    <!-- Header -->
    <?php include 'layouts/header.php'; ?>

    <!-- Product Section -->
    <div class="container mt-4">
        <div class="row">
            <!-- Hình ảnh sản phẩm (Bên trái) -->
            <div class="col-12 col-md-6">
                <img src="https://via.placeholder.com/400x400" class="img-fluid" alt="<?php echo $product['name'] ?? 'Sản phẩm'; ?>">
            </div>

            <!-- Thông tin sản phẩm (Bên phải) -->
            <div class="col-12 col-md-6">
                <div class="product-info">
                    <h2><?php echo $product['name'] ?? 'Tên sản phẩm'; ?></h2>
                    <p><strong>Giá:</strong> <?php echo number_format($product['price'] ?? 500000, 0, ',', '.') . ' VNĐ'; ?></p>
                    <p><strong>Tình trạng:</strong> <?php echo $product['status'] ?? 'Còn hàng'; ?></p>
                    <p><strong>Kích thước:</strong> 
                        <?php echo $product['size'] ?? 'S, M, L'; ?>
                    </p>
                    <p><strong>Màu sắc:</strong> 
                        <?php echo $product['color'] ?? 'Đen, Trắng'; ?>
                    </p>
                    <p><strong>Số lượng:</strong>
                        <input type="number" class="form-control" style="background-color: #1a1a1a; color: #FFFFFF;" value="1" min="1">
                    </p>
                    <div class="mt-3">
                        <a href="#" class="btn me-2">Mua ngay</a>
                        <a href="#" class="btn">Thêm vào giỏ hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mô tả sản phẩm và Comment -->
    <div class="container mt-4">
        <h2>Mô tả sản phẩm</h2>
        <p><?php echo $product['description'] ?? 'Đây là mô tả chi tiết về sản phẩm thời trang nam, chất liệu cao cấp, phù hợp với mọi dịp.'; ?></p>

        <h2 class="mt-4">Bình luận</h2>
        <?php foreach ($comments as $comment): ?>
            <div class="card mb-2" style="background-color: #222222;">
                <div class="card-body">
                    <p><strong><?php echo $comment['user'] ?? 'Khách'; ?>:</strong> <?php echo $comment['content'] ?? 'Bình luận mẫu'; ?></p>
                    <small><?php echo $comment['date'] ?? '07/08/2025'; ?></small>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Product Section (Sản phẩm liên quan) -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12 text-start">
                <h2>Sản phẩm liên quan</h2>
            </div>
            <div class="col-12 text-end">
                <a href="index.php?act=products" class="btn">Go to Shop</a>
            </div>
        </div>
        <div class="row">
            <?php foreach ($relatedProducts as $relatedProduct): ?>
                <div class="col-12 col-md-3 mb-3">
                    <div class="card h-100">
                        <img src="https://via.placeholder.com/200x200" class="card-img-top" alt="<?php echo $relatedProduct['name'] ?? 'Sản phẩm'; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $relatedProduct['name'] ?? 'Sản phẩm'; ?></h5>
                            <p class="card-text"><?php echo number_format($relatedProduct['price'] ?? 500000, 0, ',', '.') . ' VNĐ'; ?></p>
                            <a href="index.php?act=product-detail&id=<?php echo $relatedProduct['id'] ?? 1; ?>" class="btn">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'layouts/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>