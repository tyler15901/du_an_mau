<?php
// Có class chứa các function thực thi xử lý logic
class ProductController
{
    public $modelProduct;
    public $modelCategory;
    public $modelUser;
    public $modelComment;

    public function __construct()
    {
        require_once './models/ProductModel.php';
        require_once './models/CategoryModel.php';
        require_once './models/UserModel.php';
        require_once './models/CommentModel.php';
        $this->modelProduct = new ProductModel();
        $this->modelCategory = new CategoryModel();
        $this->modelUser = new UserModel();
        $this->modelComment = new CommentModel();
    }

    public function showHomePage()
    {
        $title = "Chào mừng đến với cửa hàng thời trang nam";
        $thoiTiet = "Hôm nay trời đẹp, phù hợp để mua sắm!";
        $products = $this->modelProduct->getAllProducts();
        $sliderItems = [
            ['image' => 'https://via.placeholder.com/1200x300', 'alt' => 'Slider 1', 'title' => 'Sản phẩm mới', 'description' => 'Khám phá ngay!'],
            ['image' => 'https://via.placeholder.com/1200x300', 'alt' => 'Slider 2', 'title' => 'Ưu đãi đặc biệt', 'description' => 'Giảm giá hôm nay!'],
        ];
        require_once './views/home.php';
    }

    public function showProductsPage()
    {
        $title = "Danh sách sản phẩm thời trang nam";
        $products = $this->modelProduct->getAllProducts();
        $categories = $this->modelCategory->getAllCategories();
        require_once './views/products.php';
    }

    public function showProductDetail($id)
    {
        $title = "Chi tiết sản phẩm";
        $product = $this->modelProduct->getProductById($id);
        $relatedProducts = $this->modelProduct->getRelatedProducts($product['category_id'] ?? 1, $id);
        $comments = $this->modelComment->getAllComments(); // Cần lọc theo product_id trong thực tế
        require_once './views/product-detail.php';
    }

    public function showContactPage()
    {
        $title = "Liên hệ với chúng tôi";
        $successMessage = isset($_GET['success']) ? "Gửi liên hệ thành công!" : "";
        require_once './views/contact.php';
    }

    public function sendContact()
    {
        // Xử lý form liên hệ (cần lưu vào CSDL)
        $title = "Liên hệ với chúng tôi";
        $successMessage = "Gửi liên hệ thành công!";
        header("Location: index.php?act=contact&success=1");
        exit();
    }

    public function showAboutPage()
    {
        $title = "Về chúng tôi";
        require_once './views/about.php';
    }

    public function showLoginPage()
    {
        $title = "Đăng nhập";
        $errorMessage = isset($_GET['error']) ? "Email hoặc mật khẩu không đúng!" : "";
        require_once './views/login.php';
    }

    public function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $user = $this->modelUser->checkLogin($email, $password);
        if ($user) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: index.php");
        } else {
            header("Location: index.php?act=login&error=1");
        }
        exit();
    }

    public function showRegisterPage()
    {
        $title = "Đăng ký";
        $errorMessage = isset($_GET['error']) ? "Email đã tồn tại!" : "";
        $successMessage = isset($_GET['success']) ? "Đăng ký thành công!" : "";
        require_once './views/register.php';
    }

    public function register()
    {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        if ($password === $confirmPassword) {
            $existingUser = $this->modelUser->checkLogin($email, $password);
            if (!$existingUser) {
                if ($this->modelUser->registerUser($name, $email, $password)) {
                    header("Location: index.php?act=login&success=1");
                } else {
                    header("Location: index.php?act=register&error=1");
                }
            } else {
                header("Location: index.php?act=register&error=1");
            }
        } else {
            header("Location: index.php?act=register&error=1");
        }
        exit();
    }
}