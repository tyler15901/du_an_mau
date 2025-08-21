<?php $title = 'Liên hệ'; include __DIR__ . '/partials/header.php'; ?>

<section class="section">
    <div class="container" style="max-width:720px">
        <div class="text-center">
            <h1 class="h1">Liên hệ FPOLYSHOP</h1>
            <p class="muted">Bạn cần tư vấn về sản phẩm, đơn hàng hay chính sách? Hãy để lại thông tin, đội ngũ FPOLYSHOP sẽ phản hồi sớm nhất.</p>
        </div>
            <form class="contact-form" onsubmit="return false;">
                <div class="mb-3">
                    <input class="input form-control" placeholder="Họ và tên">
                </div>
                <div class="mb-3">
                    <input class="input form-control" placeholder="Số điện thoại">
                </div>
                <div class="mb-3">
                    <input class="input form-control" placeholder="Email">
                </div>
                <div class="mb-3">
                    <select class="input form-select">
                        <option>Chọn chủ đề</option>
                        <option>Vấn đề đơn hàng</option>
                        <option>Hỏi về sản phẩm</option>
                        <option>Góp ý</option>
                    </select>
                </div>
                <textarea class="input form-control" rows="6" placeholder="Nội dung liên hệ..."></textarea>
                <div class="center" style="padding-top:10px"><button class="btn btn-dark w-100" style="background-color:rgb(0, 0, 0); border-color:rgb(0, 0, 0);" type="submit">Gửi liên hệ</button></div>
            </form>
        
    </div>
</section>

<?php include __DIR__ . '/partials/footer.php'; ?>

