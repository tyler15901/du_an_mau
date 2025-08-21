<?php

class AdminModel
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getCounts(): array
    {
        $tables = ['products','categories','users','reviews'];
        $data = [];
        foreach ($tables as $t) {
            $stmt = $this->conn->query("SELECT COUNT(*) FROM {$t}");
            $data[$t] = (int)$stmt->fetchColumn();
        }
        return $data;
    }

    // Categories
    public function getCategories(): array
    {
        return $this->conn->query("SELECT * FROM categories ORDER BY id ASC")->fetchAll();
    }
    public function getCategoriesPaginated(int $offset, int $limit): array
    {
        $stmt = $this->conn->prepare('SELECT * FROM categories ORDER BY id ASC LIMIT :limit OFFSET :offset');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function countCategories(): int
    {
        return (int)$this->conn->query('SELECT COUNT(*) FROM categories')->fetchColumn();
    }
    public function getCategory(int $id)
    {
        $stmt = $this->conn->prepare('SELECT * FROM categories WHERE id=:id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function createCategory(string $name, string $slug): bool
    {
        $stmt = $this->conn->prepare('INSERT INTO categories (name, slug) VALUES (:n,:s)');
        $stmt->bindValue(':n', $name);
        $stmt->bindValue(':s', $slug);
        return $stmt->execute();
    }
    public function updateCategory(int $id, string $name, string $slug): bool
    {
        $stmt = $this->conn->prepare('UPDATE categories SET name=:n, slug=:s WHERE id=:id');
        $stmt->bindValue(':n', $name);
        $stmt->bindValue(':s', $slug);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function deleteCategory(int $id): bool
    {
        $stmt = $this->conn->prepare('DELETE FROM categories WHERE id=:id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Products
    public function getProducts(): array
    {
        $sql = 'SELECT p.*, c.name AS category_name FROM products p INNER JOIN categories c ON p.category_id=c.id ORDER BY p.id ASC';
        return $this->conn->query($sql)->fetchAll();
    }
    public function getProductsPaginated(int $offset, int $limit): array
    {
        $sql = 'SELECT p.*, c.name AS category_name FROM products p INNER JOIN categories c ON p.category_id=c.id ORDER BY p.id ASC LIMIT :limit OFFSET :offset';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function countProducts(): int
    {
        return (int)$this->conn->query('SELECT COUNT(*) FROM products')->fetchColumn();
    }

    public function countProductsFiltered(array $opts): int
    {
        [$sql,$params] = $this->buildProductsFilterSql('COUNT(*) AS cnt', $opts);
        $stmt = $this->conn->prepare($sql);
        foreach($params as $k=>$v){
            $stmt->bindValue($k,$v,is_int($v)?PDO::PARAM_INT:PDO::PARAM_STR);
        }
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
    public function getProductsFilteredPaginated(array $opts, int $offset, int $limit): array
    {
        [$sql,$params] = $this->buildProductsFilterSql('p.*, c.name AS category_name', $opts);
        $sql .= ' LIMIT :limit OFFSET :offset';
        $stmt = $this->conn->prepare($sql);
        foreach($params as $k=>$v){
            $stmt->bindValue($k,$v,is_int($v)?PDO::PARAM_INT:PDO::PARAM_STR);
        }
        $stmt->bindValue(':limit',$limit,PDO::PARAM_INT);
        $stmt->bindValue(':offset',$offset,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    private function buildProductsFilterSql(string $select, array $opts): array
    {
        $sql = 'SELECT ' . $select . ' FROM products p INNER JOIN categories c ON p.category_id=c.id WHERE 1=1';
        $params = [];
        if (!empty($opts['q'])) {
            $sql .= ' AND (p.name LIKE :q OR p.slug LIKE :q)';
            $params[':q'] = '%' . $opts['q'] . '%';
        }
        if (!empty($opts['category_id'])) {
            $sql .= ' AND p.category_id = :cid';
            $params[':cid'] = (int)$opts['category_id'];
        }
        if (!empty($opts['has_discount'])) {
            $sql .= ' AND p.discount_percent > 0';
        }
        if ($opts['min_price'] !== '' && $opts['min_price'] !== null) {
            $sql .= ' AND p.price >= :minp';
            $params[':minp'] = (int)$opts['min_price'];
        }
        if ($opts['max_price'] !== '' && $opts['max_price'] !== null) {
            $sql .= ' AND p.price <= :maxp';
            $params[':maxp'] = (int)$opts['max_price'];
        }
        $order = 'p.id ASC';
        if (!empty($opts['sort'])) {
            switch($opts['sort']){
                case 'price_asc': $order='p.price ASC'; break;
                case 'price_desc': $order='p.price DESC'; break;
                case 'newest': $order='p.created_at DESC'; break;
                case 'oldest': $order='p.created_at ASC'; break;
                case 'id_desc': $order='p.id DESC'; break;
                default: $order='p.id ASC';
            }
        }
        $sql .= ' ORDER BY ' . $order;
        return [$sql,$params];
    }
    public function getProduct(int $id)
    {
        $stmt = $this->conn->prepare('SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id=c.id WHERE p.id=:id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function createProduct(array $data): bool
    {
        $sql = 'INSERT INTO products (name, slug, price, category_id, stock, discount_percent, description, image, created_at) VALUES (:name,:slug,:price,:cid,:stock,:disc,:desc,:img, COALESCE(:created_at, NOW()))';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':slug', $data['slug']);
        $stmt->bindValue(':price', (int)$data['price'], PDO::PARAM_INT);
        $stmt->bindValue(':cid', (int)$data['category_id'], PDO::PARAM_INT);
        $stmt->bindValue(':stock', (int)$data['stock'], PDO::PARAM_INT);
        $stmt->bindValue(':disc', (int)$data['discount_percent'], PDO::PARAM_INT);
        $stmt->bindValue(':desc', $data['description']);
        $stmt->bindValue(':img', $data['image']);
        $stmt->bindValue(':created_at', $data['created_at'] ?: null);
        return $stmt->execute();
    }
    public function updateProduct(int $id, array $data): bool
    {
        $sql = 'UPDATE products SET name=:name, slug=:slug, price=:price, category_id=:cid, stock=:stock, discount_percent=:disc, description=:desc' . (isset($data['image']) && $data['image']!=='' ? ', image=:img' : '') . ', created_at = COALESCE(:created_at, created_at) WHERE id=:id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':slug', $data['slug']);
        $stmt->bindValue(':price', (int)$data['price'], PDO::PARAM_INT);
        $stmt->bindValue(':cid', (int)$data['category_id'], PDO::PARAM_INT);
        $stmt->bindValue(':stock', (int)$data['stock'], PDO::PARAM_INT);
        $stmt->bindValue(':disc', (int)$data['discount_percent'], PDO::PARAM_INT);
        $stmt->bindValue(':desc', $data['description']);
        if (isset($data['image']) && $data['image']!=='') { $stmt->bindValue(':img', $data['image']); }
        $stmt->bindValue(':created_at', $data['created_at'] ?: null);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function deleteProduct(int $id): bool
    {
        $stmt = $this->conn->prepare('DELETE FROM products WHERE id=:id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Users & Reviews (readonly)
    public function getUsers(): array
    {
        return $this->conn->query('SELECT id, ho_ten, email, gioi_tinh, ngay_sinh, role FROM users ORDER BY id ASC')->fetchAll();
    }
    public function getUsersPaginated(int $offset, int $limit): array
    {
        $stmt = $this->conn->prepare('SELECT id, ho_ten, email, gioi_tinh, ngay_sinh, role FROM users ORDER BY id ASC LIMIT :limit OFFSET :offset');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function countUsers(): int
    {
        return (int)$this->conn->query('SELECT COUNT(*) FROM users')->fetchColumn();
    }
    public function getReviews(): array
    {
        $sql = 'SELECT r.*, p.name AS product_name, u.ho_ten AS user_name FROM reviews r INNER JOIN products p ON r.product_id=p.id INNER JOIN users u ON r.user_id=u.id ORDER BY r.id ASC';
        return $this->conn->query($sql)->fetchAll();
    }
    public function getReviewsPaginated(int $offset, int $limit): array
    {
        $sql = 'SELECT r.*, p.name AS product_name, u.ho_ten AS user_name FROM reviews r INNER JOIN products p ON r.product_id=p.id INNER JOIN users u ON r.user_id=u.id ORDER BY r.id ASC LIMIT :limit OFFSET :offset';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function countReviews(): int
    {
        return (int)$this->conn->query('SELECT COUNT(*) FROM reviews')->fetchColumn();
    }
}

?>


