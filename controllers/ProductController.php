<?php 
// Comment: Class Controller cho sản phẩm và trang chủ, xử lý logic.
class ProductController {
    public $modelProduct;
    public $modelCategory;
    public $modelBanner;

    public function __construct() {
        $this->modelProduct = new ProductModel(); // Khởi tạo Model sản phẩm.
        $this->modelCategory = new CategoryModel(); // Khởi tạo Model danh mục.
        $this->modelBanner = new BannerModel(); // Khởi tạo Model banner.
    }

    // Comment: Method home() để load trang chủ, lấy data từ Models và pass vào View.
    public function home() {
        $title = "Trang Chủ - Thời Trang Nam"; // Tiêu đề trang.
        $menu = $this->modelCategory->getMenuWithSub(); // Lấy menu/submenu.
        $banners = $this->modelBanner->getBanners(); // Lấy banner.
        $mainCategories = $this->modelCategory->getMainCategories(); // Lấy danh mục carousel.
        $promotionProducts = $this->modelProduct->getPromotionProducts(); // Lấy sản phẩm khuyến mãi.
        $featuredProducts = $this->modelProduct->getFeaturedProducts(); // Lấy sản phẩm nổi bật.

        require_once './views/trangchu.php'; // Require View trang chủ, data được pass qua variables.
    }
}