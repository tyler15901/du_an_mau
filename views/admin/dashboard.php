<?php 
$__admin_view = __FILE__;
ob_start();
?>
<div class="card" style="padding:16px">
  <h1 class="h3 mb-3">Tổng quan</h1>
  <div class="grid" style="grid-template-columns:repeat(4,1fr);gap:16px">
    <div class="card" style="padding:16px"><div class="muted">Sản phẩm</div><div class="h3"><?= (int)$counts['products'] ?></div></div>
    <div class="card" style="padding:16px"><div class="muted">Danh mục</div><div class="h3"><?= (int)$counts['categories'] ?></div></div>
    <div class="card" style="padding:16px"><div class="muted">Người dùng</div><div class="h3"><?= (int)$counts['users'] ?></div></div>
    <div class="card" style="padding:16px"><div class="muted">Bình luận</div><div class="h3"><?= (int)$counts['reviews'] ?></div></div>
  </div>
</div>
<?php $__content = ob_get_clean(); include __DIR__ . '/layout.php'; ?>


