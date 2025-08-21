<?php
// có class chứa các function thực thi xử lý logic 
class ProductController
{
    public $modelProduct;

    public function __construct()
    {
        $this->modelProduct = new ProductModel();
    }

    public function Home()
    {
        $title = "FPOLYSHOP";
        $featuredProducts = $this->modelProduct->getFeaturedProducts(6);
        $categories = $this->modelProduct->getCategories();
        $newProducts = $this->modelProduct->getNewProducts(30);
        $promoProducts = $this->modelProduct->getPromotionProducts(8);
        $slides = [
            'uploads/img-banner/slide1.jpg',
            'uploads/img-banner/slide2.jpg',
            'uploads/img-banner/slide3.jpg',
        ];
        $banner = 'uploads/img-banner/banner.jpg';
        require_once './views/home.php';
    }

    public function ListProduct()
    {
        $tag = $_GET['tag'] ?? null;
        $q = trim($_GET['q'] ?? '');
        $sort = $_GET['sort'] ?? '';
        $min_price = $_GET['min_price'] ?? '';
        $max_price = $_GET['max_price'] ?? '';

        $promo = $_GET['promo'] ?? '';
        $opts = compact('tag','q','sort','min_price','max_price','promo');
        $products = $this->modelProduct->getFilteredProducts($opts);
        $title = $tag ? match ($tag) {
            'ao-phong' => 'Áo phông',
            'ao-so-mi' => 'Áo sơ mi',
            'ao-khoac' => 'Áo khoác',
            'quan-dai' => 'Quần dài',
            'quan-ngan' => 'Quần ngắn',
            'phu-kien' => 'Phụ kiện',
            default => 'Sản phẩm',
        } : ($q !== '' ? 'Kết quả tìm kiếm' : 'Sản phẩm');
        $keyword = $q; // để view có thể hiển thị
        require_once './views/products/index.php';
    }

    public function Detail()
    {
        $slug = $_GET['slug'] ?? '';
        $product = $this->modelProduct->getProductBySlug($slug);
        if (!$product) {
            http_response_code(404);
            echo "Sản phẩm không tồn tại";
            return;
        }
        // Lấy reviews
        $reviews = $this->modelProduct->getReviewsByProduct((int)$product['id']);
        $related = $this->modelProduct->getRelatedProducts($product['category_id'], $product['id']);
        require_once './views/products/detail.php';
    }

    public function PostReview()
    {
        $productId = (int)($_POST['product_id'] ?? 0);
        $comment = trim($_POST['comment'] ?? '');
        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            $_SESSION['auth_error'] = 'Vui lòng đăng nhập để bình luận';
            header('Location: ' . BASE_URL . '?act=login');
            return;
        }
        if ($productId <= 0 || $comment === '') {
            header('Location: ' . BASE_URL . '?act=chi-tiet-san-pham&slug=' . urlencode($_POST['slug'] ?? ''));
            return;
        }
        $this->modelProduct->addReview($productId, (int)$user['id'], $comment);
        header('Location: ' . BASE_URL . '?act=chi-tiet-san-pham&slug=' . urlencode($_POST['slug'] ?? ''));
    }

    public function Contact()
    {
        $title = "Liên hệ";
        require_once './views/contact.php';
    }

    public function About()
    {
        $title = "Về chúng tôi";
        require_once './views/about.php';
    }

    public function NewProducts()
    {
        $title = 'Sản phẩm mới';
        $products = $this->modelProduct->getNewProducts(30);
        require_once './views/products/index.php';
    }

    public function Search()
    {
        $q = urlencode(trim($_GET['q'] ?? ''));
        header('Location: ' . BASE_URL . '?act=san-pham&q=' . $q);
        exit;
    }
}
