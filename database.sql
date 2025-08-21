CREATE DATABASE IF NOT EXISTS du_an_mau
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE du_an_mau;

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,             
    name VARCHAR(100) NOT NULL,                    
    slug VARCHAR(100) UNIQUE NOT NULL              
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,             
    name VARCHAR(255) NOT NULL,                   
    price INT NOT NULL,                          
    category_id INT NOT NULL,                     
    description TEXT,                              
    image VARCHAR(255) NOT NULL,                   
    stock INT NOT NULL DEFAULT 0,                  
    discount_percent TINYINT NOT NULL DEFAULT 0,   
    slug VARCHAR(255) UNIQUE NOT NULL,            
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,          
    ho_ten VARCHAR(255) NOT NULL,                  
    gioi_tinh ENUM('Nam', 'Nữ', 'Khác') NOT NULL, 
    ngay_sinh DATE NOT NULL,                      
    email VARCHAR(255) UNIQUE NOT NULL,           
    mat_khau VARCHAR(255) NOT NULL,                
    role ENUM('user', 'admin') DEFAULT 'user',    
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    comment TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Seed data
-- Categories
INSERT IGNORE INTO categories (name, slug) VALUES
('Áo phông', 'ao-phong'),
('Áo sơ mi', 'ao-so-mi'),
('Áo khoác', 'ao-khoac'),
('Quần dài', 'quan-dai'),
('Quần ngắn', 'quan-ngan'),
('Phụ kiện', 'phu-kien');

-- Products (sample). Image paths must exist in uploads/img-product/
INSERT INTO products (name, price, category_id, description, image, stock, slug, created_at) VALUES
('Áo phông Basic 1', 250000, (SELECT id FROM categories WHERE slug='ao-phong'), 'Áo phông cotton thoáng mát', 'uploads/img-product/ao-phong/ao-1.jpg', 100, 'ao-phong-basic-1', NOW() - INTERVAL 5 DAY),
('Áo phông Basic 2', 260000, (SELECT id FROM categories WHERE slug='ao-phong'), 'Chất liệu mềm mại, dễ chịu', 'uploads/img-product/ao-phong/ao-2.jpg', 80, 'ao-phong-basic-2', NOW() - INTERVAL 12 DAY),
('Áo phông Graphic', 290000, (SELECT id FROM categories WHERE slug='ao-phong'), 'In họa tiết trẻ trung', 'uploads/img-product/ao-phong/ao-3.jpg', 70, 'ao-phong-graphic', NOW() - INTERVAL 25 DAY),
('Áo phông Oversize', 300000, (SELECT id FROM categories WHERE slug='ao-phong'), 'Form rộng cá tính', 'uploads/img-product/ao-phong/ao-4.jpg', 60, 'ao-phong-oversize', NOW() - INTERVAL 2 DAY),

('Áo sơ mi tay ngắn', 350000, (SELECT id FROM categories WHERE slug='ao-so-mi'), 'Sơ mi tay ngắn linh hoạt', 'uploads/img-product/ao-so-mi/ao-ngan-1.jpg', 50, 'ao-so-mi-tay-ngan', NOW() - INTERVAL 14 DAY),
('Áo sơ mi tay dài', 420000, (SELECT id FROM categories WHERE slug='ao-so-mi'), 'Sơ mi tay dài lịch lãm', 'uploads/img-product/ao-so-mi/ao-dai-1.jpg', 55, 'ao-so-mi-tay-dai', NOW() - INTERVAL 33 DAY),
('Áo sơ mi caro', 390000, (SELECT id FROM categories WHERE slug='ao-so-mi'), 'Họa tiết caro cổ điển', 'uploads/img-product/ao-so-mi/ao-ngan-2.jpg', 45, 'ao-so-mi-caro', NOW() - INTERVAL 7 DAY),

('Áo khoác gió', 550000, (SELECT id FROM categories WHERE slug='ao-khoac'), 'Chống gió nhẹ, phù hợp đi chơi', 'uploads/img-product/ao-khoac/ao-1.jpg', 40, 'ao-khoac-gio', NOW() - INTERVAL 9 DAY),
('Áo khoác bomber', 650000, (SELECT id FROM categories WHERE slug='ao-khoac'), 'Phong cách trẻ trung', 'uploads/img-product/ao-khoac/ao-2.jpg', 35, 'ao-khoac-bomber', NOW() - INTERVAL 60 DAY),
('Áo khoác denim', 700000, (SELECT id FROM categories WHERE slug='ao-khoac'), 'Chất liệu denim bền bỉ', 'uploads/img-product/ao-khoac/ao-3.jpg', 30, 'ao-khoac-denim', NOW() - INTERVAL 20 DAY),

