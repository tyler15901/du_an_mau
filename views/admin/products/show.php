<?php 
$__admin_view = __FILE__;
ob_start();
?>
<div class="card" style="padding:16px">
  <h1 class="h3 mb-3">Chi tiết sản phẩm</h1>
  <div class="row" style="display:grid;grid-template-columns:300px 1fr;gap:16px">
    <div>
      <?php if (!empty($product['image'])): ?>
        <img src="<?= BASE_URL . $product['image'] ?>" alt="" style="width:100%;height:auto">
      <?php endif; ?>
    </div>
    <div>
      <div class="grid" style="grid-template-columns:1fr 1fr;gap:12px">
        <div><strong>ID:</strong> <?= (int)$product['id'] ?></div>
        <div><strong>Danh mục:</strong> <?= htmlspecialchars($product['category_name'] ?? '') ?> (#<?= (int)$product['category_id'] ?>)</div>
        <div><strong>Tên:</strong> <?= htmlspecialchars($product['name']) ?></div>
        <div><strong>Slug:</strong> <?= htmlspecialchars($product['slug']) ?></div>
        <div><strong>Giá:</strong> <?= number_format($product['price']) ?>₫</div>
        <div><strong>Giảm giá:</strong> <?= (int)$product['discount_percent'] ?>%</div>
        <?php if(isset($product['stock'])): ?><div><strong>Tồn kho:</strong> <?= (int)$product['stock'] ?></div><?php endif; ?>
        <div><strong>Ngày tạo:</strong> <?= htmlspecialchars($product['created_at'] ?? '') ?></div>
      </div>
      <div class="mt-3"><strong>Mô tả:</strong><br><?= nl2br(htmlspecialchars($product['description'])) ?></div>
      <a class="btn btn-outline-secondary mt-3" href="<?= BASE_URL ?>?act=admin-products">Quay lại</a>
    </div>
  </div>
</div>
<?php $__content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>


