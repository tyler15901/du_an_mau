<?php require_once './views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4><i class="bi bi-cart"></i> Giỏ hàng</h4>
                </div>
                <div class="card-body">
                    <div class="text-center py-5">
                        <i class="bi bi-cart-x" style="font-size: 100px; color: #ccc;"></i>
                        <h5 class="mt-3">Giỏ hàng trống</h5>
                        <p>Bạn chưa có sản phẩm nào trong giỏ hàng.</p>
                        <a href="index.php?act=products" class="btn btn-primary">
                            <i class="bi bi-shop"></i> Mua sắm ngay
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-calculator"></i> Tổng quan</h5>
                </div>
                <div class="card-body">
                    <p><strong>Số sản phẩm:</strong> 0</p>
                    <p><strong>Tổng tiền:</strong> 0 ₫</p>
                    <hr>
                    <button class="btn btn-primary w-100" disabled>
                        <i class="bi bi-credit-card"></i> Thanh toán
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once './views/layouts/footer.php'; ?>
