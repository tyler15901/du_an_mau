<?php 
// Set title theo tag nếu có, giữ nguyên nếu controller đã đặt (vd: Sản phẩm mới)
$currentTag = $_GET['tag'] ?? null;
if (!isset($title)) { $title = 'Sản phẩm'; }
if ($currentTag) {
    $mapTitle = [
        'ao-phong' => 'Áo phông',
        'ao-so-mi' => 'Áo sơ mi',
        'ao-khoac' => 'Áo khoác',
        'quan-dai' => 'Quần dài',
        'quan-ngan' => 'Quần ngắn',
        'phu-kien' => 'Phụ kiện',
    ];
    $title = $mapTitle[$currentTag] ?? $title;
}
include __DIR__ . '/../partials/header.php'; ?>


<section class="section">
    <div class="container">
        <div class="row" style="display:grid;grid-template-columns:260px 1fr;gap:24px">
            <aside>
                <form method="get" action="">
                    <input type="hidden" name="act" value="san-pham" />
                    <?php if (!empty($_GET['tag'])): ?><input type="hidden" name="tag" value="<?= htmlspecialchars($_GET['tag']) ?>" /><?php endif; ?>
                    <h3 class="h5">Lọc sản phẩm</h3>
                    <div class="mb-3">
                        <label class="form-label">Từ khóa</label>
                        <input type="text" name="q" class="form-control" value="<?= htmlspecialchars($keyword ?? '') ?>" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Khoảng giá</label>
                        <?php 
                            $min = (int)($_GET['min_price'] ?? 0);
                            $max = (int)($_GET['max_price'] ?? 3000000);
                        ?>
                        <div class="price-range">
                            <div class="range-slider">
                                <div class="track"></div>
                                <input type="range" min="0" max="3000000" step="10000" value="<?= $min ?>" name="min_price" oninput="document.getElementById('minPrice').innerText=this.value.toLocaleString('vi-VN')+'₫'" />
                                <input type="range" min="0" max="3000000" step="10000" value="<?= $max ?>" name="max_price" oninput="document.getElementById('maxPrice').innerText=this.value.toLocaleString('vi-VN')+'₫'" />
                            </div>
                            <div class="range-row">
                                <span id="minPrice"><?= number_format($min,0,',','.') ?>₫</span>
                                <span id="maxPrice"><?= number_format($max,0,',','.') ?>₫</span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sắp xếp</label>
                        <select name="sort" class="form-select">
                            <option value="">Mặc định</option>
                            <option value="name_asc" <?= (($_GET['sort'] ?? '')==='name_asc')?'selected':'' ?>>Tên A → Z</option>
                            <option value="name_desc" <?= (($_GET['sort'] ?? '')==='name_desc')?'selected':'' ?>>Tên Z → A</option>
                            <option value="price_asc" <?= (($_GET['sort'] ?? '')==='price_asc')?'selected':'' ?>>Giá tăng dần</option>
                            <option value="price_desc" <?= (($_GET['sort'] ?? '')==='price_desc')?'selected':'' ?>>Giá giảm dần</option>
                            <option value="oldest" <?= (($_GET['sort'] ?? '')==='oldest')?'selected':'' ?>>Cũ nhất</option>
                            <option value="newest" <?= (($_GET['sort'] ?? '')==='newest')?'selected':'' ?>>Mới nhất</option>
                        </select>
                    </div>
                    <button class="btn btn-dark w-100">Áp dụng</button>
                </form>
            </aside>
            <div>
                <div class="d-flex justify-content-between align-items-end mb-2" style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:8px">
                    <h2 class="h1 m-0"><?= htmlspecialchars($title) ?></h2>
                </div>
                <div class="grid cards">
            <?php foreach ($products as $p): ?>
            <a class="card shadow-sm" href="<?= BASE_URL ?>?act=chi-tiet-san-pham&slug=<?= urlencode($p['slug']) ?>">
                <div class="card-img" style="background-image:url('<?= BASE_URL . htmlspecialchars($p['image']) ?>')">
                    <?php if (!empty($p['discount_percent']) && (int)$p['discount_percent']>0): ?>
                        <span class="badge-sale">-<?= (int)$p['discount_percent'] ?>%</span>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <h3 class="h5 mb-1"><?= htmlspecialchars($p['name']) ?></h3>
                    <p class="muted small mb-2"><?= htmlspecialchars($p['category_name']) ?></p>
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
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../partials/footer.php'; ?>

