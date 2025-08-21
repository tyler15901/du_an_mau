<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Fashion Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>assets/css/base.css?v=1.0.1" rel="stylesheet">
    <link href="<?= BASE_URL ?>assets/css/public.css?v=1.0.1" rel="stylesheet">
</head>
<body class="login-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="login-container">
                    <div class="row g-0">
                        <div class="col-md-6">
                            <div class="login-image">
                                <div class="text-center">
                                    <i class="fas fa-tshirt" style="font-size: 4rem; margin-bottom: 20px;"></i>
                                    <h2>Fashion Store</h2>
                                    <p>Thời trang nam chất lượng cao</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="login-form">
                                <h2 class="form-title">Đăng Nhập</h2>
                                <p class="form-subtitle">Chào mừng bạn quay trở lại!</p>
                                
                                <?php if (isset($_SESSION['error'])): ?>
                                    <div class="alert alert-danger">
                                        <i class="fas fa-exclamation-triangle me-2"></i><?= $_SESSION['error'] ?>
                                    </div>
                                    <?php unset($_SESSION['error']); ?>
                                <?php endif; ?>
                                
                                <?php if (isset($_SESSION['success'])): ?>
                                    <div class="alert alert-success">
                                        <i class="fas fa-check-circle me-2"></i><?= $_SESSION['success'] ?>
                                    </div>
                                    <?php unset($_SESSION['success']); ?>
                                <?php endif; ?>
                                
                                <form method="POST" action="<?= BASE_URL ?>login">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="password" class="form-label">Mật khẩu</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary mb-3">
                                        <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                                    </button>
                                </form>
                                
                                <div class="divider">
                                    <span>hoặc</span>
                                </div>
                                
                                <a href="<?= BASE_URL ?>register" class="btn btn-outline-primary">
                                    <i class="fas fa-user-plus me-2"></i>Đăng ký tài khoản mới
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
    <script src="<?= BASE_URL ?>assets/js/custom.js"></script>
</body>
</html>
