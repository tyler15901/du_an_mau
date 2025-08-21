<?php
$pageTitle = 'Thêm sản phẩm';
$currentPage = 'products';
ob_start();
?>

<div class="page-header">
    <h1 class="page-title">Thêm sản phẩm mới</h1>
    <p class="page-subtitle">Điền thông tin sản phẩm</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Thông tin sản phẩm</h5>
    </div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên sản phẩm *</label>
                        <input type="text" class="form-control" id="name" name="name" required 
                               value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Danh mục *</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="">Chọn danh mục</option>
                                    <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" 
                                            <?= (isset($_POST['category_id']) && $_POST['category_id'] == $category['id']) ? 'selected' : '' ?>>
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
                                       value="<?= isset($_POST['price']) ? $_POST['price'] : '' ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stock" class="form-label">Số lượng tồn kho *</label>
                                <input type="number" class="form-control" id="stock" name="stock" required min="0"
                                       value="<?= isset($_POST['stock']) ? $_POST['stock'] : '0' ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image" class="form-label">Hình ảnh *</label>
                                <input type="file" class="form-control" id="image" name="image" required 
                                       accept="image/*">
                                <div class="form-text">Chọn file ảnh (JPG, PNG, GIF)</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả sản phẩm</label>
                        <textarea class="form-control" id="description" name="description" rows="5"
                                  placeholder="Mô tả chi tiết về sản phẩm..."><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-image me-2"></i>Xem trước ảnh</h6>
                        </div>
                        <div class="card-body text-center">
                            <div id="imagePreview" class="mb-3" style="display: none;">
                                <img id="previewImg" src="" alt="Preview" 
                                     style="max-width: 100%; max-height: 200px; border-radius: 8px;">
                            </div>
                            <div id="noImage" class="text-muted">
                                <i class="fas fa-image" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                                <p>Chưa có ảnh</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Thông tin</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li><i class="fas fa-check text-success me-2"></i>Slug sẽ được tạo tự động</li>
                                <li><i class="fas fa-check text-success me-2"></i>Ảnh sẽ được resize tự động</li>
                                <li><i class="fas fa-check text-success me-2"></i>Hỗ trợ SEO friendly URL</li>
                            </ul>
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
                    <i class="fas fa-save me-2"></i>Lưu sản phẩm
                </button>
            </div>
        </form>
    </div>
</div>



<?php
$content = ob_get_clean();
include 'admin/views/layout.php';
?>
