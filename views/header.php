<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <!-- Comment: CDN Bootstrap CSS cho responsive layout, grid, carousel, modal. -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons cho icon (truck, etc.). -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- CSS tùy chỉnh cho theme nam tính (navy blue, gray). -->
    <link rel="stylesheet" href="<?= BASE_URL; ?>assets/css/custom.css">
</head>
<body>
    <!-- Comment: Bootstrap Navbar cho header giống Torano: Logo trái, menu giữa, icon phải. -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <!-- Logo bên trái. -->
            <a class="navbar-brand" href="<?= BASE_URL; ?>">Thời Trang Nam</a>

            <!-- Menu ngang giữa với 5 mục, PHP loop từ $menu. -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span> <!-- Hamburger mobile. -->
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <?php foreach ($menu as $item): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <?= $item['name']; ?> 
                            </a>
                            <?php if (!empty($item['sub'])): ?>
                                <ul class="dropdown-menu">
                                    <?php foreach ($item['sub'] as $sub): ?>
                                        <li><a class="dropdown-item" href="<?= BASE_URL . 'category/' . $sub['slug']; ?>"><?= $sub['name']; ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Icon bên phải: Search, User, Cart. -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#" id="searchToggle"><i class="bi bi-search"></i></a> <!-- Click toggle search. -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#userModal"><i class="bi bi-person"></i></a> <!-- Modal user. -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-cart"></i> <span class="badge bg-danger">0</span></a> <!-- Badge cart động (JS update). -->
                </li>
            </ul>
        </div>
    </nav>

    <!-- Comment: Thanh tìm kiếm toggle (ẩn ban đầu, show khi click icon search). -->
    <div class="search-bar d-none bg-light p-2" id="searchBar">
        <div class="container">
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Bạn muốn tìm gì?" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Tìm</button>
                <button class="btn btn-link" id="closeSearch">X</button>
            </form>
        </div>
    </div>

    <!-- Comment: Modal user cho đăng nhập/đăng ký/quên mật khẩu (đơn giản, bỏ captcha). -->
    <div class="modal fade" id="userModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Đăng Nhập Tài Khoản</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="loginForm">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" placeholder="Nhập email của bạn" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" placeholder="Nhập mật khẩu" required>
                        </div>
                        <button type="submit" class="btn btn-danger w-100">Đăng Nhập</button>
                    </form>
                    <p class="text-center mt-3">
                        <a href="#" id="forgotLink">Quên mật khẩu?</a> | <a href="#" id="registerLink">Khách hàng mới? Tạo tài khoản</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Comment: JS cho toggle search và modal (sử dụng Bootstrap JS). -->
    <script>
        // Comment: Event click toggle thanh tìm kiếm.
        document.getElementById('searchToggle').addEventListener('click', function() {
            document.getElementById('searchBar').classList.toggle('d-none');
        });
        document.getElementById('closeSearch').addEventListener('click', function() {
            document.getElementById('searchBar').classList.add('d-none');
        });

        // Comment: JS cho form đăng nhập (AJAX submit giả sử, validate cơ bản).
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Ngăn reload.
            // Validate và AJAX post đến UserController->login() (thêm sau nếu cần).
            alert('Đăng nhập thành công!'); // Placeholder.
        });
    </script>