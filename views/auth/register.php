<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - Fashion Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>assets/css/base.css?v=1.0.1" rel="stylesheet">
    <link href="<?= BASE_URL ?>assets/css/public.css?v=1.0.1" rel="stylesheet">
</head>
<body class="register-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="register-container">
                    <div class="row g-0">
                        <div class="col-md-5">
                            <div class="register-image">
                                <div class="text-center">
                                    <i class="fas fa-tshirt" style="font-size: 4rem; margin-bottom: 20px;"></i>
                                    <h2>Fashion Store</h2>
                                    <p>Tham gia cùng chúng tôi</p>
                                    <p>Đăng ký để nhận nhiều ưu đãi hấp dẫn</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="register-form">
                                <h2 class="form-title">Đăng Ký</h2>
                                <p class="form-subtitle">Tạo tài khoản mới để bắt đầu mua sắm</p>
                                
                                <?php if (isset($_SESSION['error'])): ?>
                                    <div class="alert alert-danger">
                                        <i class="fas fa-exclamation-triangle me-2"></i><?= $_SESSION['error'] ?>
                                    </div>
                                    <?php unset($_SESSION['error']); ?>
                                <?php endif; ?>
                                
                                <form method="POST" action="<?= BASE_URL ?>register" id="registerForm">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="ho_ten" class="form-label">Họ và tên *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-user"></i>
                                                    </span>
                                                    <input type="text" class="form-control" id="ho_ten" name="ho_ten" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="gioi_tinh" class="form-label">Giới tính *</label>
                                                <select class="form-select" id="gioi_tinh" name="gioi_tinh" required>
                                                    <option value="">Chọn giới tính</option>
                                                    <option value="Nam">Nam</option>
                                                    <option value="Nữ">Nữ</option>
                                                    <option value="Khác">Khác</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="ngay_sinh" class="form-label">Ngày sinh *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar"></i>
                                                    </span>
                                                    <input type="date" class="form-control" id="ngay_sinh" name="ngay_sinh" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-envelope"></i>
                                                    </span>
                                                    <input type="email" class="form-control" id="email" name="email" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Mật khẩu *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-lock"></i>
                                                    </span>
                                                    <input type="password" class="form-control" id="password" name="password" required>
                                                </div>
                                                <div class="password-strength" id="passwordStrength"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <label for="confirm_password" class="form-label">Xác nhận mật khẩu *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-lock"></i>
                                                    </span>
                                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                                </div>
                                                <div class="password-strength" id="confirmStrength"></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary mb-3">
                                        <i class="fas fa-user-plus me-2"></i>Đăng ký
                                    </button>
                                </form>
                                
                                <div class="divider">
                                    <span>hoặc</span>
                                </div>
                                
                                <a href="<?= BASE_URL ?>login" class="btn btn-outline-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Đã có tài khoản? Đăng nhập
                                </a>
                                
                                <div class="back-link">
                                    <a href="<?= BASE_URL ?>">
                                        <i class="fas fa-arrow-left me-1"></i>Quay về trang chủ
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>window.BASE_URL='<?= BASE_URL ?>';</script>
    <script src="<?= BASE_URL ?>assets/js/custom.js"></script>
</body>
</html>
