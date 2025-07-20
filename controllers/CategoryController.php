<?php 
// Comment: Class Controller cho danh mục, xử lý hiển thị sản phẩm theo category slug.
class CategoryController {
    public $modelProduct;
    public $modelCategory;

    public function __construct() {
        $this->modelProduct = new ProductModel();
        $this->modelCategory = new CategoryModel();
    }

    // Comment: Method show() để hiển thị sản phẩm theo slug danh mục (gọi từ route /category/[slug]).
    public function show($slug) {
        $category = $this->modelCategory->getCategoryBySlug($slug); // Giả sử method getCategoryBySlug() trong Model (thêm nếu cần: SELECT * FROM categories WHERE slug = :slug).
        $products = $this->modelProduct->getProductsByCategory($category['id']); // Giả sử method getProductsByCategory() query SELECT * FROM products WHERE category_id = :id.

        require_once './views/category.php'; // Require View trang danh mục (tạo file mới nếu cần, tương tự trangchu.php nhưng hiển thị grid products).
    }
}