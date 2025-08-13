<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - Fashion Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #000;
            --secondary-color: #333;
            --accent-color: #fff;
            --text-color: #333;
            --light-gray: #f8f9fa;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
            background: linear-gradient(135deg, #000 0%, #333 100%);
            min-height: 100vh;
            padding: 40px 0;
        }
        
        .register-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            margin: 0 auto;
        }
        
        .register-image {
            background: linear-gradient(135deg, #000 0%, #333 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 40px;
        }
        
        .register-image h2 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        
        .register-image p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .register-form {
            padding: 40px;
        }
        
        .form-title {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 1rem;
            text-align: center;
        }
        
        .form-subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 2rem;
        }
        
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0,0,0,0.1);
        }
        
        .input-group-text {
            background: transparent;
            border: 2px solid #e9ecef;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }
        
        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: bold;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: bold;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }
        
        .alert {
            border-radius: 10px;
            border: none;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e9ecef;
        }
        
        .divider span {
            background: white;
            padding: 0 15px;
            color: #666;
        }
        
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: bold;
        }
        
        .back-link a:hover {
            text-decoration: underline;
        }
        
        .password-strength {
            margin-top: 5px;
            font-size: 0.875rem;
        }
        
        .strength-weak { color: #dc3545; }
        .strength-medium { color: #ffc107; }
        .strength-strong { color: #28a745; }
        
        @media (max-width: 768px) {
            .register-image {
                display: none;
            }
            
            .register-form {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
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
    <script>
        // Password strength checker
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthDiv = document.getElementById('passwordStrength');
            
            let strength = 0;
            let message = '';
            let className = '';
            
            if (password.length >= 6) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            switch (strength) {
                case 0:
                case 1:
                    message = 'Rất yếu';
                    className = 'strength-weak';
                    break;
                case 2:
                    message = 'Yếu';
                    className = 'strength-weak';
                    break;
                case 3:
                    message = 'Trung bình';
                    className = 'strength-medium';
                    break;
                case 4:
                    message = 'Mạnh';
                    className = 'strength-strong';
                    break;
                case 5:
                    message = 'Rất mạnh';
                    className = 'strength-strong';
                    break;
            }
            
            strengthDiv.textContent = message;
            strengthDiv.className = 'password-strength ' + className;
        });
        
        // Password confirmation checker
        document.getElementById('confirm_password').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            const confirmDiv = document.getElementById('confirmStrength');
            
            if (confirmPassword === '') {
                confirmDiv.textContent = '';
                confirmDiv.className = 'password-strength';
            } else if (password === confirmPassword) {
                confirmDiv.textContent = 'Mật khẩu khớp';
                confirmDiv.className = 'password-strength strength-strong';
            } else {
                confirmDiv.textContent = 'Mật khẩu không khớp';
                confirmDiv.className = 'password-strength strength-weak';
            }
        });
        
        // Form validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Mật khẩu xác nhận không khớp!');
                return false;
            }
            
            if (password.length < 6) {
                e.preventDefault();
                alert('Mật khẩu phải có ít nhất 6 ký tự!');
                return false;
            }
        });
    </script>
</body>
</html>
