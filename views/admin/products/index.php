<?php 
$__admin_view = __FILE__;
ob_start();
?>
<div class="d-flex justify-content-between align-items-center mb-3" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
  <h1 class="h3 m-0">Sản phẩm</h1>
  <a class="btn btn-secondary" href="<?= BASE_URL ?>?act=admin-product-create">Thêm</a>
</div>
<div class="card" style="padding:12px">
  <form class="row g-2 mb-3 admin-filters align-items-center" method="get" action="">
    <input type="hidden" name="act" value="admin-products">
    <div class="col-md-2">
      <select class="form-select" name="category_id">
        <option value="">Tất cả danh mục</option>
        <?php foreach($categories as $c): ?>
          <option value="<?= (int)$c['id'] ?>" <?= (($_GET['category_id'] ?? '')==$c['id'])?'selected':'' ?>><?= htmlspecialchars($c['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-2"><input type="number" class="form-control" name="min_price" placeholder="Giá từ" value="<?= htmlspecialchars($_GET['min_price'] ?? '') ?>"></div>
    <div class="col-md-2"><input type="number" class="form-control" name="max_price" placeholder="Giá đến" value="<?= htmlspecialchars($_GET['max_price'] ?? '') ?>"></div>
    <div class="col-md-2">
      <select class="form-select" name="sort">
        <option value="">ID tăng dần</option>
        <option value="id_desc" <?= (($_GET['sort'] ?? '')==='id_desc')?'selected':'' ?>>ID giảm dần</option>
        <option value="price_asc" <?= (($_GET['sort'] ?? '')==='price_asc')?'selected':'' ?>>Giá tăng dần</option>
        <option value="price_desc" <?= (($_GET['sort'] ?? '')==='price_desc')?'selected':'' ?>>Giá giảm dần</option>
        <option value="newest" <?= (($_GET['sort'] ?? '')==='newest')?'selected':'' ?>>Mới nhất</option>
        <option value="oldest" <?= (($_GET['sort'] ?? '')==='oldest')?'selected':'' ?>>Cũ nhất</option>
      </select>
    </div>
    <div class="col-md-2 d-flex align-items-center">
      <div class="form-check m-0">
        <input class="form-check-input" type="checkbox" name="has_discount" id="has_discount" <?= isset($_GET['has_discount'])?'checked':'' ?>>
        <label class="form-check-label ms-1 mb-0" for="has_discount">Giảm giá</label>
      </div>
    </div>
    <div class="col-auto ms-auto"><button class="btn btn-secondary">Lọc</button></div>
  </form>
  <table class="table">
    <thead><tr><th>ID</th><th>Tên</th><th>Danh mục</th><th>Giá</th><th>Giảm%</th><th style="width:220px"></th></tr></thead>
    <tbody>
      <?php foreach($products as $p): ?>
      <tr>
        <td><?= (int)$p['id'] ?></td>
        <td><?= htmlspecialchars($p['name']) ?></td>
        <td><?= htmlspecialchars($p['category_name']) ?></td>
        <td><?= number_format($p['price']) ?>₫</td>
        <td><?= (int)$p['discount_percent'] ?></td>
        <td>
          <a class="btn btn-sm btn-light" href="<?= BASE_URL ?>?act=admin-product-show&id=<?= (int)$p['id'] ?>">Xem</a>
          <a class="btn btn-sm btn-secondary" href="<?= BASE_URL ?>?act=admin-product-edit&id=<?= (int)$p['id'] ?>">Sửa</a>
          <a class="btn btn-sm btn-outline-danger" href="<?= BASE_URL ?>?act=admin-product-delete&id=<?= (int)$p['id'] ?>" onclick="return confirm('Xóa sản phẩm?')">Xóa</a>
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
        <a class="page-link" href="<?= BASE_URL ?>?act=admin-products&page=<?= $i ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>
  </ul>
  <div class="small text-secondary">Trang <?= $page ?> / <?= $pages ?> (<?= $total ?> mục)</div>
</nav>
<?php $__content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>


