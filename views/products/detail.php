<?php $title = htmlspecialchars($product['name']); include __DIR__ . '/../partials/header.php'; ?>

<section class="section">
    <div class="container product-detail">
        <div class="gallery">
            <div class="ratio-1x1" style="background-image:url('<?= BASE_URL . htmlspecialchars($product['image']) ?>'); position:relative">
                <?php if (!empty($product['discount_percent']) && (int)$product['discount_percent'] > 0): ?>
                    <span class="badge-sale">-<?= (int)$product['discount_percent'] ?>%</span>
                <?php endif; ?>
            </div>
        </div>
        <div class="summary">
            <h1 class="h2 mb-1"><?= htmlspecialchars($product['name']) ?></h1>
            
            <p class="muted" style="margin:6px 0 12px">
                Trạng thái: 
                <?php if ((int)$product['stock'] > 0): ?>
                    <span style="color:#2e7d32">Còn hàng</span>
                <?php else: ?>
                    <span style="color:#c62828">Hết hàng</span>
                <?php endif; ?>
            </p>
            <?php if (!empty($product['discount_percent']) && (int)$product['discount_percent'] > 0): ?>
                <?php $old=$product['price']; $new= round($old * (100 - (int)$product['discount_percent'])/100); ?>
                <p class="price lg" style="margin:6px 0 12px"><span class="old"><?= number_format($old) ?>₫</span> <span class="new"><?= number_format($new) ?>₫</span></p>
            <?php else: ?>
                <p class="price lg" style="margin:6px 0 12px"><?= number_format($product['price']) ?>₫</p>
            <?php endif; ?>
            <label>Số lượng</label>
            <input type="number" class="input form-control" value="1" min="1" style="max-width:140px">
            <div style="display:flex; gap:10px; margin-top:12px">
                <button class="btn btn-outline">Thêm vào giỏ hàng</button>
                <button class="btn btn-dark">Mua ngay</button>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="tabs">
            <div class="tabs-nav">
                <a href="#" class="active" data-tab="tab-desc">Mô tả sản phẩm</a>
                <a href="#" data-tab="tab-review">Đánh giá - Nhận xét từ khách hàng</a>
            </div>
            <div id="tab-desc" class="tab-pane active">
                <p><?= nl2br(htmlspecialchars($product['description'] ?? 'Đang cập nhật.')) ?></p>
            </div>
            <div id="tab-review" class="tab-pane">
                <?php if (!empty($reviews)): ?>
                    <?php foreach ($reviews as $r): ?>
                        <div style="border-top:1px solid #eee;padding:10px 0">
                            <strong><?= htmlspecialchars($r['user_name']) ?></strong>
                            <div class="muted small"><?= htmlspecialchars($r['created_at']) ?></div>
                            <div><?= nl2br(htmlspecialchars($r['comment'])) ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="muted">Chưa có đánh giá nào.</p>
                <?php endif; ?>
                <form method="post" action="<?= BASE_URL ?>?act=post-review" style="margin-top:10px">
                    <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
                    <input type="hidden" name="slug" value="<?= htmlspecialchars($product['slug']) ?>">
                    <label class="form-label">Viết bình luận</label>
                    <textarea class="form-control" name="comment" rows="3" placeholder="Nội dung bình luận..." required></textarea>
                    <button class="btn btn-dark" style="margin-top:8px">Gửi bình luận</button>
                </form>
            </div>
        </div>

        <h2 style="margin-top:24px">Sản phẩm liên quan</h2>
        <div class="grid cards">
            <?php foreach ($related as $p): ?>
            <a class="card" href="<?= BASE_URL ?>?act=chi-tiet-san-pham&slug=<?= urlencode($p['slug']) ?>">
                <div class="card-img" style="background-image:url('<?= BASE_URL . htmlspecialchars($p['image']) ?>')"></div>
                <div class="card-body">
                    <h4 class="h6 mb-1"><?= htmlspecialchars($p['name']) ?></h4>
                    <p class="price"><?= number_format($p['price']) ?>₫</p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function(){
  var links = document.querySelectorAll('.tabs-nav a');
  links.forEach(function(link){
    link.addEventListener('click', function(e){
      e.preventDefault();
      links.forEach(function(l){ l.classList.remove('active'); });
      document.querySelectorAll('.tab-pane').forEach(function(p){ p.classList.remove('active'); });
      link.classList.add('active');
      var pane = document.getElementById(link.getAttribute('data-tab'));
      if (pane) pane.classList.add('active');
    });
  });
});
</script>


<?php include __DIR__ . '/../partials/footer.php'; ?>

