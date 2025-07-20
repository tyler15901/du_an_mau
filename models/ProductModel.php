<?php
// Comment: Class Model cho sản phẩm, tương tác với bảng products trong MySQL.
class ProductModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB(); // Kết nối DB.
    }

    // Comment: Lấy tất cả sản phẩm (mở rộng từ placeholder của bạn).
    public function getAllProduct()
    {
        $stmt = $this->conn->prepare("SELECT * FROM products");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Comment: Thêm try-catch trong method getPromotionProducts().
    public function getPromotionProducts()
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM products WHERE promotion_price > 0 AND promotion_end_date > NOW() LIMIT 4");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Lỗi query sản phẩm khuyến mãi: " . $e->getMessage());
            return [];
        }
    }

    // Comment: Lấy sản phẩm nổi bật (sắp xếp theo views DESC).
    public function getFeaturedProducts()
    {
        $stmt = $this->conn->prepare("SELECT * FROM products ORDER BY views DESC LIMIT 4");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function addToCart() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $productId = $_POST['product_id']; // Lấy ID sản phẩm từ POST.
            // Comment: Logic thêm vào giỏ hàng (session['cart'] là array, key = product_id, value = quantity).
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId]++; // Tăng quantity nếu đã có.
            } else {
                $_SESSION['cart'][$productId] = 1; // Thêm mới với quantity 1.
            }
            echo json_encode(['success' => true, 'cart_count' => array_sum($_SESSION['cart'])]); // Tổng số lượng giỏ hàng.
        }
    }
}
