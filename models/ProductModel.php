<?php 
// Có class chứa các function thực thi tương tác với cơ sở dữ liệu 
class ProductModel 
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Viết truy vấn danh sách sản phẩm 
    public function getAllProducts()
    {
        $sql = "SELECT p.*, c.name AS category_name FROM products p INNER JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getFeaturedProducts($limit = 6)
    {
        $sql = "SELECT * FROM products ORDER BY id DESC LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProductBySlug($slug)
    {
        $sql = "SELECT * FROM products WHERE slug = :slug LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':slug', $slug);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getRelatedProducts($categoryId, $excludeId, $limit = 8)
    {
        $sql = "SELECT * FROM products WHERE category_id = :cid AND id <> :id LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':cid', (int)$categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':id', (int)$excludeId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProductsByTag($tag)
    {
        $sql = "SELECT p.*, c.name AS category_name FROM products p INNER JOIN categories c ON p.category_id = c.id WHERE c.slug = :slug ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':slug', $tag);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getNewProducts($days = 30)
    {
        $sql = "SELECT p.*, c.name AS category_name
                FROM products p 
                INNER JOIN categories c ON p.category_id = c.id
                WHERE p.created_at >= (NOW() - INTERVAL :days DAY)
                ORDER BY p.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':days', (int)$days, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCategories()
    {
        $sql = "SELECT * FROM categories ORDER BY name";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPromotionProducts($limit = 8)
    {
        // Lấy sản phẩm có discount_percent > 0
        $sql = "SELECT p.*, c.name AS category_name FROM products p INNER JOIN categories c ON p.category_id = c.id WHERE p.discount_percent > 0 ORDER BY p.id DESC LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCategoryBySlug(string $slug)
    {
        $sql = "SELECT * FROM categories WHERE slug = :slug LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':slug', $slug);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function searchProducts(string $keyword)
    {
        $sql = "SELECT p.*, c.name AS category_name
                FROM products p INNER JOIN categories c ON p.category_id = c.id
                WHERE p.name LIKE :kw OR c.name LIKE :kw OR p.slug LIKE :kw
                ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($sql);
        $kw = '%' . $keyword . '%';
        $stmt->bindValue(':kw', $kw);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getFilteredProducts(array $opts)
    {
        $sql = "SELECT p.*, c.name AS category_name
                FROM products p
                INNER JOIN categories c ON p.category_id = c.id
                WHERE 1=1";
        $params = [];

        if (!empty($opts['tag'])) {
            $sql .= " AND c.slug = :tag";
            $params[':tag'] = $opts['tag'];
        }

        if (!empty($opts['q'])) {
            $sql .= " AND (p.name LIKE :kw OR c.name LIKE :kw)";
            $params[':kw'] = '%' . $opts['q'] . '%';
        }

        if (isset($opts['min_price']) && $opts['min_price'] !== '') {
            $sql .= " AND p.price >= :minp";
            $params[':minp'] = (int)$opts['min_price'];
        }
        if (isset($opts['max_price']) && $opts['max_price'] !== '') {
            $sql .= " AND p.price <= :maxp";
            $params[':maxp'] = (int)$opts['max_price'];
        }

        // Frontend promo filter (only discounted products)
        if (!empty($opts['promo'])) {
            $sql .= " AND p.discount_percent > 0";
        }

        $sort = $opts['sort'] ?? '';
        switch ($sort) {
            case 'name_asc':
                $sql .= " ORDER BY p.name ASC"; break;
            case 'name_desc':
                $sql .= " ORDER BY p.name DESC"; break;
            case 'price_asc':
                $sql .= " ORDER BY p.price ASC"; break;
            case 'price_desc':
                $sql .= " ORDER BY p.price DESC"; break;
            case 'oldest':
                $sql .= " ORDER BY p.created_at ASC"; break;
            case 'newest':
                $sql .= " ORDER BY p.created_at DESC"; break;
            default:
                $sql .= " ORDER BY p.id DESC"; break;
        }

        $stmt = $this->conn->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getReviewsByProduct(int $productId)
    {
        $sql = "SELECT r.*, u.ho_ten AS user_name
                FROM reviews r
                INNER JOIN users u ON r.user_id = u.id
                WHERE r.product_id = :pid
                ORDER BY r.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':pid', $productId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function addReview(int $productId, int $userId, string $comment)
    {
        $sql = "INSERT INTO reviews (product_id, user_id, comment) VALUES (:pid, :uid, :cmt)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':pid', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':uid', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':cmt', $comment);
        return $stmt->execute();
    }
}
