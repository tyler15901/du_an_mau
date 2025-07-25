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
                        <p><?= $banner['description']; ?></p>
                        <div data-end-date="<?= $banner['end_date']; ?>"></div>
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
            <?php 
                $percent = round((($product['price'] - $product['promotion_price']) / $product['price']) * 100); // Tính % giảm từ data Model.
                if ($percent > 0): // Chỉ hiển thị badge nếu có giảm giá.
            ?>
            <div class="col-md-3">
                <div class="card">
                    <div class="position-relative">
                        <img src="<?= BASE_URL . $product['image']; ?>" class="card-img-top product-img" alt="<?= $product['name']; ?>">
                        <span class="badge bg-danger position-absolute top-0 start-0 m-2"><?= $percent; ?>%</span>
                        <div class="overlay d-flex justify-content-center align-items-center position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-none">
                            <a href="/product/<?= $product['id']; ?>" class="btn btn-light mx-1 rounded-circle" title="Xem chi tiết"><i class="bi bi-search"></i></a>
                            <a href="/checkout?product=<?= $product['id']; ?>" class="btn btn-light mx-1 rounded-circle" title="Mua ngay"><i class="bi bi-bag-check"></i></a>
                            <button class="btn btn-light mx-1 rounded-circle add-to-cart" data-product-id="<?= $product['id']; ?>" title="Thêm vào giỏ hàng"><i class="bi bi-cart-plus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $product['name']; ?></h5>
                        <p><del><?= number_format($product['price']); ?>đ</del> <strong class="text-danger"><?= number_format($product['promotion_price']); ?>đ</strong></p>
                    
                    </div>
                </div>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</section>

<!-- Comment: Sản phẩm nổi bật grid. -->
<section class="featured container my-5">
    <h2>Sản Phẩm Nổi Bật</h2>
    <div class="row">
        <?php foreach ($featuredProducts as $product): ?>
            <div class="col-md-3">
                <div class="card">
                    <div class="position-relative">
                        <img src="<?= BASE_URL . $product['image']; ?>" class="card-img-top product-img" alt="<?= $product['name']; ?>">
                        <div class="overlay d-flex justify-content-center align-items-center position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-none">
                            <a href="/product/<?= $product['id']; ?>" class="btn btn-light mx-1 rounded-circle" title="Xem chi tiết"><i class="bi bi-search"></i></a>
                            <a href="/checkout?product=<?= $product['id']; ?>" class="btn btn-light mx-1 rounded-circle" title="Mua ngay"><i class="bi bi-bag-check"></i></a>
                            <button class="btn btn-light mx-1 rounded-circle add-to-cart" data-product-id="<?= $product['id']; ?>" title="Thêm vào giỏ hàng"><i class="bi bi-cart-plus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $product['name']; ?></h5>
                        <p><?= number_format($product['price']); ?>đ</p>
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
<script src="<?= BASE_URL; ?>assets/js/custom.js"></script>
</body>
</html>