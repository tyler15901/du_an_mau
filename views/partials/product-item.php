<?php
// Kiểm tra dữ liệu sản phẩm từ controller
$product = $product ?? []; // Thông tin sản phẩm
?>

<div class="card h-100">
    <img src="<?php echo $product['image'] ?? 'https://via.placeholder.com/200x200'; ?>" class="card-img-top" alt="<?php echo $product['name'] ?? 'Sản phẩm'; ?>">
    <div class="card-body">
        <h5 class="card-title"><?php echo $product['name'] ?? 'Sản phẩm'; ?></h5>
        <p class="card-text"><?php echo number_format($product['price'] ?? 500000, 0, ',', '.') . ' VNĐ'; ?></p>
        <a href="index.php?act=product-detail&id=<?php echo $product['id'] ?? 1; ?>" class="btn">Xem chi tiết</a>
    </div>
</div>

<style>
    /* Tùy chỉnh phong cách đen trắng cho product item */
    .card {
        background-color: #1a1a1a; /* Nền card màu xám đậm */
        border: 1px solid #555555; /* Viền xám */
    }
    .card-title, .card-text {
        color: #FFFFFF; /* Chữ trắng */
    }
    .btn {
        background-color: #FFFFFF; /* Nút trắng */
        color: #000000; /* Chữ đen trên nút */
    }
    .btn:hover {
        background-color: #CCCCCC; /* Nút xám nhạt khi hover */
    }
</style>