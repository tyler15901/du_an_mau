<?php 
$__admin_view = __FILE__;
ob_start();
?>
<div class="card" style="padding:16px">
  <h1 class="h3 mb-3"><?= $isEdit ? 'Sửa sản phẩm' : 'Thêm sản phẩm' ?></h1>
  <form method="post" enctype="multipart/form-data" action="<?= BASE_URL ?>?act=<?= $isEdit ? 'admin-product-update' : 'admin-product-store' ?>">
    <?php if ($isEdit): ?><input type="hidden" name="id" value="<?= (int)$product['id'] ?>"><?php endif; ?>
    <div class="mb-3"><label class="form-label">Tên</label><input class="form-control" name="name" value="<?= htmlspecialchars($product['name'] ?? '') ?>"></div>
    <div class="mb-3"><label class="form-label">Giá</label><input type="number" class="form-control" name="price" value="<?= (int)($product['price'] ?? 0) ?>"></div>
    <div class="mb-3"><label class="form-label">Danh mục</label>
      <select class="form-select" name="category_id">
        <?php foreach($categories as $c): ?>
          <option value="<?= (int)$c['id'] ?>" <?= isset($product['category_id']) && (int)$product['category_id']===(int)$c['id'] ? 'selected' : '' ?>><?= htmlspecialchars($c['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3"><label class="form-label">Số lượng (tồn kho)</label><input type="number" class="form-control" name="stock" value="<?= (int)($product['stock'] ?? 0) ?>"></div>
    <div class="mb-3"><label class="form-label">Giảm giá (%)</label><input type="number" class="form-control" name="discount_percent" value="<?= (int)($product['discount_percent'] ?? 0) ?>"></div>
    <div class="mb-3"><label class="form-label">Ngày tạo</label><input type="datetime-local" class="form-control" name="created_at" value="<?= isset($product['created_at']) ? str_replace(' ', 'T', substr($product['created_at'],0,16)) : '' ?>" placeholder="Trống = tự động"></div>
    <div class="mb-3"><label class="form-label">Mô tả</label><textarea class="form-control" rows="5" name="description"><?= htmlspecialchars($product['description'] ?? '') ?></textarea></div>
    <div class="mb-3"><label class="form-label">Ảnh</label>
      <?php if (!empty($product['image'])): ?><div class="mb-2"><img src="<?= BASE_URL . $product['image'] ?>" alt="" style="height:80px"><input type="hidden" name="image_existing" value="<?= htmlspecialchars($product['image']) ?>"></div><?php endif; ?>
      <input type="file" name="image" class="form-control">
    </div>
    <button class="btn btn-dark" type="submit">Lưu</button>
    <a class="btn btn-outline-secondary" href="<?= BASE_URL ?>?act=admin-products">Hủy</a>
  </form>
</div>
<?php $__content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>