('Quần jean slim', 520000, (SELECT id FROM categories WHERE slug='quan-dai'), 'Ôm vừa tôn dáng', 'uploads/img-product/quan-dai/quan-jean.jpg', 70, 'quan-jean-slim', NOW() - INTERVAL 11 DAY),
('Quần kaki', 480000, (SELECT id FROM categories WHERE slug='quan-dai'), 'Thoáng mát, dễ phối', 'uploads/img-product/quan-dai/quan-kaki.jpg', 65, 'quan-kaki-basic', NOW() - INTERVAL 3 DAY),
('Quần âu', 590000, (SELECT id FROM categories WHERE slug='quan-dai'), 'Lịch lãm công sở', 'uploads/img-product/quan-dai/quan-au.jpg', 50, 'quan-au-classic', NOW() - INTERVAL 45 DAY),

('Quần short jean', 350000, (SELECT id FROM categories WHERE slug='quan-ngan'), 'Năng động mùa hè', 'uploads/img-product/quan-ngan/quan-1.jpg', 90, 'quan-short-jean', NOW() - INTERVAL 6 DAY),
('Quần short kaki', 330000, (SELECT id FROM categories WHERE slug='quan-ngan'), 'Thoải mái, dễ chịu', 'uploads/img-product/quan-ngan/quan-2.jpg', 85, 'quan-short-kaki', NOW() - INTERVAL 1 DAY),
('Quần short thể thao', 310000, (SELECT id FROM categories WHERE slug='quan-ngan'), 'Vận động linh hoạt', 'uploads/img-product/quan-ngan/quan-3.jpg', 75, 'quan-short-the-thao', NOW() - INTERVAL 10 DAY),

('Thắt lưng da', 260000, (SELECT id FROM categories WHERE slug='phu-kien'), 'Da PU bền đẹp', 'uploads/img-product/phu-kien/that-lung.jpg', 100, 'phu-kien-that-lung', NOW() - INTERVAL 8 DAY),
('Ví da', 290000, (SELECT id FROM categories WHERE slug='phu-kien'), 'Ví gấp nhỏ gọn', 'uploads/img-product/phu-kien/vi.jpg', 95, 'phu-kien-vi-da', NOW() - INTERVAL 4 DAY),
('Kính mát', 320000, (SELECT id FROM categories WHERE slug='phu-kien'), 'Bảo vệ mắt, thời trang', 'uploads/img-product/phu-kien/kinh.jpg', 120, 'phu-kien-kinh-mat', NOW() - INTERVAL 16 DAY);

-- Sản phẩm khuyến mãi mẫu (dùng discount_percent)
INSERT INTO products (name, price, category_id, description, image, stock, discount_percent, slug, created_at) VALUES
('Áo phông Sale 1', 300000, (SELECT id FROM categories WHERE slug='ao-phong'), 'Áo phông chất liệu cotton, form thoải mái, collection giảm giá.', 'uploads/img-product/ao-phong/ao-6.jpg', 50, 20, 'ao-phong-sale-1', NOW() - INTERVAL 5 DAY),
('Áo sơ mi Sale 1', 450000, (SELECT id FROM categories WHERE slug='ao-so-mi'), 'Áo sơ mi dài tay lịch lãm, chất vải mát.', 'uploads/img-product/ao-so-mi/ao-dai-2.jpg', 40, 15, 'ao-so-mi-sale-1', NOW() - INTERVAL 10 DAY),
('Áo khoác Sale 1', 750000, (SELECT id FROM categories WHERE slug='ao-khoac'), 'Áo khoác thời trang, giữ ấm tốt.', 'uploads/img-product/ao-khoac/ao-4.jpg', 30, 25, 'ao-khoac-sale-1', NOW() - INTERVAL 8 DAY),
('Quần dài Sale 1', 520000, (SELECT id FROM categories WHERE slug='quan-dai'), 'Quần jean slim trẻ trung.', 'uploads/img-product/quan-dai/quan-jean.jpg', 60, 20, 'quan-dai-sale-1', NOW() - INTERVAL 6 DAY),
('Quần ngắn Sale 1', 350000, (SELECT id FROM categories WHERE slug='quan-ngan'), 'Quần short năng động ngày hè.', 'uploads/img-product/quan-ngan/quan-2.jpg', 70, 10, 'quan-ngan-sale-1', NOW() - INTERVAL 4 DAY),
('Phụ kiện Sale 1', 260000, (SELECT id FROM categories WHERE slug='phu-kien'), 'Thắt lưng da bền bỉ, dễ phối đồ.', 'uploads/img-product/phu-kien/that-lung.jpg', 80, 30, 'phu-kien-sale-1', NOW() - INTERVAL 2 DAY);

