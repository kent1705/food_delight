CREATE DATABASE IF NOT EXISTS food_delights
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE food_delights;

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL,
  image VARCHAR(255) DEFAULT NULL,
  emoji VARCHAR(20) DEFAULT '🍰',
  active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(150) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  phone VARCHAR(40) DEFAULT NULL,
  address TEXT DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  customer_name VARCHAR(150) NOT NULL,
  customer_email VARCHAR(190) NOT NULL,
  customer_phone VARCHAR(40) DEFAULT NULL,
  delivery_address TEXT,
  total DECIMAL(10,2) NOT NULL,
  status ENUM('Pending','Processing','Completed','Cancelled') NOT NULL DEFAULT 'Pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_orders_user FOREIGN KEY (user_id)
    REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NULL,
  product_name VARCHAR(150) NOT NULL,
  unit_price DECIMAL(10,2) NOT NULL,
  quantity INT NOT NULL,
  subtotal DECIMAL(10,2) NOT NULL,
  CONSTRAINT fk_order_items_order FOREIGN KEY (order_id)
    REFERENCES orders(id) ON DELETE CASCADE,
  CONSTRAINT fk_order_items_product FOREIGN KEY (product_id)
    REFERENCES products(id) ON DELETE SET NULL
);

CREATE TABLE contact_messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_name VARCHAR(150) NOT NULL,
  customer_email VARCHAR(190) NOT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (name, description, price, image, emoji) VALUES
('Strawberry Shortcake','Soft sponge, cream and fresh strawberries.',6.50,'strawberry-shortcake.jpg','🍰'),
('Choco Chip Cookies','Crispy edges, gooey chocolate center.',4.00,'cookies.jpg','🍪'),
('Glazed Donuts','Light, fluffy and dipped in sweet glaze.',3.50,'images.jpg','🍩'),
('Vanilla Cupcake','Topped with buttercream frosting.',3.00,NULL,'🧁'),
('Chocolate Brownie','Rich, fudgy and extra chocolatey.',3.75,NULL,'🍫'),
('Caramel Flan','Silky custard with golden caramel.',5.00,NULL,'🍮');
