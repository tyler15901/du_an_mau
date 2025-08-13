<?php
$pageTitle = 'Quản lý sản phẩm';
$currentPage = 'products';
ob_start();
?>

<div class="page-header">
    <h1 class="page-title">Quản lý sản phẩm</h1>
    <p class="page-subtitle">Thêm, sửa, xóa sản phẩm</p>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-box me-2"></i>Danh sách sản phẩm</h5>
        <a href="<?= BASE_URL ?>admin/products/add" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Thêm sản phẩm
        </a>
    </div>
    <div class="card-body">
        <?php if (!empty($products)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Giá</th>
                        <th>Tồn kho</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $product['id'] ?></td>
                        <td>
                            <img src="<?= BASE_URL . $product['image'] ?>" alt="<?= $product['name'] ?>" 
                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                        </td>
                        <td>
                            <strong><?= $product['name'] ?></strong>
                            <br>
                            <small class="text-muted"><?= $product['slug'] ?></small>
                        </td>
                        <td>
                            <span class="badge bg-primary"><?= $product['category_name'] ?></span>
                        </td>
                        <td>
                            <strong><?= number_format($product['price']) ?> VNĐ</strong>
                        </td>
                        <td>
                            <span class="badge bg-<?= $product['stock'] > 0 ? 'success' : 'danger' ?>">
                                <?= $product['stock'] ?>
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="<?= BASE_URL ?>admin/products/edit/<?= $product['id'] ?>" 
                                   class="btn btn-outline-primary btn-sm" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= BASE_URL ?>products/detail/<?= $product['slug'] ?>" 
                                   class="btn btn-outline-info btn-sm" title="Xem" target="_blank">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger btn-sm" 
                                        onclick="confirmDelete(<?= $product['id'] ?>, '<?= $product['name'] ?>')" title="Xóa">
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
            <h4>Chưa có sản phẩm nào</h4>
            <p class="text-muted">Bắt đầu bằng cách thêm sản phẩm đầu tiên</p>
            <a href="<?= BASE_URL ?>admin/products/add" class="btn btn-primary btn-lg">
                <i class="fas fa-plus me-2"></i>Thêm sản phẩm
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
function confirmDelete(productId, productName) {
    if (confirm(`Bạn có chắc chắn muốn xóa sản phẩm "${productName}"?`)) {
        window.location.href = '<?= BASE_URL ?>admin/products/delete/' + productId;
    }
}
</script>

<?php
$content = ob_get_clean();
include 'admin/views/layout.php';
?>
