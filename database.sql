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
    slug VARCHAR(255) UNIQUE NOT NULL,             
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

-- Thêm dữ liệu mẫu để test (danh mục)
INSERT INTO categories (name, slug) VALUES 
('Áo', 'ao'),
('Quần', 'quan'),
('Giày', 'giay'),
('Phụ kiện', 'phu-kien');

-- Thêm dữ liệu mẫu để test (sản phẩm)
INSERT INTO products (name, price, category_id, description, image, stock, slug) VALUES 
('Áo Sơ Mi Nam Đen', 500000, 1, 'Áo sơ mi nam chất liệu cotton, màu đen trắng, thoải mái.', 'uploads/imgproduct/ao-den.jpg', 100, 'ao-so-mi-nam-den'),
('Quần Tây Nam', 600000, 2, 'Quần tây nam slim fit.', 'uploads/imgproduct/quan-tay.jpg', 50, 'quan-tay-nam'),
('Giày Sneaker Nam', 800000, 3, 'Giày sneaker nam thời trang.', 'uploads/imgproduct/giay-sneaker.jpg', 30, 'giay-sneaker-nam'),
('Thắt Lưng Da Nam', 200000, 4, 'Thắt lưng da nam cao cấp.', 'uploads/imgproduct/that-lung.jpg', 80, 'that-lung-da-nam');

-- Thêm dữ liệu mẫu để test (users, bao gồm tài khoản admin)
INSERT INTO users (ho_ten, gioi_tinh, ngay_sinh, email, mat_khau, role) VALUES 
('Nguyễn Văn A', 'Nam', '2000-01-01', 'user@example.com', 'user123', 'user'),
('Admin Test', 'Nam', '1990-01-01', 'admin@example.com', 'admin123', 'admin');

-- Thêm dữ liệu mẫu để test (reviews)
INSERT INTO reviews (product_id, user_id, comment, rating) VALUES 
(1, 1, 'Sản phẩm rất đẹp, chất lượng tốt!', 5),
(1, 2, 'Áo mặc thoải mái, giá hợp lý.', 4),
(2, 1, 'Quần tây đẹp, vừa vặn.', 5);
