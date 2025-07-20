<?php require_once './views/header.php'; // Require partial header. ?>

<!-- Comment: Nội dung trang chủ: Banner carousel. -->
<section class="banner">
    <div id="bannerCarousel" class="carousel slide">
        <div class="carousel-inner">
            <?php foreach ($banners as $key => $banner): ?>
                <div class="carousel-item <?= $key == 0 ? 'active' : ''; ?>">
                    <img src="<?= BASE_URL . $banner['image']; ?>" class="d-block w-100" alt="<?= $banner['title']; ?>">
                    <div class="carousel-caption d-none d-md-block">
                        <h5><?= $banner['title']; ?></h5>
                        <p><?= $banner['desc']; ?></p>
                        <div data-end-date="<?= $banner['end_date']; ?>"></div> <!-- Countdown JS. -->
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
</section>

<!-- Comment: Danh mục sản phẩm carousel giống hình ảnh. -->
<section class="danh-muc container my-5">
    <h2>DANH MỤC SẢN PHẨM</h2>
    <div id="danhMucCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php $chunks = array_chunk($mainCategories, 4); // Chia 4 card/slide. ?>
            <?php foreach ($chunks as $key => $chunk): ?>
                <div class="carousel-item <?= $key == 0 ? 'active' : ''; ?>">
                    <div class="row">
                        <?php foreach ($chunk as $cat): ?>
                            <div class="col-md-3">
                                <img src="<?= BASE_URL . $cat['image']; ?>" class="img-fluid" alt="<?= $cat['name']; ?>">
                                <h4><?= $cat['name']; ?></h4>
                                <button class="btn-circle" onclick="location.href='<?= BASE_URL . 'category/' . $cat['slug']; ?>'">→</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#danhMucCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#danhMucCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
</section>

<!-- Comment: Sản phẩm khuyến mãi grid. -->
<section class="promotion container my-5">
    <h2>Sản Phẩm Khuyến Mãi</h2>
    <div class="row">
        <?php foreach ($promotionProducts as $product): ?>
            <?php $percent = round((($product['price'] - $product['promotion_price']) / $product['price']) * 100); ?>
            <div class="col-md-3">
                <div class="card">
                    <img src="<?= BASE_URL . $product['image']; ?>" class="card-img-top" alt="<?= $product['name']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $product['name']; ?></h5>
                        <p><del><?= number_format($product['price']); ?>đ</del> <strong class="text-danger"><?= number_format($product['promotion_price']); ?>đ</strong></p>
                        <span class="badge bg-danger"><?= $percent; ?>%</span>
                        <a href="#" class="btn btn-primary">Xem thêm</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Comment: Sản phẩm nổi bật grid (giả sử rating từ DB, dùng 4 sao mẫu). -->
<section class="featured container my-5">
    <h2>Sản Phẩm Nổi Bật</h2>
    <div class="row">
        <?php foreach ($featuredProducts as $product): ?>
            <div class="col-md-3">
                <div class="card">
                    <img src="<?= BASE_URL . $product['image']; ?>" class="card-img-top" alt="<?= $product['name']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $product['name']; ?></h5>
                        <p><?= number_format($product['price']); ?>đ</p>
                        <div class="rating">★★★★☆ (4.5)</div> <!-- Giả sử rating, tính từ DB. -->
                        <a href="#" class="btn btn-primary">Xem thêm</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Comment: Chính sách grid tĩnh hardcode (không DB). -->
<section class="policy container my-5">
    <div class="row text-center">
        <div class="col-md-3">
            <i class="bi bi-truck policy-icon"></i>
            <h4>Miễn phí vận chuyển</h4>
            <p>Cho đơn hàng từ 800.000đ</p>
        </div>
        <div class="col-md-3">
            <i class="bi bi-arrow-repeat policy-icon"></i>
            <h4>Đổi hàng dễ dàng</h4>
            <p>Trong 7 ngày bất kỳ lý do</p>
        </div>
        <div class="col-md-3">
            <i class="bi bi-headset policy-icon"></i>
            <h4>Hỗ trợ nhanh chóng</h4>
            <p>24/7 qua chat/email</p>
        </div>
        <div class="col-md-3">
            <i class="bi bi-credit-card policy-icon"></i>
            <h4>Thanh toán đa dạng</h4>
            <p>COD, Visa, chuyển khoản</p>
        </div>
    </div>
</section>

<!-- Comment: Footer đơn giản. -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h5>Giới thiệu</h5>
                <p>Thời trang nam cao cấp, chất lượng.</p>
            </div>
            <div class="col-md-3">
                <h5>Thông tin liên hệ</h5>
                <p>Email: info@thoitrangnam.com<br>Địa chỉ: TP.HCM</p>
            </div>
            <div class="col-md-3">
                <h5>Dịch vụ khách hàng</h5>
                <a href="#">Chính sách đổi trả</a><br><a href="#">FAQ</a>
            </div>
            <div class="col-md-3">
                <h5>Quy định hoạt động</h5>
                <a href="#">Điều khoản sử dụng</a><br><a href="#">Bảo mật</a>
            </div>
        </div>
        <div class="text-center mt-3">
            <a href="#"><i class="bi bi-facebook"></i></a> <a href="#"><i class="bi bi-instagram"></i></a> <a href="#"><i class="bi bi-twitter"></i></a>
            <p>© <span id="copyright-year"></span> Thời Trang Nam. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<!-- Comment: CDN Bootstrap JS cho carousel/modal. -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Comment: Dynamic copyright year.
    document.getElementById('copyright-year').innerHTML = new Date().getFullYear();
</script>

</body>
</html>