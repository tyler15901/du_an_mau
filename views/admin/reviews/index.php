<?php
$pageTitle = 'Quản lý bình luận';
$currentPage = 'reviews';
ob_start();
?>

<div class="page-header">
    <h1 class="page-title">Quản lý bình luận</h1>
    <p class="page-subtitle">Xem và xóa bình luận của khách hàng</p>
    <small class="text-muted">Chỉ hiển thị, không sửa</small>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-comments me-2"></i>Danh sách bình luận</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($reviews)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sản phẩm</th>
                        <th>Người dùng</th>
                        
                        <th>Bình luận</th>
                        <th>Thời gian</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reviews as $review): ?>
                    <tr>
                        <td><?= $review['id'] ?></td>
                        <td>#<?= $review['product_id'] ?></td>
                        <td>#<?= $review['user_id'] ?></td>
                        
                        <td style="max-width: 400px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <?= htmlspecialchars($review['comment']) ?>
                        </td>
                        <td><small class="text-muted"><?= htmlspecialchars($review['created_at']) ?></small></td>
                        <td>
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDelete(<?= $review['id'] ?>)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-comments" style="font-size: 4rem; color: #ccc; margin-bottom: 1rem;"></i>
            <h4>Chưa có bình luận nào</h4>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php
$content = ob_get_clean();
include 'admin/views/layout.php';
?>


