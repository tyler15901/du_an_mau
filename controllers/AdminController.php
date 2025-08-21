<?php

class AdminController
{
    private AdminModel $model;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Guard: only admin
        $user = $_SESSION['user'] ?? null;
        if (!$user || ($user['role'] ?? 'user') !== 'admin') {
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }

        $this->model = new AdminModel();
    }

    // Dashboard
    public function dashboard(): void
    {
        $title = 'Bảng điều khiển';
        $counts = $this->model->getCounts();
        include './views/admin/dashboard.php';
    }

    // Categories
    public function categories(): void
    {
        $title = 'Quản lý danh mục';
        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 10; $offset = ($page-1)*$limit;
        $total = $this->model->countCategories();
        $pages = max(1, (int)ceil($total / $limit));
        $categories = $this->model->getCategoriesPaginated($offset, $limit);
        include './views/admin/categories/index.php';
    }

    public function categoryCreate(): void
    {
        $title = 'Thêm danh mục';
        $category = [ 'name' => '', 'slug' => '' ];
        $isEdit = false;
        include './views/admin/categories/form.php';
    }

    public function categoryStore(): void
    {
        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        if ($name === '') { $name = 'Danh mục chưa đặt tên'; }
        if ($slug === '') { $slug = $this->slugify($name); }
        $this->model->createCategory($name, $slug);
        header('Location: ' . BASE_URL . '?act=admin-categories');
    }

    public function categoryEdit(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $category = $this->model->getCategory($id);
        if (!$category) { http_response_code(404); echo 'Không tìm thấy'; return; }
        $title = 'Sửa danh mục';
        $isEdit = true;
        include './views/admin/categories/form.php';
    }

    public function categoryUpdate(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        if ($name === '') { $name = 'Danh mục chưa đặt tên'; }
        if ($slug === '') { $slug = $this->slugify($name); }
        $this->model->updateCategory($id, $name, $slug);
        header('Location: ' . BASE_URL . '?act=admin-categories');
    }

    public function categoryDelete(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $this->model->deleteCategory($id);
        header('Location: ' . BASE_URL . '?act=admin-categories');
    }

    // Products
    public function products(): void
    {
        $title = 'Quản lý sản phẩm';
        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 10; $offset = ($page-1)*$limit;
        $filters = [
            'q' => trim($_GET['q'] ?? ''),
            'category_id' => $_GET['category_id'] ?? '',
            'has_discount' => isset($_GET['has_discount']) ? 1 : 0,
            'min_price' => $_GET['min_price'] ?? '',
            'max_price' => $_GET['max_price'] ?? '',
            'sort' => $_GET['sort'] ?? ''
        ];
        $total = $this->model->countProductsFiltered($filters);
        $pages = max(1, (int)ceil($total / $limit));
        $products = $this->model->getProductsFilteredPaginated($filters, $offset, $limit);
        $categories = $this->model->getCategories();
        include './views/admin/products/index.php';
    }

    public function productCreate(): void
    {
        $title = 'Thêm sản phẩm';
        $categories = $this->model->getCategories();
        $product = [
            'name' => '', 'slug' => '', 'price' => 0, 'category_id' => '',
            'discount_percent' => 0, 'description' => '', 'image' => ''
        ];
        $isEdit = false;
        include './views/admin/products/form.php';
    }

    public function productStore(): void
    {
        $data = $this->collectProductData();
        // Upload image if any
        if (!empty($_FILES['image']['name'])) {
            $path = uploadFile($_FILES['image'], 'uploads/');
            if ($path) { $data['image'] = $path; }
        }
        $this->model->createProduct($data);
        header('Location: ' . BASE_URL . '?act=admin-products');
    }

    public function productEdit(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $product = $this->model->getProduct($id);
        if (!$product) { http_response_code(404); echo 'Không tìm thấy'; return; }
        $categories = $this->model->getCategories();
        $title = 'Sửa sản phẩm';
        $isEdit = true;
        include './views/admin/products/form.php';
    }

    public function productUpdate(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        $data = $this->collectProductData();
        if (!empty($_FILES['image']['name'])) {
            $path = uploadFile($_FILES['image'], 'uploads/');
            if ($path) { $data['image'] = $path; }
        }
        $this->model->updateProduct($id, $data);
        header('Location: ' . BASE_URL . '?act=admin-products');
    }

    public function productDelete(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $this->model->deleteProduct($id);
        header('Location: ' . BASE_URL . '?act=admin-products');
    }

    public function productShow(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $product = $this->model->getProduct($id);
        if (!$product) { http_response_code(404); echo 'Không tìm thấy'; return; }
        $title = 'Chi tiết sản phẩm';
        include './views/admin/products/show.php';
    }

    // Users & Reviews: readonly
    public function users(): void
    {
        $title = 'Quản lý người dùng';
        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 10; $offset = ($page-1)*$limit;
        $total = $this->model->countUsers();
        $pages = max(1, (int)ceil($total / $limit));
        $users = $this->model->getUsersPaginated($offset, $limit);
        include './views/admin/users/index.php';
    }

    public function reviews(): void
    {
        $title = 'Quản lý bình luận';
        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 10; $offset = ($page-1)*$limit;
        $total = $this->model->countReviews();
        $pages = max(1, (int)ceil($total / $limit));
        $reviews = $this->model->getReviewsPaginated($offset, $limit);
        include './views/admin/reviews/index.php';
    }

    private function collectProductData(): array
    {
        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        if ($name === '') { $name = 'Sản phẩm chưa đặt tên'; }
        if ($slug === '') { $slug = $this->slugify($name); }
        $createdAt = trim($_POST['created_at'] ?? '');
        // Convert from input type datetime-local to MySQL DATETIME
        if ($createdAt !== '') {
            // Normalize: `YYYY-MM-DDTHH:MM` or `YYYY-MM-DD HH:MM`
            $createdAt = str_replace('T', ' ', $createdAt);
            if (strlen($createdAt) === 16) { $createdAt .= ':00'; }
        }
        return [
            'name' => $name,
            'slug' => $slug,
            'price' => (int)($_POST['price'] ?? 0),
            'category_id' => (int)($_POST['category_id'] ?? 0),
            'stock' => (int)($_POST['stock'] ?? 0),
            'discount_percent' => (int)($_POST['discount_percent'] ?? 0),
            'description' => trim($_POST['description'] ?? ''),
            'image' => $_POST['image_existing'] ?? '',
            'created_at' => $createdAt
        ];
    }

    private function slugify(string $text): string
    {
        $text = strtolower(trim($text));
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        return $text ?: 'item';
    }
}

?>


