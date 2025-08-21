<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FPOLYSHOP Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/admin.css">
  <style>body{background:#f5f6fa}</style>
  </head>
<body>
  <div class="admin-shell">
    <aside class="admin-sidebar">
      <div class="brand">FPOLYSHOP</div>
      <nav>
        <a href="<?= BASE_URL ?>?act=admin" class="nav-link">Bảng điều khiển</a>
        <a href="<?= BASE_URL ?>?act=admin-categories" class="nav-link">Danh mục</a>
        <a href="<?= BASE_URL ?>?act=admin-products" class="nav-link">Sản phẩm</a>
        <a href="<?= BASE_URL ?>?act=admin-users" class="nav-link">Người dùng</a>
        <a href="<?= BASE_URL ?>?act=admin-reviews" class="nav-link">Bình luận</a>
        <hr />
        <a href="<?= BASE_URL ?>" class="nav-link">Về trang bán hàng</a>
        <a href="<?= BASE_URL ?>?act=logout" class="nav-link text-danger">Đăng xuất</a>
      </nav>
    </aside>
    <div class="admin-content">
      <div class="admin-topbar">
        <form class="admin-search" method="get" action="">
          <input type="hidden" name="act" value="admin-products" />
          <i class="bi bi-search"></i>
          <input type="text" name="q" placeholder="Tìm kiếm" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" />
        </form>
        <div class="admin-greet">
          
          <span>Xin chào, <?= htmlspecialchars($_SESSION['user']['name'] ?? 'Admin') ?></span>
        </div>
      </div>
      <main class="admin-main">
        <?php if (isset($__content)) { echo $__content; } ?>
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


