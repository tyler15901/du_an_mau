<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Tùy chỉnh phong cách đen trắng */
        .footer {
            background-color: #333333; /* Nền footer tối */
            color: #FFFFFF; /* Chữ trắng */
            padding: 20px 0;
        }
        .footer a {
            color: #CCCCCC; /* Liên kết xám nhạt */
        }
        .footer a:hover {
            color: #FFFFFF; /* Liên kết trắng khi hover */
        }
    </style>
</head>
<body>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <!-- Giới thiệu -->
                <div class="col-12 col-md-3">
                    <h5>Giới thiệu</h5>
                    <p>Chúng tôi là cửa hàng thời trang nam hàng đầu, mang đến phong cách hiện đại và chất lượng cao.</p>
                </div>
                <!-- Quick link -->
                <div class="col-12 col-md-3">
                    <h5>Quick link</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="index.php?act=products">Product</a></li>
                        <li><a href="index.php?act=about">About</a></li>
                        <li><a href="index.php?act=contact">Contact</a></li>
                    </ul>
                </div>
                <!-- Help and info -->
                <div class="col-12 col-md-3">
                    <h5>Help and info</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Hướng dẫn mua hàng</a></li>
                        <li><a href="#">Chính sách đổi trả</a></li>
                        <li><a href="#">Điều khoản sử dụng</a></li>
                    </ul>
                </div>
                <!-- Contact -->
                <div class="col-12 col-md-3">
                    <h5>Contact</h5>
                    <p>Địa chỉ: 123 Đường Thời Trang, TP. Hồ Chí Minh</p>
                    <p>Điện thoại: +84 123 456 789</p>
                    <p>Email: support@fashionstore.com</p>
                </div>
            </div>
            <div class="text-center mt-3">
                <p>&copy; <?php echo date('Y'); ?> Fashion Store. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>