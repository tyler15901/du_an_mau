<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Admin Panel' ?> - Fashion Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>assets/css/base.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>assets/css/admin.css" rel="stylesheet">
</head>
<body class="admin-layout" data-current-page="<?= $currentPage ?? '' ?>">
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="<?= BASE_URL ?>admin" class="sidebar-brand">
                <i class="fas fa-tshirt me-2"></i>Admin Panel
            </a>
        </div>
        
        <div class="sidebar-menu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'dashboard' ? 'active' : '' ?>" href="<?= BASE_URL ?>admin">
                        <i class="fas fa-tachometer-alt"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'products' ? 'active' : '' ?>" href="<?= BASE_URL ?>admin/products">
                        <i class="fas fa-box"></i>Sản phẩm
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'categories' ? 'active' : '' ?>" href="<?= BASE_URL ?>admin/categories">
                        <i class="fas fa-tags"></i>Danh mục
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'users' ? 'active' : '' ?>" href="<?= BASE_URL ?>admin/users">
                        <i class="fas fa-users"></i>Người dùng
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'reviews' ? 'active' : '' ?>" href="<?= BASE_URL ?>admin/reviews">
                        <i class="fas fa-comments"></i>Bình luận
                    </a>
                </li>
                <li class="nav-item mt-4">
                    <a class="nav-link" href="<?= BASE_URL ?>">
                        <i class="fas fa-home"></i>Về trang chủ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>logout">
                        <i class="fas fa-sign-out-alt"></i>Đăng xuất
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="sidebar-toggle me-3" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h4 class="mb-0"><?= $pageTitle ?? 'Admin Panel' ?></h4>
            </div>
            <div class="d-flex align-items-center">
                <span class="me-3">Xin chào, <?= $_SESSION['user_name'] ?? 'Admin' ?></span>
                <a href="<?= BASE_URL ?>" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-external-link-alt me-1"></i>Xem website
                </a>
            </div>
        </div>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?= $_SESSION['success'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i><?= $_SESSION['error'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Page Content -->
            <?php echo $content ?? ''; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>window.BASE_URL='<?= BASE_URL ?>';window.ADMIN_BASE=window.BASE_URL+'admin/';</script>
    <script src="<?= BASE_URL ?>assets/js/custom.js"></script>
</body>
</html>
