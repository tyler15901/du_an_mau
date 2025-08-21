<?php
$pageTitle = 'Dashboard';
$currentPage = 'dashboard';
ob_start();
?>

<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <p class="page-subtitle">Tổng quan hệ thống</p>
</div>

<!-- Statistics Cards -->
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="stats-number"><?= $totalProducts ?></div>
            <div class="stats-label">Sản phẩm</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="stats-number"><?= $totalCategories ?></div>
            <div class="stats-label">Danh mục</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="stats-number"><?= $totalUsers ?></div>
            <div class="stats-label">Người dùng</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="stats-number"><?= $totalReviews ?></div>
            <div class="stats-label">Bình luận</div>
        </div>
    </div>
</div>

<!-- Recent Products -->
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-box me-2"></i>Sản phẩm mới nhất</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($latestProducts)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Danh mục</th>
                                <th>Giá</th>
                                <th>Tồn kho</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($latestProducts as $product): ?>
                            <tr>
                                <td>
                                    <img src="<?= BASE_URL . $product['image'] ?>" alt="<?= $product['name'] ?>" 
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                </td>
                                <td>
                                    <strong><?= $product['name'] ?></strong>
                                </td>
                                <td><?= $product['category_name'] ?></td>
                                <td><?= number_format($product['price']) ?> VNĐ</td>
                                <td>
                                    <span class="badge bg-<?= $product['stock'] > 0 ? 'success' : 'danger' ?>">
                                        <?= $product['stock'] ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <a href="<?= BASE_URL ?>admin/products" class="btn btn-primary">
                        <i class="fas fa-eye me-2"></i>Xem tất cả sản phẩm
                    </a>
                </div>
                <?php else: ?>
                <div class="text-center py-4">
                    <i class="fas fa-box-open" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i>
                    <p class="text-muted">Chưa có sản phẩm nào</p>
                    <a href="<?= BASE_URL ?>admin/products/add" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Thêm sản phẩm đầu tiên
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-users me-2"></i>Người dùng mới nhất</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($latestUsers)): ?>
                <div class="list-group list-group-flush">
                    <?php foreach ($latestUsers as $user): ?>
                    <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                        <div>
                            <h6 class="mb-1"><?= $user['ho_ten'] ?></h6>
                            <small class="text-muted"><?= $user['email'] ?></small>
                        </div>
                        <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : 'primary' ?> rounded-pill">
                            <?= $user['role'] === 'admin' ? 'Admin' : 'User' ?>
                        </span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="text-center mt-3">
                    <a href="<?= BASE_URL ?>admin/users" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye me-2"></i>Xem tất cả người dùng
                    </a>
                </div>
                <?php else: ?>
                <div class="text-center py-4">
                    <i class="fas fa-user-plus" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i>
                    <p class="text-muted">Chưa có người dùng nào</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Thao tác nhanh</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?= BASE_URL ?>admin/products/add" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Thêm sản phẩm
                    </a>
                    <a href="<?= BASE_URL ?>admin/categories/add" class="btn btn-outline-primary">
                        <i class="fas fa-tag me-2"></i>Thêm danh mục
                    </a>
                    <a href="<?= BASE_URL ?>admin/reviews" class="btn btn-outline-primary">
                        <i class="fas fa-comments me-2"></i>Xem bình luận
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'admin/views/layout.php';
?>