-- Người dùng mẫu để viết đánh giá
INSERT INTO users (ho_ten, gioi_tinh, ngay_sinh, email, mat_khau, role) VALUES
('Trần Minh Khoa', 'Nam', '1995-02-10', 'khoa.demo@example.com', '123456', 'user'),
('Nguyễn Thu Hà', 'Nữ', '1997-07-21', 'ha.demo@example.com', '123456', 'user'),
('Lê Quang Huy', 'Nam', '1994-11-03', 'huy.demo@example.com', '123456', 'user'),
('Phạm Thị Lan', 'Nữ', '1998-04-18', 'lan.demo@example.com', '123456', 'user'),
('Vũ Đức Long', 'Nam', '1993-09-09', 'long.demo@example.com', '123456', 'user'),
('Đặng Bảo Yến', 'Nữ', '1999-12-12', 'yen.demo@example.com', '123456', 'user');

-- Mỗi sản phẩm khuyến mãi 1 bình luận
INSERT INTO reviews (product_id, user_id, comment) VALUES
((SELECT id FROM products WHERE slug='ao-phong-sale-1'), (SELECT id FROM users WHERE email='khoa.demo@example.com'), 'Áo phông mặc rất mát và form chuẩn.'),
((SELECT id FROM products WHERE slug='ao-so-mi-sale-1'), (SELECT id FROM users WHERE email='ha.demo@example.com'), 'Sơ mi chất lượng tốt, đường may tỉ mỉ.'),
((SELECT id FROM products WHERE slug='ao-khoac-sale-1'), (SELECT id FROM users WHERE email='huy.demo@example.com'), 'Áo khoác dày dặn, giữ ấm tốt.'),
((SELECT id FROM products WHERE slug='quan-dai-sale-1'), (SELECT id FROM users WHERE email='lan.demo@example.com'), 'Quần jean co giãn nhẹ, mặc thoải mái.'),
((SELECT id FROM products WHERE slug='quan-ngan-sale-1'), (SELECT id FROM users WHERE email='long.demo@example.com'), 'Quần short phù hợp đi dạo, thể thao.'),
((SELECT id FROM products WHERE slug='phu-kien-sale-1'), (SELECT id FROM users WHERE email='yen.demo@example.com'), 'Thắt lưng da đẹp, màu sắc dễ phối.');

-- Bổ sung sản phẩm cho tất cả ảnh còn lại trong uploads/img-product
INSERT INTO products (name, price, category_id, description, image, stock, slug, created_at) VALUES
-- Ao phong 5-8
('Áo phông Basic 5', 270000, (SELECT id FROM categories WHERE slug='ao-phong'), 'Áo phông cotton thoáng mát', 'uploads/img-product/ao-phong/ao-5.jpg', 60, 'ao-phong-basic-5', NOW() - INTERVAL 18 DAY),
('Áo phông Basic 6', 270000, (SELECT id FROM categories WHERE slug='ao-phong'), 'Áo phông cotton thoáng mát', 'uploads/img-product/ao-phong/ao-6.jpg', 55, 'ao-phong-basic-6', NOW() - INTERVAL 9 DAY),
('Áo phông Basic 7', 280000, (SELECT id FROM categories WHERE slug='ao-phong'), 'Áo phông cotton thoáng mát', 'uploads/img-product/ao-phong/ao-7.jpg', 58, 'ao-phong-basic-7', NOW() - INTERVAL 28 DAY),
('Áo phông Basic 8', 280000, (SELECT id FROM categories WHERE slug='ao-phong'), 'Áo phông cotton thoáng mát', 'uploads/img-product/ao-phong/ao-8.jpg', 52, 'ao-phong-basic-8', NOW() - INTERVAL 22 DAY),

