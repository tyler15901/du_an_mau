<?php
// Kiểm tra session hoặc dữ liệu từ controller
$title = $title ?? "Về chúng tôi";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Tùy chỉnh phong cách đen trắng */
        body {
            background-color: #000000; /* Nền đen */
            color: #FFFFFF; /* Chữ trắng */
        }
        .navbar {
            background-color: #333333; /* Navbar tối hơn */
        }
        .about-section {
            background-color: #1a1a1a; /* Nền section màu xám đậm */
            padding: 20px;
            border: 1px solid #555555; /* Viền xám */
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php include 'layouts/header.php'; ?>

    <!-- About Section -->
    <div class="container mt-4">
        <div class="about-section">
            <h2>Về chúng tôi</h2>
            <p>
                Chào mừng bạn đến với cửa hàng thời trang nam của chúng tôi! Chúng tôi tự hào là địa chỉ uy tín chuyên cung cấp các sản phẩm thời trang nam cao cấp, từ áo sơ mi, quần jeans đến phụ kiện sang trọng. Với sứ mệnh mang đến phong cách hiện đại và đẳng cấp cho mọi quý ông, chúng tôi cam kết chất lượng sản phẩm và dịch vụ tốt nhất.
            </p>
            <p>
                Thành lập vào năm 2020, chúng tôi đã không ngừng phát triển để đáp ứng nhu cầu ngày càng cao của khách hàng. Đội ngũ của chúng tôi bao gồm những nhà thiết kế và chuyên gia thời trang giàu kinh nghiệm, luôn cập nhật xu hướng mới nhất từ khắp nơi trên thế giới.
            </p>
            <h4>Giá trị cốt lõi</h4>
            <ul>
                <li>Chất lượng vượt trội</li>
                <li>Dịch vụ khách hàng tận tâm</li>
                <li>Thời trang bền vững</li>
            </ul>
            <p>
                Hãy ghé thăm cửa hàng của chúng tôi hoặc liên hệ qua <a href="index.php?act=contact" style="color: #CCCCCC;">trang liên hệ</a> để biết thêm thông tin. Cảm ơn bạn đã đồng hành cùng chúng tôi!
            </p>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'layouts/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>