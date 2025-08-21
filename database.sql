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


