CREATE DATABASE IF NOT EXISTS php_pdo DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE php_pdo;

CREATE TABLE IF NOT EXISTS PRODUCTS (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(80) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO PRODUCTS (name, description, price) VALUES
('Product 1', 'Description for product 1', 19.99),
('Product 2', 'Description for product 2', 29.99),
('Product 3', 'Description for product 3', 39.99),
('Product 4', 'Description for product 4', 49.99),
('Product 5', 'Description for product 5', 59.99);

SELECT * FROM PRODUCTS; 