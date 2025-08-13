<?php
$pageTitle = 'Quản lý người dùng';
$currentPage = 'users';
ob_start();
?>

<div class="page-header">
    <h1 class="page-title">Quản lý người dùng</h1>
    <p class="page-subtitle">Xem danh sách và xóa người dùng</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-users me-2"></i>Danh sách người dùng</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($users)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= htmlspecialchars($user['ho_ten']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <span class="badge bg-<?= $user['role'] === 'admin' ? 'dark' : 'secondary' ?>"><?= htmlspecialchars($user['role']) ?></span>
                        </td>
                        <td><small class="text-muted"><?= htmlspecialchars($user['created_at']) ?></small></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="<?= BASE_URL ?>admin/users/detail/<?= $user['id'] ?>" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDelete(<?= $user['id'] ?>, '<?= htmlspecialchars($user['email']) ?>')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-users" style="font-size: 4rem; color: #ccc; margin-bottom: 1rem;"></i>
            <h4>Chưa có người dùng nào</h4>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
function confirmDelete(userId, userEmail) {
    if (confirm(`Bạn có chắc chắn muốn xóa người dùng "${userEmail}"?`)) {
        window.location.href = '<?= BASE_URL ?>admin/users/delete/' + userId;
    }
}
</script>

<?php
$content = ob_get_clean();
include 'admin/views/layout.php';
?>


