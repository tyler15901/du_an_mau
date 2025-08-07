<?php
// Có class chứa các function thực thi xử lý logic cho admin
class AdminController
{
    public $modelAdmin;
    public $modelCategory;
    public $modelProduct;
    public $modelUser;
    public $modelComment;

    public function __construct()
    {
        $this->modelAdmin = new AdminModel();
        $this->modelCategory = new CategoryModel();
        $this->modelProduct = new ProductModel();
        $this->modelUser = new UserModel();
        $this->modelComment = new CommentModel();
    }

    // ... (các function khác giữ nguyên)

    // Hiển thị danh sách sản phẩm (đã có, thêm liên kết xem chi tiết nếu cần)
    public function manageProducts()
    {
        $title = "Quản lý sản phẩm";
        $products = $this->modelProduct->getAllProducts();
        require_once './views/admin/products.php';
    }

    // Thêm sản phẩm
    public function addProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? 0;
            $category_id = $_POST['category_id'] ?? '';
            $description = $_POST['description'] ?? '';
            $image = uploadFile($_FILES['image'], 'uploads/products/'); // Sử dụng hàm uploadFile từ commons/function.php

            // Lưu vào CSDL qua model
            if ($this->modelProduct->addProduct($name, $price, $category_id, $description, $image)) {
                header("Location: index.php?act=admin-products");
                exit();
            }
        }
        $title = "Thêm sản phẩm";
        $categories = $this->modelCategory->getAllCategories();
        require_once './views/admin/add-product.php';
    }

    // Sửa sản phẩm
    public function editProduct($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? 0;
            $category_id = $_POST['category_id'] ?? '';
            $description = $_POST['description'] ?? '';
            $image = $product['image']; // Giữ ảnh cũ nếu không upload mới
            if (!empty($_FILES['image']['name'])) {
                deleteFile($product['image']); // Xóa ảnh cũ nếu có
                $image = uploadFile($_FILES['image'], 'uploads/products/');
            }

            // Cập nhật qua model
            if ($this->modelProduct->updateProduct($id, $name, $price, $category_id, $description, $image)) {
                header("Location: index.php?act=admin-products");
                exit();
            }
        }
        $title = "Sửa sản phẩm";
        $product = $this->modelProduct->getProductById($id);
        $categories = $this->modelCategory->getAllCategories();
        require_once './views/admin/edit-product.php';
    }

    // Xóa sản phẩm
    public function deleteProduct($id)
    {
        $product = $this->modelProduct->getProductById($id);
        if ($product) {
            deleteFile($product['image']); // Xóa ảnh nếu có
            $this->modelProduct->deleteProduct($id); // Xóa từ model
        }
        header("Location: index.php?act=admin-products");
        exit();
    }

    // Xem chi tiết sản phẩm
    public function viewProduct($id)
    {
        $title = "Xem chi tiết sản phẩm";
        $product = $this->modelProduct->getProductById($id);
        require_once './views/admin/view-product.php';
    }
}