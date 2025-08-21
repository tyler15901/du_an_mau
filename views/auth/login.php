<?php include __DIR__ . '/../partials/header.php'; ?>

<section class="section p-0 auth-page">
  <div class="container-fluid px-0">
    <div class="row g-0 auth-split">
      <div class="col-lg-6 d-none d-lg-block auth-left"></div>
      <div class="col-lg-6 d-flex align-items-center justify-content-center p-4 p-md-5">
        <div class="auth-panel" style="width:520px;max-width:90%">
        <p class="text-center small mb-4" style="color:#000">Đăng nhập để trải nghiệm mua hàng nhanh hơn</p>
        <?php if (!empty($error)): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" action="<?= BASE_URL ?>?act=post-login">
          <div class="mb-3">
            <input type="email" name="email" class="form-control auth-input" placeholder="E-mail" >
          </div>
          <div class="mb-3 auth-field">
            <input type="password" name="password" class="form-control auth-input" placeholder="Password">
            
          </div>
          <button type="submit" class="btn w-100 auth-btn-dark">ĐĂNG NHẬP</button>
        </form>
        <a href="<?= BASE_URL ?>?act=register" class="btn w-100 mt-3 auth-btn-outline">TẠO TÀI KHOẢN</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/../partials/footer.php'; ?>

