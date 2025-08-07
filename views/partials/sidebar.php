<?php
// Kiểm tra dữ liệu danh mục từ controller
$categories = $categories ?? []; // Mảng chứa danh mục
?>

<div class="sidebar">
    <h4>Bộ lọc</h4>
    <h5>Danh mục</h5>
    <ul class="list-group">
        <?php foreach ($categories as $category): ?>
            <li class="list-group-item" style="background-color: #222222; color: #FFFFFF;">
                <a href="?act=products&category=<?php echo $category['id']; ?>" style="color: #FFFFFF; text-decoration: none;">
                    <?php echo $category['name'] ?? 'Danh mục'; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <h5 class="mt-3">Giá</h5>
    <select class="form-select mt-2" style="background-color: #1a1a1a; color: #FFFFFF; border: 1px solid #555555;">
        <option value="all">Tất cả</option>
        <option value="0-500000">Dưới 500.000 VNĐ</option>
        <option value="500000-1000000">500.000 - 1.000.000 VNĐ</option>
        <option value="1000000">Trên 1.000.000 VNĐ</option>
    </select>
</div>

<style>
    /* Tùy chỉnh phong cách đen trắng cho sidebar */
    .sidebar {
        background-color: #222222; /* Nền sidebar */
        padding: 15px;
    }
</style>