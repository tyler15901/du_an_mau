<?php
// Kiểm tra session hoặc dữ liệu từ controller
$title = $title ?? "Chào mừng đến với cửa hàng thời trang nam";
$thoiTiet = $thoiTiet ?? "Hôm nay trời đẹp, phù hợp để mua sắm!";
$products = $products ?? []; // Danh sách sản phẩm từ model
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
        .slider, .circular-slider {
            background-color: #222222; /* Nền slider */
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

    <!-- Slider -->
    <div class="container mt-4 slider">
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://via.placeholder.com/1200x300" class="d-block w-100" alt="Slider 1">
                </div>
                <div class="carousel-item">
                    <img src="https://via.placeholder.com/1200x300" class="d-block w-100" alt="Slider 2">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div>
    </div>

    <!-- Product Section 1 -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12 text-start">
                <h2>Sản phẩm nổi bật</h2>
            </div>
            <div class="col-12 text-end">
                <a href="index.php?act=products" class="btn">Go to Shop</a>
            </div>
        </div>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-12 col-md-3 mb-3">
                    <div class="card h-100">
                        <img src="https://via.placeholder.com/200x200" class="card-img-top" alt="<?php echo $product['name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['name']; ?></h5>
                            <p class="card-text"><?php echo number_format($product['price'], 0, ',', '.') . ' VNĐ'; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Product Section 2 (Slider tròn - ví dụ đơn giản) -->
    <div class="container mt-4 circular-slider">
        <h2>Sản phẩm gợi ý</h2>
        <div class="d-flex justify-content-around">
            <?php for ($i = 0; $i < 4; $i++): ?>
                <div class="card" style="width: 18rem;">
                    <img src="https://via.placeholder.com/150x150" class="card-img-top" alt="Product <?php echo $i; ?>">
                    <div class="card-body">
                        <h5 class="card-title">Sản phẩm <?php echo $i; ?></h5>
                        <p class="card-text">Giá: 500.000 VNĐ</p>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>

    <!-- Banner CTA -->
    <div class="container mt-4 text-center">
        <img src="https://via.placeholder.com/1200x200" alt="Banner CTA" class="img-fluid">
        <a href="index.php?act=products" class="btn mt-2">Shop Now</a>
    </div>

    <!-- Tin tức -->
    <div class="container mt-4">
        <h2>Tin tức</h2>
        <p>Thông tin cập nhật về thời trang nam sẽ được đăng tải tại đây.</p>
    </div>

    <!-- Comment -->
    <div class="container mt-4">
        <h2>Đánh giá</h2>
        <p>Chỗ này sẽ hiển thị bình luận của khách hàng (chưa có dữ liệu).</p>
    </div>

    <!-- Footer -->
    <?php include 'layouts/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>