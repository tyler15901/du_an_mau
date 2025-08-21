<?php 
$__admin_view = __FILE__;
ob_start();
?>
<div class="card" style="padding:16px">
  <h1 class="h3 mb-3"><?= $isEdit ? 'Sửa danh mục' : 'Thêm danh mục' ?></h1>
  <form method="post" action="<?= BASE_URL ?>?act=<?= $isEdit ? 'admin-category-update' : 'admin-category-store' ?>">
    <?php if ($isEdit): ?><input type="hidden" name="id" value="<?= (int)$category['id'] ?>"><?php endif; ?>
    <div class="mb-3">
      <label class="form-label">Tên</label>
      <input class="form-control" name="name" value="<?= htmlspecialchars($category['name'] ?? '') ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Slug</label>
      <input class="form-control" name="slug" value="<?= htmlspecialchars($category['slug'] ?? '') ?>">
    </div>
    <button class="btn btn-dark" type="submit">Lưu</button>
    <a class="btn btn-outline-secondary" href="<?= BASE_URL ?>?act=admin-categories">Hủy</a>
  </form>
</div>
<?php $__content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>


