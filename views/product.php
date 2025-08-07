<?php
// Kiểm tra session hoặc dữ liệu từ controller
$title = $title ?? "Danh sách sản phẩm thời trang nam";
$products = $products ?? []; // Danh sách sản phẩm từ model
$categories = $categories ?? []; // Danh mục từ model
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
        .card {
            background-color: #1a1a1a;
            border: 1px solid #555555;
        }
        .sidebar {
            background-color: #222222;
            padding: 15px;
        }
        .btn {
            background-color: #FFFFFF;
            color: #000000;
        }
        .btn:hover {
            background-color: #CCCCCC;
        }
        .form-control {
            background-color: #222222;
            color: #FFFFFF;
            border-color: #555555;
        }
    </style>
</head>
body
    <!-- Header -->
    <?php include 'layouts/header.php'; ?>

    <!-- Product and Sidebar Section -->
    <div class="container mt-4">
        <div class="row">
            <!-- Sidebar (Bộ lọc) -->
            <div class="col-12 col-md-3">
                <div class="sidebar">
                    <h4>Bộ lọc</h4>
                    <h5>Danh mục</h5>
                    <ul class="list-group">
                        <?php foreach ($categories as $category): ?>
                            <li class="list-group-item" style="background-color: #222222; color: #FFFFFF;">
                                <a href="?act=products&category=<?php echo $category['id']; ?>" style="color: #FFFFFF; text-decoration: none;">
                                    <?php echo $category['name']; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <h5 class="mt-3">Giá</h5>
                    <select class="form-select mt-2" name="price_range" onchange="this.form.submit()" style="background-color: #1a1a1a; color: #FFFFFF;">
                        <option value="all">Tất cả</option>
                        <option value="0-500000">Dưới 500.000 VNĐ</option>
                        <option value="500000-1000000">500.000 - 1.000.000 VNĐ</option>
                        <option value="1000000">Trên 1.000.000 VNĐ</option>
                    </select>
                </div>
            </div>

            <!-- Product Section -->
            <div class="col-12 col-md-9">
                <!-- Form search -->
                <form method="GET" class="mb-3">
                    <input type="hidden" name="act" value="products">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Tìm sản phẩm..." value="<?php echo $_GET['search'] ?? ''; ?>"> <!-- Input search -->
                        <button type="submit" class="btn">Tìm</button> <!-- Nút tìm -->
                    </div>
                </form>
                <div class="row">
                    <?php for ($i = 1; $i <= 4; $i++): // Slider 1 2 3 4 ?>
                        <div class="col-12 mb-4">
                            <div id="productCarousel<?php echo $i; ?>" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php for ($j = 0; $j < count($products) && $j < 3; $j++): // 3 sản phẩm mỗi slider ?>
                                        <div class="carousel-item <?php echo $j === 0 ? 'active' : ''; ?>">
                                            <div class="card">
                                                <img src="https://via.placeholder.com/300x300" class="card-img-top" alt="<?php echo $products[$j]['name'] ?? 'Product'; ?>">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo $products[$j]['name'] ?? 'Sản phẩm ' . $j; ?></h5>
                                                    <p class="card-text"><?php echo number_format($products[$j]['price'] ?? 500000, 0, ',', '.') . ' VNĐ'; ?></p>
                                                    <a href="index.php?act=product-detail&id=<?php echo $products[$j]['id'] ?? $j; ?>" class="btn">Xem chi tiết</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel<?php echo $i; ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel<?php echo $i; ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'layouts/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>