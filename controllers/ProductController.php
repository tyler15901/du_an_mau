<?php
require_once '/models/ProductModel.php';
require_once '/models/CommentModel.php';

class ProductController {
    private $productModel;
    private $commentModel;

    public function __construct($pdo) {
        $this->productModel = new ProductModel($pdo);
        $this->commentModel = new CommentModel($pdo);
    }

    public function index() {
        $products = $this->productModel->getAllProducts();
        require 'app/views/products/list.php';
    }

    public function show($id) {
        $product = $this->productModel->getProductById($id);
        $comments = $this->commentModel->getCommentsByProduct($id);
        require 'app/views/products/detail.php';
    }

    public function addComment($product_id) {
        session_start();
        if (isset($_SESSION['user_id']) && !empty($_POST['content'])) {
            $user_id = $_SESSION['user_id'];
            $content = htmlspecialchars($_POST['content']);
            $this->commentModel->addComment($user_id, $product_id, $content);
        }
        header("Location: index.php?controller=product&action=show&id=" . $product_id);
        exit();
    }
}
?>