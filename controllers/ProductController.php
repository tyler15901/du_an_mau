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
        $products = $this->modelProduct->getFeaturedProducts(8); // Lấy sản phẩm nổi bật
        $categories = $this->modelCategory->getAllCategories();
        $sliderItems = [
            ['image' => 'https://via.placeholder.com/1200x300', 'alt' => 'Slider 1', 'title' => 'Sản phẩm mới', 'description' => 'Khám phá ngay!'],
            ['image' => 'https://via.placeholder.com/1200x300', 'alt' => 'Slider 2', 'title' => 'Ưu đãi đặc biệt', 'description' => 'Giảm giá hôm nay!'],
        ];
        require_once './views/home.php'; // Load view, pass $products để hiển thị với Bootstrap (style đen trắng qua CSS)
    }

    public function showProductsPage()
    {
        $title = "Danh sách sản phẩm thời trang nam";
        $search = $_GET['search'] ?? '';
        $category = $_GET['category'] ?? '';
        $price_range = $_GET['price_range'] ?? 'all';
        $page = max(1, intval($_GET['page'] ?? 1));
        $itemsPerPage = 12;
        $offset = getOffset($page, $itemsPerPage);
        
        // Lấy sản phẩm với filter và pagination
        $products = $this->modelProduct->getProductsWithFilter($search, $category, $price_range, $itemsPerPage, $offset);
        $categories = $this->modelCategory->getAllCategories();
        $totalProducts = $this->modelProduct->getTotalProducts($search, $category);
        $pagination = createPagination($totalProducts, $itemsPerPage, $page, "index.php?act=products&search=$search&category=$category&price_range=$price_range");
        
        require_once './views/product.php';
    }

    public function showProductDetail($id)
    {
        $title = "Chi tiết sản phẩm";
        $product = $this->modelProduct->getProductById($id);
        
        if (!$product) {
            header("Location: index.php?act=products");
            exit();
        }
        
        $relatedProducts = $this->modelProduct->getRelatedProducts($product['category_id'], $id);
        $comments = $this->modelComment->getCommentsByProduct($id);
        require_once './views/product_detail.php';
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
        session_start();
        $title = "Đăng nhập";
        $errorMessage = "";
        require_once './views/login.php';
    }

    // Xử lý đăng nhập với validation
    public function login()
    {
        session_start();
        $errorMessage = "";
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Validation: Kiểm tra không trống và email hợp lệ
        if (empty($email) || !validateEmail($email)) {
            $errorMessage = "Email không hợp lệ!";
        } elseif (empty($password)) {
            $errorMessage = "Mật khẩu không được trống!";
        } else {
            $user = $this->modelUser->checkLogin($email, $password);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['ho_ten'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = 'user'; // Mặc định là user
                
                // Kiểm tra nếu là admin (email admin@example.com)
                if ($user['email'] === 'admin@example.com') {
                    $_SESSION['user_role'] = 'admin';
                    header("Location: index.php?act=admin-dashboard");
                } else {
                    header("Location: index.php");
                }
                exit();
            } else {
                $errorMessage = "Email hoặc mật khẩu không đúng!";
            }
        }

        $title = "Đăng nhập";
        require_once './views/login.php';
    }

    // Hiển thị trang đăng ký
    public function showRegisterPage()
    {
        session_start();
        $title = "Đăng ký";
        $errorMessage = "";
        $successMessage = "";
        require_once './views/register.php';
    }

    // Xử lý đăng ký với validation
    public function register()
    {
        session_start();
        $errorMessage = "";
        $ho_ten = $_POST['ho_ten'] ?? '';
        $gioi_tinh = $_POST['gioi_tinh'] ?? '';
        $ngay_sinh = $_POST['ngay_sinh'] ?? '';
        $email = $_POST['email'] ?? '';
        $mat_khau = $_POST['mat_khau'] ?? '';
        $xac_nhan_mat_khau = $_POST['xac_nhan_mat_khau'] ?? '';

        // Validation
        if (empty($ho_ten)) {
            $errorMessage = "Họ tên không được trống!";
        } elseif (empty($gioi_tinh)) {
            $errorMessage = "Vui lòng chọn giới tính!";
        } elseif (empty($ngay_sinh)) {
            $errorMessage = "Ngày sinh không được trống!";
        } elseif (empty($email) || !validateEmail($email)) {
            $errorMessage = "Email không hợp lệ!";
        } elseif (empty($mat_khau) || !validatePassword($mat_khau)) {
            $errorMessage = "Mật khẩu phải ít nhất 6 ký tự!";
        } elseif ($mat_khau != $xac_nhan_mat_khau) {
            $errorMessage = "Mật khẩu không khớp!";
        } else {
            // Kiểm tra email tồn tại
            if ($this->modelUser->emailExists($email)) {
                $errorMessage = "Email đã tồn tại!";
            } else {
                $userData = [
                    'ho_ten' => $ho_ten,
                    'gioi_tinh' => $gioi_tinh,
                    'ngay_sinh' => $ngay_sinh,
                    'email' => $email,
                    'mat_khau' => $mat_khau
                ];
                
                if ($this->modelUser->registerUser($userData)) {
                    header("Location: index.php?act=login&success=1");
                    exit();
                } else {
                    $errorMessage = "Lỗi đăng ký, thử lại!";
                }
            }
        }

        $title = "Đăng ký";
        require_once './views/register.php';
    }

    // Xử lý đăng xuất
    public function logout()
    {
        session_start();
        session_destroy();
        header("Location: index.php");
        exit();
    }

    // Xử lý giỏ hàng
    public function showCart()
    {
        session_start();
        if (!isLoggedIn()) {
            header("Location: index.php?act=login");
            exit();
        }
        
        $title = "Giỏ hàng";
        // Logic xử lý giỏ hàng sẽ được thêm sau
        require_once './views/cart.php';
    }

    // Xử lý yêu thích
    public function showWishlist()
    {
        session_start();
        if (!isLoggedIn()) {
            header("Location: index.php?act=login");
            exit();
        }
        
        $title = "Sản phẩm yêu thích";
        // Logic xử lý yêu thích sẽ được thêm sau
        require_once './views/wishlist.php';
    }

    // Xử lý hồ sơ
    public function showProfile()
    {
        session_start();
        if (!isLoggedIn()) {
            header("Location: index.php?act=login");
            exit();
        }
        
        $title = "Hồ sơ cá nhân";
        $user = $this->modelUser->getUserById($_SESSION['user_id']);
        require_once './views/profile.php';
    }

    // Xử lý đơn hàng
    public function showOrders()
    {
        session_start();
        if (!isLoggedIn()) {
            header("Location: index.php?act=login");
            exit();
        }
        
        $title = "Đơn hàng của tôi";
        // Logic xử lý đơn hàng sẽ được thêm sau
        require_once './views/orders.php';
    }

    // Thêm bình luận
    public function addComment()
    {
        session_start();
        if (!isLoggedIn()) {
            header("Location: index.php?act=login");
            exit();
        }
        
        $product_id = $_POST['product_id'] ?? 0;
        $comment = $_POST['comment'] ?? '';
        
        if (empty($comment)) {
            header("Location: index.php?act=product-detail&id=$product_id&error=empty_comment");
            exit();
        }
        
        if ($this->modelComment->addComment($product_id, $_SESSION['user_id'], $comment)) {
            header("Location: index.php?act=product-detail&id=$product_id&success=1");
        } else {
            header("Location: index.php?act=product-detail&id=$product_id&error=1");
        }
        exit();
    }
}
?>