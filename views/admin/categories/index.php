<?php 
$__admin_view = __FILE__;
ob_start();
?>
<div class="d-flex justify-content-between align-items-center mb-3" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
  <h1 class="h3 m-0">Danh mục</h1>
  <a class="btn btn-secondary" href="<?= BASE_URL ?>?act=admin-category-create">Thêm</a>
  </div>
<div class="card" style="padding:12px">
  <table class="table">
    <thead><tr><th>ID</th><th>Tên</th><th>Slug</th><th style="width:160px"></th></tr></thead>
    <tbody>
      <?php foreach($categories as $c): ?>
      <tr>
        <td><?= (int)$c['id'] ?></td>
        <td><?= htmlspecialchars($c['name']) ?></td>
        <td><?= htmlspecialchars($c['slug']) ?></td>
        <td>
          <a class="btn btn-sm btn-secondary" href="<?= BASE_URL ?>?act=admin-category-edit&id=<?= (int)$c['id'] ?>">Sửa</a>
          <a class="btn btn-sm btn-outline-danger" href="<?= BASE_URL ?>?act=admin-category-delete&id=<?= (int)$c['id'] ?>" onclick="return confirm('Xóa danh mục?')">Xóa</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<nav class="mt-3">
  <ul class="pagination">
    <?php for($i=1;$i<=$pages;$i++): ?>
      <li class="page-item <?= $i===$page?'active':'' ?>">
        <a class="page-link" href="<?= BASE_URL ?>?act=admin-categories&page=<?= $i ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>
  </ul>
  <div class="small text-secondary">Trang <?= $page ?> / <?= $pages ?> (<?= $total ?> mục)</div>
</nav>
<?php $__content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>


