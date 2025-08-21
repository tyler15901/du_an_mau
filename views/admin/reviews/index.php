<?php 
$__admin_view = __FILE__;
ob_start();
?>
<div class="card" style="padding:12px">
  <h1 class="h3 mb-3">Bình luận</h1>
  <table class="table">
    <thead><tr><th>ID</th><th>Sản phẩm</th><th>Người dùng</th><th>Nội dung</th><th>Thời gian</th></tr></thead>
    <tbody>
      <?php foreach($reviews as $r): ?>
      <tr>
        <td><?= (int)$r['id'] ?></td>
        <td><?= htmlspecialchars($r['product_name']) ?></td>
        <td><?= htmlspecialchars($r['user_name']) ?></td>
        <td><?= htmlspecialchars($r['comment']) ?></td>
        <td><?= htmlspecialchars($r['created_at']) ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<nav class="mt-3">
  <ul class="pagination">
    <?php for($i=1;$i<=$pages;$i++): ?>
      <li class="page-item <?= $i===$page?'active':'' ?>">
        <a class="page-link" href="<?= BASE_URL ?>?act=admin-reviews&page=<?= $i ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>
  </ul>
  <div class="small text-secondary">Trang <?= $page ?> / <?= $pages ?> (<?= $total ?> mục)</div>
</nav>
<?php $__content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>


