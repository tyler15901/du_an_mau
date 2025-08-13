<?php
// Kiểm tra session hoặc dữ liệu từ controller
$title = $title ?? "Danh mục sản phẩm";
$category = $category ?? []; // Thông tin danh mục từ model
$products = $products ?? []; // Danh sách sản phẩm từ model
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
        .btn {
            background-color: #FFFFFF;
            color: #000000;
        }
        .btn:hover {
            background-color: #CCCCCC;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php include 'layouts/header.php'; ?>

    <!-- Category Section -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h2><?php echo $category['name'] ?? 'Danh mục'; ?></h2>
                <p><?php echo $category['description'] ?? 'Các sản phẩm trong danh mục này'; ?></p>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-12 col-md-3 mb-3">
                    <div class="card h-100">
                        <img src="https://via.placeholder.com/200x200" class="card-img-top" alt="<?php echo $product['name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['name']; ?></h5>
                            <p class="card-text"><?php echo number_format($product['price'], 0, ',', '.') . ' VNĐ'; ?></p>
                            <a href="index.php?act=product-detail&id=<?php echo $product['id']; ?>" class="btn">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <?php if (empty($products)): ?>
            <div class="row">
                <div class="col-12 text-center">
                    <p>Không có sản phẩm nào trong danh mục này.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <?php include 'layouts/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
