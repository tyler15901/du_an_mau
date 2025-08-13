<?php
$pageTitle = 'Quản lý danh mục';
$currentPage = 'categories';
ob_start();
?>

<div class="page-header">
    <h1 class="page-title">Quản lý danh mục</h1>
    <p class="page-subtitle">Thêm, sửa, xóa danh mục sản phẩm</p>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-tags me-2"></i>Danh sách danh mục</h5>
        <a href="<?= BASE_URL ?>admin/categories/add" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Thêm danh mục
        </a>
    </div>
    <div class="card-body">
        <?php if (!empty($categories)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Slug</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= $category['id'] ?></td>
                        <td><strong><?= htmlspecialchars($category['name']) ?></strong></td>
                        <td><small class="text-muted"><?= htmlspecialchars($category['slug']) ?></small></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="<?= BASE_URL ?>admin/categories/edit/<?= $category['id'] ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDelete(<?= $category['id'] ?>, '<?= htmlspecialchars($category['name']) ?>')">
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
            <i class="fas fa-box-open" style="font-size: 4rem; color: #ccc; margin-bottom: 1rem;"></i>
            <h4>Chưa có danh mục nào</h4>
            <p class="text-muted">Bắt đầu bằng cách thêm danh mục đầu tiên</p>
            <a href="<?= BASE_URL ?>admin/categories/add" class="btn btn-primary btn-lg">
                <i class="fas fa-plus me-2"></i>Thêm danh mục
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
function confirmDelete(categoryId, categoryName) {
    if (confirm(`Bạn có chắc chắn muốn xóa danh mục "${categoryName}"?`)) {
        window.location.href = '<?= BASE_URL ?>admin/categories/delete/' + categoryId;
    }
}
</script>

<?php
$content = ob_get_clean();
include 'admin/views/layout.php';
?>


