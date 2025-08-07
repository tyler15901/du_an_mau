<?php
// Kiểm tra session hoặc dữ liệu từ controller
$title = $title ?? "Liên hệ với chúng tôi";
$successMessage = $successMessage ?? ""; // Thông báo thành công nếu có
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <?php include 'layouts/header.php'; ?>

    <!-- Contact Section -->
    <div class="container mt-4">
        <h2>Liên hệ với chúng tôi</h2>
        <?php if ($successMessage): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>
        <div class="contact-form">
            <form action="index.php?act=send-contact" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Họ và tên</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">Chủ đề</label>
                    <input type="text" class="form-control" id="subject" name="subject" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Nội dung</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn">Gửi liên hệ</button>
            </form>
        </div>
        <div class="mt-4">
            <h4>Thông tin liên hệ</h4>
            <p><strong>Địa chỉ:</strong> 123 Đường Thời Trang, TP. Hồ Chí Minh, Việt Nam</p>
            <p><strong>Điện thoại:</strong> +84 123 456 789</p>
            <p><strong>Email:</strong> support@fashionstore.com</p>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'layouts/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>