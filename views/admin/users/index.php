<?php 
$__admin_view = __FILE__;
ob_start();
?>
<div class="card" style="padding:12px">
  <h1 class="h3 mb-3">Người dùng</h1>
  <table class="table">
    <thead><tr><th>ID</th><th>Họ tên</th><th>Email</th><th>Giới tính</th><th>Ngày sinh</th><th>Vai trò</th></tr></thead>
    <tbody>
      <?php foreach($users as $u): ?>
      <tr>
        <td><?= (int)$u['id'] ?></td>
        <td><?= htmlspecialchars($u['ho_ten']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td><?= htmlspecialchars($u['gioi_tinh']) ?></td>
        <td><?= htmlspecialchars($u['ngay_sinh']) ?></td>
        <td><?= htmlspecialchars($u['role']) ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<nav class="mt-3">
  <ul class="pagination">
    <?php for($i=1;$i<=$pages;$i++): ?>
      <li class="page-item <?= $i===$page?'active':'' ?>">
        <a class="page-link" href="<?= BASE_URL ?>?act=admin-users&page=<?= $i ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>
  </ul>
  <div class="small text-secondary">Trang <?= $page ?> / <?= $pages ?> (<?= $total ?> mục)</div>
</nav>
<?php $__content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>


