<?php 
// Shared header
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) : 'Fashion Store' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="bg-white" style="height: var(--header-h); display:flex; align-items:center;">
            <div class="container d-flex align-items-center justify-content-between">
                <button class="btn btn-link text-dark d-flex align-items-center gap-2 p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                    <span class="text-uppercase small">Menu</span>
                </button>
                <a class="navbar-brand m-0 text-dark fw-semibold" href="<?= BASE_URL ?>">FPOLYSHOP</a>
                <div class="d-flex align-items-center gap-3">
                    <button class="btn p-0 text-dark" id="btnOpenSearch" type="button" aria-label="Search"><i class="bi bi-search fs-5"></i></button>
                    <?php $authUser = $_SESSION['user'] ?? null; ?>
                    <div class="dropdown">
                        <a class="text-dark text-decoration-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person fs-5"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <?php if ($authUser): ?>
                                <li><h6 class="dropdown-header">Xin chào, <?= htmlspecialchars($authUser['name']) ?></h6></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>?act=logout">Đăng xuất</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>?act=login">Đăng nhập</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>?act=register">Đăng ký</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <a class="text-dark" href="#" aria-label="Cart"><i class="bi bi-bag fs-5"></i></a>
                </div>
            </div>
        </div>

        <!-- Offcanvas Menu -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
            <div class="offcanvas-header">
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-link text-dark p-0" data-bs-dismiss="offcanvas" aria-label="Close">X</button>
                    <span class="text-uppercase small">Menu</span>
                </div>
            </div>
            <div class="offcanvas-body">
                <ul class="list-unstyled">
                    <li><a class="d-flex justify-content-between align-items-center py-2 text-dark text-decoration-none" href="<?= BASE_URL ?>?act=san-pham">Shop</a></li>
                    <li><a class="d-flex justify-content-between align-items-center py-2 text-dark text-decoration-none" href="<?= BASE_URL ?>?act=san-pham-moi">Sản phẩm mới</a></li>
                    <li><a class="d-flex justify-content-between align-items-center py-2 text-dark text-decoration-none" href="<?= BASE_URL ?>?act=san-pham&tag=ao-phong">Áo phông</a></li>
                    <li><a class="d-flex justify-content-between align-items-center py-2 text-dark text-decoration-none" href="<?= BASE_URL ?>?act=san-pham&tag=ao-so-mi">Áo sơ mi</a></li>
                    <li><a class="d-flex justify-content-between align-items-center py-2 text-dark text-decoration-none" href="<?= BASE_URL ?>?act=san-pham&tag=ao-khoac">Áo khoác</a></li>
                    <li><a class="d-flex justify-content-between align-items-center py-2 text-dark text-decoration-none" href="<?= BASE_URL ?>?act=san-pham&tag=quan-dai">Quần dài</a></li>
                    <li><a class="d-flex justify-content-between align-items-center py-2 text-dark text-decoration-none" href="<?= BASE_URL ?>?act=san-pham&tag=quan-ngan">Quần ngắn</a></li>
                    <li><a class="d-flex justify-content-between align-items-center py-2 text-dark text-decoration-none" href="<?= BASE_URL ?>?act=san-pham&tag=phu-kien">Phụ kiện</a></li>
                    <li><a class="d-flex justify-content-between align-items-center py-2 text-dark text-decoration-none" href="<?= BASE_URL ?>?act=ve-chung-toi">Giới thiệu</a></li>
                    <li><a class="d-flex justify-content-between align-items-center py-2 text-dark text-decoration-none" href="<?= BASE_URL ?>?act=lien-he">Liên hệ</a></li>
                    <hr class="text-secondary">
                    <?php if ($authUser): ?>
                        <li><a class="d-flex justify-content-between align-items-center py-2 text-dark text-decoration-none" href="<?= BASE_URL ?>?act=logout">Logout</a></li>
                    <?php else: ?>
                        <li><a class="d-flex justify-content-between align-items-center py-2 text-dark text-decoration-none" href="<?= BASE_URL ?>?act=login">Login</a></li>
                        <li><a class="d-flex justify-content-between align-items-center py-2 text-dark text-decoration-none" href="<?= BASE_URL ?>?act=register">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </header>
    <!-- Search overlay -->
    <div class="search-overlay" id="searchOverlay" role="dialog" aria-modal="true" aria-label="Search">
        <div class="search-bar">
            <div class="container d-flex align-items-center gap-3">
                <a class="navbar-brand m-0 text-dark fw-semibold" href="<?= BASE_URL ?>">FPOLYSHOP</a>
                <form class="search-bar-form" method="get" action="">
                    <input type="hidden" name="act" value="san-pham" />
                    <div class="search-input-wrap">
                        <input type="text" name="q" id="searchInput" placeholder="Tìm kiếm sản phẩm..." />
                        <i class="bi bi-search"></i>
                    </div>
                </form>
                <button class="btn btn-link text-dark ms-auto search-close-btn" type="button" id="btnCloseSearch" aria-label="Đóng">X</button>
            </div>
        </div>
    </div>
    <main>

