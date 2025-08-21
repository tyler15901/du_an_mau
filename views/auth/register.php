<?php include __DIR__ . '/../partials/header.php'; ?>

<section class="section p-0 auth-page">
  <div class="container-fluid px-0">
    <div class="row g-0 auth-split">
      <div class="col-lg-6 d-none d-lg-block auth-left"></div>
      <div class="col-lg-6 d-flex align-items-center justify-content-center p-4 p-md-5">
        <div class="auth-panel" style="width:520px;max-width:90%">
        <?php if (!empty($error)): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" action="<?= BASE_URL ?>?act=post-register">
          <div class="row g-2 mb-3">
            <div class="col-6"><input class="form-control auth-input" name="ho" placeholder="Họ"></div>
            <div class="col-6"><input class="form-control auth-input" name="ten" placeholder="Tên"></div>
          </div>
          <div class="mb-3">
            <div class="d-flex gap-4">
              <label class="form-check"><input type="radio" class="form-check-input" name="gender" value="Nam" checked> <span class="form-check-label">Nam</span></label>
              <label class="form-check"><input type="radio" class="form-check-input" name="gender" value="Nữ"> <span class="form-check-label">Nữ</span></label>
            </div>
          </div>
          <div class="mb-3"><input type="date" name="dob" class="form-control auth-input" placeholder="mm/dd/yyyy"></div>
          <div class="mb-3"><input type="email" name="email" class="form-control auth-input" placeholder="Email" ></div>
          <div class="mb-3"><input type="password" name="password" class="form-control auth-input" placeholder="Mật khẩu" minlength="6" ></div>
          <div class="mb-3"><input type="password" name="confirm_password" class="form-control auth-input" placeholder="Xác nhận mật khẩu" minlength="6" ></div>
          <button type="submit" class="btn w-100 auth-btn-outline">TẠO TÀI KHOẢN</button>
        </form>
        <a href="<?= BASE_URL ?>?act=login" class="btn w-100 mt-3 auth-btn-dark">ĐĂNG NHẬP</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/../partials/footer.php'; ?>

