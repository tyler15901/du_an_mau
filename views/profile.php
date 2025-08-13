<?php require_once './views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4><i class="bi bi-person"></i> Hồ sơ cá nhân</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($user) && $user): ?>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Họ tên:</strong> <?php echo escapeHtml($user['ho_ten']); ?></p>
                                <p><strong>Email:</strong> <?php echo escapeHtml($user['email']); ?></p>
                                <p><strong>Giới tính:</strong> <?php echo escapeHtml($user['gioi_tinh']); ?></p>
                                <p><strong>Ngày sinh:</strong> <?php echo date('d/m/Y', strtotime($user['ngay_sinh'])); ?></p>
                                <p><strong>Ngày tham gia:</strong> <?php echo date('d/m/Y', strtotime($user['created_at'])); ?></p>
                            </div>
                            <div class="col-md-6">
                                <div class="text-center">
                                    <i class="bi bi-person-circle" style="font-size: 100px; color: #ccc;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="index.php?act=edit-profile" class="btn btn-primary">
                                <i class="bi bi-pencil"></i> Chỉnh sửa hồ sơ
                            </a>
                            <a href="index.php?act=change-password" class="btn btn-secondary">
                                <i class="bi bi-key"></i> Đổi mật khẩu
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger">
                            Không tìm thấy thông tin người dùng!
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once './views/layouts/footer.php'; ?>
