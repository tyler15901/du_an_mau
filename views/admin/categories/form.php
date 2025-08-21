<?php
$pageTitle = 'Thêm danh mục';
$currentPage = 'categories';
ob_start();
?>

<div class="page-header">
    <h1 class="page-title">Thêm danh mục mới</h1>
    <p class="page-subtitle">Điền thông tin danh mục</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Thông tin danh mục</h5>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Tên danh mục *</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?= BASE_URL ?>admin/categories" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Lưu danh mục
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'admin/views/layout.php';
?>


