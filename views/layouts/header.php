<?php
// Kiểm tra session để hiển thị thông tin người dùng nếu đã đăng nhập
$isLoggedIn = isset($_SESSION['user_id']) ? true : false;
$userName = $isLoggedIn ? $_SESSION['user_name'] ?? 'Người dùng' : '';
$userRole = $isLoggedIn ? $_SESSION['user_role'] ?? 'user' : '';
$isAdmin = $isLoggedIn && $userRole === 'admin';
?>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <!-- Logo (Bên trái) -->
        <a class="navbar-brand" href="index.php">
            <img src="https://via.placeholder.com/100x50" alt="Fashion Store Logo">
        </a>

        <!-- Navbar (Bên phải) -->
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav me-auto">
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
                <?php if ($isAdmin): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-gear"></i> Admin
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                            <li><a class="dropdown-item" href="index.php?act=admin-dashboard">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a></li>
                            <li><a class="dropdown-item" href="index.php?act=admin-products">
                                <i class="bi bi-box"></i> Sản phẩm
                            </a></li>
                            <li><a class="dropdown-item" href="index.php?act=admin-categories">
                                <i class="bi bi-tags"></i> Danh mục
                            </a></li>
                            <li><a class="dropdown-item" href="index.php?act=admin-users">
                                <i class="bi bi-people"></i> Người dùng
                            </a></li>
                            <li><a class="dropdown-item" href="index.php?act=admin-comments">
                                <i class="bi bi-chat"></i> Bình luận
                            </a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>

            <!-- Search Bar (Bên phải) -->
            <div class="navbar-nav me-3">
                <form class="d-flex" method="GET" action="index.php">
                    <input type="hidden" name="act" value="products">
                    <div class="input-group">
                        <input class="form-control" type="search" name="search" placeholder="Tìm sản phẩm..." 
                               value="<?php echo $_GET['search'] ?? ''; ?>" aria-label="Search">
                        <button class="btn btn-outline-light" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- User Actions (Bên phải) -->
            <div class="navbar-nav">
                <?php if ($isLoggedIn): ?>
                    <!-- User Menu Dropdown -->
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                            <?php echo $userName; ?>
                            <?php if ($isAdmin): ?>
                                <span class="badge bg-warning text-dark">Admin</span>
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="index.php?act=profile">
                                <i class="bi bi-person"></i> Hồ sơ
                            </a></li>
                            <li><a class="dropdown-item" href="index.php?act=orders">
                                <i class="bi bi-box"></i> Đơn hàng
                            </a></li>
                            <li><a class="dropdown-item" href="index.php?act=wishlist">
                                <i class="bi bi-heart"></i> Yêu thích
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="index.php?act=logout">
                                <i class="bi bi-box-arrow-right"></i> Đăng xuất
                            </a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <!-- Login/Register Links -->
                    <div class="nav-item">
                        <a class="nav-link" href="index.php?act=login" title="Đăng nhập">
                            <i class="bi bi-person"></i>
                            <span class="d-none d-md-inline">Đăng nhập</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link" href="index.php?act=register" title="Đăng ký">
                            <i class="bi bi-person-plus"></i>
                            <span class="d-none d-md-inline">Đăng ký</span>
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Cart Icon -->
                <div class="nav-item">
                    <a class="nav-link position-relative" href="index.php?act=cart" title="Giỏ hàng">
                        <i class="bi bi-cart3"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <span id="cart-count">0</span>
                        </span>
                        <span class="d-none d-md-inline">Giỏ hàng</span>
                    </a>
                </div>

                <!-- Wishlist Icon -->
                <div class="nav-item">
                    <a class="nav-link" href="index.php?act=wishlist" title="Yêu thích">
                        <i class="bi bi-heart"></i>
                        <span class="d-none d-md-inline">Yêu thích</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Bootstrap Icons CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    /* Custom styles for header */
    .navbar {
        background-color: #333333 !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .navbar-brand img {
        max-height: 40px;
    }
    
    .nav-link {
        color: #FFFFFF !important;
        transition: color 0.3s ease;
    }
    
    .nav-link:hover {
        color: #CCCCCC !important;
    }
    
    .form-control {
        background-color: #444444 !important;
        border-color: #555555 !important;
        color: #FFFFFF !important;
    }
    
    .form-control:focus {
        background-color: #555555 !important;
        border-color: #666666 !important;
        color: #FFFFFF !important;
        box-shadow: 0 0 0 0.2rem rgba(255,255,255,0.25);
    }
    
    .form-control::placeholder {
        color: #AAAAAA !important;
    }
    
    .btn-outline-light {
        border-color: #555555 !important;
    }
    
    .btn-outline-light:hover {
        background-color: #FFFFFF !important;
        color: #000000 !important;
    }
    
    .dropdown-menu {
        background-color: #333333 !important;
        border-color: #555555 !important;
    }
    
    .dropdown-item {
        color: #FFFFFF !important;
    }
    
    .dropdown-item:hover {
        background-color: #444444 !important;
        color: #FFFFFF !important;
    }
    
    .dropdown-divider {
        border-color: #555555 !important;
    }
    
    .badge {
        font-size: 0.7em;
    }
    
    .badge.bg-warning {
        font-size: 0.6em;
        margin-left: 5px;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .navbar-nav .nav-link {
            padding: 0.5rem 0.25rem;
        }
        
        .input-group {
            width: 200px;
        }
    }
</style>