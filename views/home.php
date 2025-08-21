<?php $title = $title ?? 'Home'; include __DIR__ . '/partials/header.php'; ?>

<!-- Slideshow (JS) -->
<section class="section p-0">
    <div class="visual simple-slider" id="homeSlider">
        <?php foreach ($slides as $i => $s): ?>
        <div class="slide <?= $i===0 ? 'active' : '' ?>">
            <img class="slider-media" src="<?= BASE_URL . $s ?>" alt="slide <?= $i+1 ?>" loading="eager">
        </div>
        <?php endforeach; ?>
        <a href="<?= BASE_URL ?>?act=san-pham" aria-label="Xem sản phẩm" style="position:absolute;inset:0;z-index:1"></a>
        <button class="slider-prev" aria-label="Prev">‹</button>
        <button class="slider-next" aria-label="Next">›</button>
    </div>
    <script>window.addEventListener('DOMContentLoaded',function(){ window.initSimpleSlider('#homeSlider', 3000); });</script>
</section>

<!-- Danh mục sản phẩm -->
<section class="section">
    <div class="container">
        <div class="cat-header">
            <h2 class="h1 m-0">Danh mục sản phẩm</h2>
            <div class="cat-nav">
                <button class="btn-round" type="button" id="catPrev" aria-label="Prev">‹</button>
                <button class="btn-round" type="button" id="catNext" aria-label="Next">›</button>
            </div>
        </div>
        <div class="categories-scroller" id="categoriesScroller">
            <a class="category-tile" href="<?= BASE_URL ?>?act=san-pham&tag=ao-phong">
                <div class="img" style="background-image:url('<?= BASE_URL ?>uploads/img-category/ao-phong.jpg')"></div>
                <div class="overlay">
                    <span class="name">Áo phông</span>
                    <span class="arrow">→</span>
                </div>
            </a>
            <a class="category-tile" href="<?= BASE_URL ?>?act=san-pham&tag=ao-so-mi">
                <div class="img" style="background-image:url('<?= BASE_URL ?>uploads/img-category/ao-so-mi.jpg')"></div>
                <div class="overlay">
                    <span class="name">Áo sơ mi</span>
                    <span class="arrow">→</span>
                </div>
            </a>
            <a class="category-tile" href="<?= BASE_URL ?>?act=san-pham&tag=quan-dai">
                <div class="img" style="background-image:url('<?= BASE_URL ?>uploads/img-category/quan-dai.jpg')"></div>
                <div class="overlay">
                    <span class="name">Quần dài</span>
                    <span class="arrow">→</span>
                </div>
            </a>
            <a class="category-tile" href="<?= BASE_URL ?>?act=san-pham&tag=quan-ngan">
                <div class="img" style="background-image:url('<?= BASE_URL ?>uploads/img-category/quan-ngan.jpg')"></div>
                <div class="overlay">
                    <span class="name">Quần ngắn</span>
                    <span class="arrow">→</span>
                </div>
            </a>
            <a class="category-tile" href="<?= BASE_URL ?>?act=san-pham&tag=ao-khoac">
                <div class="img" style="background-image:url('<?= BASE_URL ?>uploads/img-category/ao-khoac.jpg')"></div>
                <div class="overlay">
                    <span class="name">Áo khoác</span>
                    <span class="arrow">→</span>
                </div>
            </a>
            <a class="category-tile" href="<?= BASE_URL ?>?act=san-pham&tag=phu-kien">
                <div class="img" style="background-image:url('<?= BASE_URL ?>uploads/img-category/phu-kien.jpg')"></div>
                <div class="overlay">
                    <span class="name">Phụ kiện</span>
                    <span class="arrow">→</span>
                </div>
            </a>
        </div>
        <script>
        (function(){
            const scroller = document.getElementById('categoriesScroller');
            const prev = document.getElementById('catPrev');
            const next = document.getElementById('catNext');
            const step = scroller ? scroller.clientWidth / 4 : 300;
            if(prev && scroller){ prev.addEventListener('click', ()=> scroller.scrollBy({left: -step, behavior:'smooth'})); }
            if(next && scroller){ next.addEventListener('click', ()=> scroller.scrollBy({left: step, behavior:'smooth'})); }
        })();
        </script>
    </div>
</section>

<!-- Sản phẩm mới -->
<section class="section">
    <div class="container">
        <h2 class="h1 mb-4 m-0"><a href="<?= BASE_URL ?>?act=san-pham-moi">Sản phẩm mới</a></h2>
        <div class="grid cards">
            <?php $i=0; foreach ($newProducts as $p): if ($i++>=8) break; ?>
            <a class="card" href="<?= BASE_URL ?>?act=chi-tiet-san-pham&slug=<?= urlencode($p['slug']) ?>">
                <div class="card-img" style="background-image:url('<?= BASE_URL . htmlspecialchars($p['image']) ?>')"></div>
                <div class="card-body">
                    <h3 class="h5 mb-1"><?= htmlspecialchars($p['name']) ?></h3>
                    <p class="price"><?= number_format($p['price']) ?>₫</p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <div class="center" style="margin-top:16px">
            <a class="btn btn-outline" href="<?= BASE_URL ?>?act=san-pham-moi">Xem thêm</a>
        </div>
    </div>
</section>

<!-- Banner -->
<section class="section p-0">
    <a class="visual" href="<?= BASE_URL ?>?act=san-pham&promo=1" style="display:block">
        <img class="banner-media" src="<?= BASE_URL . $banner ?>" alt="banner">
    </a>
</section>

<!-- Sản phẩm khuyến mãi -->
<section class="section">
    <div class="container">
        <h2 class="h1 mb-4 m-0">Sản phẩm khuyến mãi</h2>
        <div class="grid cards">
            <?php $i=0; foreach ($promoProducts as $p): if ($i++>=8) break; ?>
            <a class="card" href="<?= BASE_URL ?>?act=chi-tiet-san-pham&slug=<?= urlencode($p['slug']) ?>">
                <div class="card-img" style="background-image:url('<?= BASE_URL . htmlspecialchars($p['image']) ?>')">
                    <?php if (!empty($p['discount_percent']) && (int)$p['discount_percent']>0): ?>
                        <span class="badge-sale">-<?= (int)$p['discount_percent'] ?>%</span>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <h3 class="h5 mb-1"><?= htmlspecialchars($p['name']) ?></h3>
                    <?php if (!empty($p['discount_percent']) && (int)$p['discount_percent']>0): ?>
                        <?php $old=$p['price']; $new= round($old * (100 - (int)$p['discount_percent'])/100); ?>
                        <p class="price"><span class="old"><?= number_format($old) ?>₫</span> <span class="new"><?= number_format($new) ?>₫</span></p>
                    <?php else: ?>
                        <p class="price"><?= number_format($p['price']) ?>₫</p>
                    <?php endif; ?>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <div class="center" style="margin-top:16px">
            <a class="btn btn-outline" href="<?= BASE_URL ?>?act=san-pham">Xem thêm</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/partials/footer.php'; ?>

