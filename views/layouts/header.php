<?php
// Kiểm tra session để hiển thị thông tin người dùng nếu đã đăng nhập
$isLoggedIn = isset($_SESSION['user_id']) ? true : false;
$userName = $isLoggedIn ? $_SESSION['user_name'] ?? 'Người dùng' : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Tùy chỉnh phong cách đen trắng */
        .navbar {
            background-color: #333333; /* Navbar tối hơn */
        }
        .navbar-brand img {
            max-height: 50px; /* Kích thước logo */
        }
        .nav-link, .navbar-text {
            color: #FFFFFF !important; /* Chữ trắng */
        }
        .nav-link:hover {
            color: #CCCCCC !important; /* Chữ xám nhạt khi hover */
        }
        .icon {
            color: #FFFFFF; /* Màu icon */
            margin-left: 10px;
        }
        .icon:hover {
            color: #CCCCCC; /* Màu xám nhạt khi hover */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <!-- Logo (Bên trái) -->
            <a class="navbar-brand" href="index.php">
                <img src="https://via.placeholder.com/100x50" alt="Fashion Store Logo">
            </a>

            <!-- Navbar (Bên phải) -->
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?act=products">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?act=about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?act=contact">Contact</a>
                    </li>
                </ul>

                <!-- Icon (Search, Person, Cart) -->
                <div class="navbar-text">
                    <a href="index.php?act=search" class="icon"><i class="bi bi-search"></i></a>
                    <?php if ($isLoggedIn): ?>
                        <span class="me-2">Xin chào, <?php echo $userName; ?>!</span>
                        <a href="index.php?act=logout" class="icon"><i class="bi bi-box-arrow-right"></i></a>
                    <?php else: ?>
                        <a href="index.php?act=login" class="icon"><i class="bi bi-person"></i></a>
                    <?php endif; ?>
                    <a href="index.php?act=cart" class="icon"><i class="bi bi-cart"></i></a>
                </div>
            </div>
        </div>
    </nav>
</body>
</html>