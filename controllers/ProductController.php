<?php
// Có class chứa các function thực thi xử lý logic
class ProductController
{
    public $modelProduct;
    public $modelCategory;
    public $modelUser;
    public $modelComment;
    private $pdo; // Thuộc tính private để lưu $pdo (OOP: encapsulate dependency)

    // SỬA Ở ĐÂY: Constructor nhận $pdo từ index.php (dependency injection - OOP cơ bản, giúp controller truyền $pdo cho model để connect MySQL)
    public function __construct($pdo)
    {
        $this->pdo = $pdo; // Set $pdo vào thuộc tính để dùng truyền cho model

        // Require các model (tốt để load class trước khi new)
        require_once './models/ProductModel.php';
        require_once './models/CategoryModel.php';
        require_once './models/UserModel.php';
        require_once './models/CommentModel.php';

        // SỬA Ở ĐÂY: New model và truyền $pdo vào constructor của model (dòng 16 trước đây)
        // Giúp model dùng $pdo để query MySQL an toàn (PDO prepare/execute)
        $this->modelProduct = new ProductModel($this->pdo);
        $this->modelCategory = new CategoryModel($this->pdo); // Giả sử CategoryModel cũng cần $pdo (thêm constructor tương tự nếu chưa)
        $this->modelUser = new UserModel($this->pdo); // Giả sử UserModel cần $pdo cho checkLogin, registerUser
        $this->modelComment = new CommentModel($this->pdo); // Giả sử CommentModel cần $pdo cho getAllComments
    }

    public function showHomePage()
    {
        $title = "Chào mừng đến với cửa hàng thời trang nam";
        $thoiTiet = "Hôm nay trời đẹp, phù hợp để mua sắm!";
        $products = $this->modelProduct->getAllProducts(); // Lấy data từ model (bây giờ dùng $pdo để query MySQL)
        $sliderItems = [
            ['image' => 'https://via.placeholder.com/1200x300', 'alt' => 'Slider 1', 'title' => 'Sản phẩm mới', 'description' => 'Khám phá ngay!'],
            ['image' => 'https://via.placeholder.com/1200x300', 'alt' => 'Slider 2', 'title' => 'Ưu đãi đặc biệt', 'description' => 'Giảm giá hôm nay!'],
        ];
        require_once './views/home.php'; // Load view, pass $products để hiển thị với Bootstrap (style đen trắng qua CSS)
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
        $errorMessage = "";
        require_once './views/login.php';
    }

    // Xử lý đăng nhập với validation
    public function login()
    {
        $errorMessage = "";
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Validation: Kiểm tra không trống và email hợp lệ
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = "Email không hợp lệ!";
        } elseif (empty($password)) {
            $errorMessage = "Mật khẩu không được trống!";
        } else {
            $user = $this->modelUser->checkLogin($email, $password); // Gọi model, giờ dùng $pdo
            if ($user) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                header("Location: index.php");
                exit();
            } else {
                $errorMessage = "Email hoặc mật khẩu không đúng!";
            }
        }

        $title = "Đăng nhập";
        require_once './views/login.php'; // Require lại view với $errorMessage
    }

    // Hiển thị trang đăng ký (đã có, thêm $errorMessage nếu có lỗi)
    public function showRegisterPage()
    {
        $title = "Đăng ký";
        $errorMessage = "";
        $successMessage = "";
        require_once './views/register.php';
    }

    // Xử lý đăng ký với validation
    public function register()
    {
        $errorMessage = "";
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        // Validation: Kiểm tra không trống, email hợp lệ, mật khẩu khớp và >6 ký tự, email chưa tồn tại
        if (empty($name)) {
            $errorMessage = "Tên không được trống!";
        } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = "Email không hợp lệ!";
        } elseif (empty($password) || strlen($password) < 6) {
            $errorMessage = "Mật khẩu phải ít nhất 6 ký tự!";
        } elseif ($password != $confirm_password) {
            $errorMessage = "Mật khẩu không khớp!";
        } else {
            // Kiểm tra email tồn tại
            if ($this->modelUser->checkEmailExists($email)) { // Hàm mới trong model, cần thêm nếu chưa
                $errorMessage = "Email đã tồn tại!";
            } else {
                if ($this->modelUser->registerUser($name, $email, $password)) { // Gọi model, giờ dùng $pdo để insert
                    $successMessage = "Đăng ký thành công!";
                    header("Location: index.php?act=login");
                    exit();
                } else {
                    $errorMessage = "Lỗi đăng ký, thử lại!";
                }
            }
        }

        $title = "Đăng ký";
        require_once './views/register.php'; // Require lại view với $errorMessage
    }

    // Comment phần code mẫu cho showProductsPage với search/filter (bạn có thể uncomment khi cần)
    // public function showProductsPage()
    // {
    //     $title = "Danh sách sản phẩm thời trang nam";
    //     $search = $_GET['search'] ?? ''; // Lấy param search từ GET
    //     $category = $_GET['category'] ?? ''; // Lấy param category
    //     $price_range = $_GET['price_range'] ?? 'all'; // Lấy param price range
    //     $products = $this->modelProduct->getAllProducts($search, $category, $price_range); // Gọi hàm getAllProducts với param
    //     $categories = $this->modelCategory->getAllCategories();
    //     require_once './views/products.php';
    // }
}
?>