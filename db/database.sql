
DROP DATABASE IF EXISTS php_pdo;
CREATE DATABASE IF NOT EXISTS php_pdo;

USE php_pdo;

DROP TABLE products;
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(80) NOT NULL,
    price DECIMAL(10, 2) NOT NULL
);

DROP TABLE campers;
CREATE TABLE campers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    edad INT NOT NULL,
    documento VARCHAR(30) UNIQUE NOT NULL,
    tipo_documento VARCHAR(20) NOT NULL,
    nivel_ingles TINYINT DEFAULT 0,
    nivel_programacion TINYINT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO campers (nombre, edad, documento, tipo_documento, nivel_ingles, nivel_programacion)
VALUES 
('Ana María Ríos', 19, '1001234567', 'Cédula', 4, 3),
('Luis Alberto Peña', 22, '1002234568', 'Cédula', 3, 4),
('Camila Torres', 20, '1003234569', 'Cédula', 5, 5),
('Carlos Méndez', 18, '1004234570', 'TI', 2, 1),
('Laura Galvis', 21, '1005234571', 'Cédula', 3, 3),
('Diego Suárez', 24, '1006234572', 'Cédula', 1, 2),
('Valentina López', 20, '1007234573', 'Cédula', 4, 4),
('Andrés Gómez', 23, '1008234574', 'Pasaporte', 2, 3),
('María Fernanda Ruiz', 25, '1009234575', 'Cédula', 5, 5),
('Jhonatan Páez', 19, '1010234576', 'Cédula', 3, 2);

INSERT INTO products (name, price) VALUES 
('Laptop', 1200.00),
('Smartphone', 800.00),
('Tablet', 300.00),
('Smartwatch', 200.00),
('Headphones', 150.00),
('Bluetooth Speaker', 100.00),
('Camera', 500.00),
('Drone', 600.00),
('Monitor', 250.00),
('Keyboard and Mouse Set', 80.00);

SELECT * FROM campers;