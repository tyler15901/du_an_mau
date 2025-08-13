<?php
$pageTitle = 'Sửa sản phẩm';
$currentPage = 'products';
ob_start();
?>

<div class="page-header">
    <h1 class="page-title">Sửa sản phẩm</h1>
    <p class="page-subtitle">Cập nhật thông tin sản phẩm</p>
    <small class="text-muted">ID: <?= htmlspecialchars($product['id']) ?></small>
    <br>
    <small class="text-muted">Slug: <?= htmlspecialchars($product['slug']) ?></small>
    <br>
    <small class="text-muted">Hiện ảnh: <?= htmlspecialchars($product['image']) ?></small>
    <br>
    <small class="text-muted">Lưu ý: nếu không chọn ảnh mới, ảnh cũ sẽ được giữ lại</small>
    <br>
    <small class="text-muted">Các trường bắt buộc được đánh dấu *</small>
    <br>
    <small class="text-muted">Giá trị sẽ được validate phía server</small>
    <br>
    <small class="text-muted">Danh mục được chọn sẵn theo sản phẩm</small>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Thông tin sản phẩm</h5>
    </div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên sản phẩm *</label>
                        <input type="text" class="form-control" id="name" name="name" required 
                               value="<?= htmlspecialchars($product['name']) ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Danh mục *</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="">Chọn danh mục</option>
                                    <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" 
                                            <?= ($product['category_id'] == $category['id']) ? 'selected' : '' ?>>
                                        <?= $category['name'] ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Giá (VNĐ) *</label>
                                <input type="number" class="form-control" id="price" name="price" required min="0"
                                       value="<?= htmlspecialchars($product['price']) ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stock" class="form-label">Số lượng tồn kho *</label>
                                <input type="number" class="form-control" id="stock" name="stock" required min="0"
                                       value="<?= htmlspecialchars($product['stock']) ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image" class="form-label">Ảnh mới</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <div class="form-text">Bỏ trống nếu giữ ảnh cũ</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả sản phẩm</label>
                        <textarea class="form-control" id="description" name="description" rows="5"
                                  placeholder="Mô tả chi tiết về sản phẩm..."><?= htmlspecialchars($product['description']) ?></textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-image me-2"></i>Ảnh hiện tại</h6>
                        </div>
                        <div class="card-body text-center">
                            <?php if (!empty($product['image'])): ?>
                                <img src="<?= BASE_URL . $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>" 
                                     style="max-width: 100%; max-height: 200px; border-radius: 8px;">
                            <?php else: ?>
                                <div class="text-muted">
                                    <i class="fas fa-image" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                                    <p>Chưa có ảnh</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-between">
                <a href="<?= BASE_URL ?>admin/products" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Cập nhật sản phẩm
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'admin/views/layout.php';
?>


