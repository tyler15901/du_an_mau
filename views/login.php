<?php
// Kiểm tra session hoặc dữ liệu từ controller
$title = $title ?? "Đăng nhập";
$errorMessage = $errorMessage ?? ""; // Thông báo lỗi nếu có
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #000000;
            color: #FFFFFF;
        }
        .navbar {
            background-color: #333333;
        }
        .login-form {
            background-color: #1a1a1a;
            padding: 20px;
            border: 1px solid #555555;
        }
        .form-control {
            background-color: #222222;
            color: #FFFFFF;
            border: 1px solid #555555;
        }
        .btn {
            background-color: #FFFFFF;
            color: #000000;
        }
        .btn:hover {
            background-color: #CCCCCC;
        }
    </style>
</head>
body
    <!-- Header -->
    <?php include 'layouts/header.php'; ?>

    <!-- Login Section -->
    <div class="container mt-4">
        <div class="login-form">
            <h2>Đăng nhập</h2>
            <?php if ($errorMessage): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $errorMessage; ?> <!-- Hiển thị lỗi từ validation -->
                </div>
            <?php endif; ?>
            <form action="index.php?act=login" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn">Đăng nhập</button>
                <p class="mt-2">Chưa có tài khoản? <a href="index.php?act=register" style="color: #CCCCCC;">Đăng ký ngay</a></p>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'layouts/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>