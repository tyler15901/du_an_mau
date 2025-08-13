<?php
$pageTitle = 'Chi tiết người dùng';
$currentPage = 'users';
ob_start();
?>

<div class="page-header">
    <h1 class="page-title">Chi tiết người dùng</h1>
    <p class="page-subtitle">Thông tin tài khoản</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Thông tin</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($user)): ?>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3"><strong>Họ tên:</strong> <?= htmlspecialchars($user['ho_ten']) ?></div>
                <div class="mb-3"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></div>
                <div class="mb-3"><strong>Giới tính:</strong> <?= htmlspecialchars($user['gioi_tinh']) ?></div>
            </div>
            <div class="col-md-6">
                <div class="mb-3"><strong>Ngày sinh:</strong> <?= htmlspecialchars($user['ngay_sinh']) ?></div>
                <div class="mb-3"><strong>Vai trò:</strong> <span class="badge bg-<?= $user['role'] === 'admin' ? 'dark' : 'secondary' ?>"><?= htmlspecialchars($user['role']) ?></span></div>
                <div class="mb-3"><strong>Ngày tạo:</strong> <small class="text-muted"><?= htmlspecialchars($user['created_at']) ?></small></div>
            </div>
        </div>
        <?php else: ?>
        <div class="alert alert-warning">Không tìm thấy thông tin người dùng.</div>
        <?php endif; ?>

        <div class="mt-4 d-flex justify-content-between">
            <a href="<?= BASE_URL ?>admin/users" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Quay lại
            </a>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'admin/views/layout.php';
?>