-- Ao so mi còn lại
('Áo sơ mi tay dài 2', 430000, (SELECT id FROM categories WHERE slug='ao-so-mi'), 'Sơ mi tay dài lịch lãm', 'uploads/img-product/ao-so-mi/ao-dai-2.jpg', 45, 'ao-so-mi-tay-dai-2', NOW() - INTERVAL 26 DAY),
('Áo sơ mi tay dài 3', 440000, (SELECT id FROM categories WHERE slug='ao-so-mi'), 'Sơ mi tay dài lịch lãm', 'uploads/img-product/ao-so-mi/ao-dai-3.jpg', 42, 'ao-so-mi-tay-dai-3', NOW() - INTERVAL 19 DAY),
('Áo sơ mi tay ngắn 2', 360000, (SELECT id FROM categories WHERE slug='ao-so-mi'), 'Sơ mi tay ngắn linh hoạt', 'uploads/img-product/ao-so-mi/ao-ngan-3.jpg', 48, 'ao-so-mi-tay-ngan-2', NOW() - INTERVAL 8 DAY),
('Áo sơ mi tay ngắn 3', 360000, (SELECT id FROM categories WHERE slug='ao-so-mi'), 'Sơ mi tay ngắn linh hoạt', 'uploads/img-product/ao-so-mi/ao-ngan-4.jpg', 46, 'ao-so-mi-tay-ngan-3', NOW() - INTERVAL 13 DAY),
('Áo sơ mi tay ngắn 4', 360000, (SELECT id FROM categories WHERE slug='ao-so-mi'), 'Sơ mi tay ngắn linh hoạt', 'uploads/img-product/ao-so-mi/ao-ngan-5.jpg', 44, 'ao-so-mi-tay-ngan-4', NOW() - INTERVAL 5 DAY),

-- Ao khoac còn lại
('Áo khoác dạ', 750000, (SELECT id FROM categories WHERE slug='ao-khoac'), 'Ấm áp mùa đông', 'uploads/img-product/ao-khoac/ao-4.jpg', 25, 'ao-khoac-da', NOW() - INTERVAL 35 DAY),
('Áo khoác hoodie', 590000, (SELECT id FROM categories WHERE slug='ao-khoac'), 'Hoodie ấm áp, thoải mái', 'uploads/img-product/ao-khoac/ao-5.jpg', 40, 'ao-khoac-hoodie', NOW() - INTERVAL 21 DAY),
('Áo khoác puffer', 820000, (SELECT id FROM categories WHERE slug='ao-khoac'), 'Giữ nhiệt tốt', 'uploads/img-product/ao-khoac/ao-6.jpg', 22, 'ao-khoac-puffer', NOW() - INTERVAL 15 DAY),
('Áo khoác trench', 900000, (SELECT id FROM categories WHERE slug='ao-khoac'), 'Phong cách cổ điển', 'uploads/img-product/ao-khoac/ao-7.jpg', 18, 'ao-khoac-trench', NOW() - INTERVAL 40 DAY),
('Áo khoác leather', 980000, (SELECT id FROM categories WHERE slug='ao-khoac'), 'Da PU sang trọng', 'uploads/img-product/ao-khoac/ao-8.jpg', 16, 'ao-khoac-leather', NOW() - INTERVAL 55 DAY),

-- Quan dai còn lại
('Quần jean slim 2', 530000, (SELECT id FROM categories WHERE slug='quan-dai'), 'Ôm vừa tôn dáng', 'uploads/img-product/quan-dai/quan-jean2.jpg', 62, 'quan-jean-slim-2', NOW() - INTERVAL 14 DAY),
('Quần rằn ri', 560000, (SELECT id FROM categories WHERE slug='quan-dai'), 'Hoa văn cá tính', 'uploads/img-product/quan-dai/quan-ran-ri.jpg', 40, 'quan-ran-ri', NOW() - INTERVAL 17 DAY),
('Quần thun jogger', 450000, (SELECT id FROM categories WHERE slug='quan-dai'), 'Thoải mái vận động', 'uploads/img-product/quan-dai/quan-thun.jpg', 75, 'quan-thun-jogger', NOW() - INTERVAL 6 DAY),
('Quần túi hộp', 490000, (SELECT id FROM categories WHERE slug='quan-dai'), 'Nhiều túi tiện dụng', 'uploads/img-product/quan-dai/quan-tui-hop.jpg', 58, 'quan-tui-hop', NOW() - INTERVAL 23 DAY),

