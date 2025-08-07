<?php
// Kiểm tra dữ liệu slider từ controller
$sliderItems = $sliderItems ?? []; // Mảng chứa các item slider
?>

<div class="container mt-4 slider">
    <div id="productSlider" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php foreach ($sliderItems as $index => $item): ?>
                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                    <img src="<?php echo $item['image'] ?? 'https://via.placeholder.com/1200x300'; ?>" class="d-block w-100" alt="<?php echo $item['alt'] ?? 'Slider item'; ?>">
                    <div class="carousel-caption d-none d-md-block">
                        <h5><?php echo $item['title'] ?? 'Sản phẩm nổi bật'; ?></h5>
                        <p><?php echo $item['description'] ?? 'Khám phá ngay!'; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#productSlider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#productSlider" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
</div>

<style>
    /* Tùy chỉnh phong cách đen trắng cho slider */
    .slider {
        background-color: #222222; /* Nền slider */
    }
    .carousel-caption {
        background-color: rgba(0, 0, 0, 0.7); /* Caption mờ đen */
        color: #FFFFFF; /* Chữ trắng */
    }
</style>