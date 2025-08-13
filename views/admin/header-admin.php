<?php
// Kiểm tra session admin
$isAdminLoggedIn = isset($_SESSION['admin_id']) ? true : false;
$adminName = $isAdminLoggedIn ? $_SESSION['admin_name'] ?? 'Admin' : '';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="index.php?act=admin-dashboard">
            <img src="https://via.placeholder.com/100x50" alt="Admin Logo">
        </a>

        <!-- Navbar -->
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?act=admin-dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?act=admin-products">Sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?act=admin-categories">Danh mục</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?act=admin-users">Người dùng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?act=admin-comments">Bình luận</a>
                </li>
            </ul>

            <!-- Admin Info -->
            <div class="navbar-text">
                <?php if ($isAdminLoggedIn): ?>
                    <span class="me-2">Xin chào, <?php echo $adminName; ?>!</span>
                    <a href="index.php?act=admin-logout" class="btn btn-outline-light btn-sm">Đăng xuất</a>
                <?php else: ?>
                    <a href="index.php?act=admin-login" class="btn btn-outline-light btn-sm">Đăng nhập</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
