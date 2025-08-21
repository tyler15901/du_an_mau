    </main>
    <footer class="site-footer">
        <div class="container footer-grid">
            <div>
                <div class="logo">FPOLYSHOP</div>
                <p>Cửa hàng thời trang nam tối giản. Chất liệu tốt, phom dáng đẹp, giá hợp lý.</p>
                <form class="newsletter-form" onsubmit="return false;">
                    <input type="email" placeholder="Nhập email để nhận ưu đãi">
                    <button type="submit" class="btn btn-white">Đăng ký</button>
                </form>
                <small>© <?= date('Y') ?> FPOLYSHOP. All rights reserved.</small>
            </div>
            <div>
                <h4>Danh mục</h4>
                <ul>
                    <li><a href="<?= BASE_URL ?>?act=san-pham&tag=ao-phong">Áo phông</a></li>
                    <li><a href="<?= BASE_URL ?>?act=san-pham&tag=ao-so-mi">Áo sơ mi</a></li>
                    <li><a href="<?= BASE_URL ?>?act=san-pham&tag=quan-dai">Quần dài</a></li>
                    <li><a href="<?= BASE_URL ?>?act=san-pham&tag=quan-ngan">Quần ngắn</a></li>
                    <li><a href="<?= BASE_URL ?>?act=san-pham&tag=ao-khoac">Áo khoác</a></li>
                    <li><a href="<?= BASE_URL ?>?act=san-pham&tag=phu-kien">Phụ kiện</a></li>
                </ul>
            </div>
            <div>
                <h4>Hỗ trợ</h4>
                <ul>
                    <li><a href="<?= BASE_URL ?>?act=lien-he">Liên hệ</a></li>
                    <li><a href="#">Hướng dẫn mua hàng</a></li>
                    <li><a href="#">Chính sách đổi trả</a></li>
                    <li><a href="#">Vận chuyển & thanh toán</a></li>
                </ul>
            </div>
            <div>
                <h4>Kết nối</h4>
                <ul>
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">YouTube</a></li>
                </ul>
            </div>
        </div>
        <div class="container footer-legal">
            <a href="#">Bảo mật</a>
            <a href="#">Điều khoản</a>
            <a href="#">Cookie</a>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="<?= BASE_URL ?>assets/js/slider.js"></script>
        <script src="<?= BASE_URL ?>assets/js/auth-validate.js"></script>
    </footer>
</body>
</html>