-- Quan ngan còn lại
('Quần short 4', 320000, (SELECT id FROM categories WHERE slug='quan-ngan'), 'Năng động mùa hè', 'uploads/img-product/quan-ngan/quan-4.jpg', 88, 'quan-short-4', NOW() - INTERVAL 9 DAY),
('Quần short 5', 320000, (SELECT id FROM categories WHERE slug='quan-ngan'), 'Năng động mùa hè', 'uploads/img-product/quan-ngan/quan-5.jpg', 84, 'quan-short-5', NOW() - INTERVAL 12 DAY),
('Quần short 6', 320000, (SELECT id FROM categories WHERE slug='quan-ngan'), 'Năng động mùa hè', 'uploads/img-product/quan-ngan/quan-6.jpg', 82, 'quan-short-6', NOW() - INTERVAL 2 DAY),
('Quần short 7', 320000, (SELECT id FROM categories WHERE slug='quan-ngan'), 'Năng động mùa hè', 'uploads/img-product/quan-ngan/quan-7.jpg', 80, 'quan-short-7', NOW() - INTERVAL 30 DAY),

-- Phu kien còn lại
('Balo thời trang', 450000, (SELECT id FROM categories WHERE slug='phu-kien'), 'Dung tích lớn, bền bỉ', 'uploads/img-product/phu-kien/balo.jpg', 70, 'phu-kien-balo', NOW() - INTERVAL 20 DAY),
('Mũ lưỡi trai', 220000, (SELECT id FROM categories WHERE slug='phu-kien'), 'Phong cách thể thao', 'uploads/img-product/phu-kien/mu.jpg', 110, 'phu-kien-mu-luoi-trai', NOW() - INTERVAL 18 DAY);

-- 10 bình luận mẫu cho 10 sản phẩm khác
INSERT INTO reviews (product_id, user_id, comment) VALUES
((SELECT id FROM products WHERE slug='ao-phong-basic-1'), (SELECT id FROM users WHERE email='khoa.demo@example.com'), 'Màu sắc trẻ trung, chất vải ổn.'),
((SELECT id FROM products WHERE slug='ao-phong-basic-2'), (SELECT id FROM users WHERE email='ha.demo@example.com'), 'Đúng size, mặc thoải mái cả ngày.'),
((SELECT id FROM products WHERE slug='ao-phong-graphic'), (SELECT id FROM users WHERE email='huy.demo@example.com'), 'Hình in đẹp, không bị phai.'),
((SELECT id FROM products WHERE slug='ao-phong-oversize'), (SELECT id FROM users WHERE email='lan.demo@example.com'), 'Form oversize đúng ý, phối đồ dễ.'),
((SELECT id FROM products WHERE slug='ao-so-mi-tay-ngan'), (SELECT id FROM users WHERE email='long.demo@example.com'), 'Vải mát, phù hợp đi làm.'),
((SELECT id FROM products WHERE slug='ao-so-mi-tay-dai'), (SELECT id FROM users WHERE email='yen.demo@example.com'), 'Sơ mi đứng form, chất lượng tốt.'),
((SELECT id FROM products WHERE slug='ao-khoac-gio'), (SELECT id FROM users WHERE email='khoa.demo@example.com'), 'Chống gió tốt, nhẹ và bền.'),
((SELECT id FROM products WHERE slug='quan-jean-slim'), (SELECT id FROM users WHERE email='ha.demo@example.com'), 'Quần jean ôm vừa, không khó chịu.'),
((SELECT id FROM products WHERE slug='quan-kaki-basic'), (SELECT id FROM users WHERE email='huy.demo@example.com'), 'Quần kaki mịn, dễ phối.'),
((SELECT id FROM products WHERE slug='phu-kien-vi-da'), (SELECT id FROM users WHERE email='lan.demo@example.com'), 'Ví gọn, ngăn chia hợp lý.');
