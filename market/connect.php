<?php
$host = 'localhost';
$dbname = 'market';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->query("CREATE TABLE IF NOT EXISTS users (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        mail VARCHAR(255) UNIQUE NOT NULL,
        username VARCHAR(255) NOT NULL UNIQUE,
        name VARCHAR(255),
        surname VARCHAR(255),
        password VARCHAR(255) NOT NULL,
        create_time DATETIME
    );");

    $pdo->query("CREATE TABLE IF NOT EXISTS products (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        product_name VARCHAR(255) NOT NULL,
        stock INT DEFAULT 0,
        price DECIMAL(8,2) NOT NULL,
        create_time DATETIME
    );");

    $pdo->query("CREATE TABLE IF NOT EXISTS purchases (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        user_id INT NOT NULL,
        product_id INT NOT NULL,
        quantity INT NOT NULL,
        total_cost DECIMAL(10,2),
        create_time DATETIME,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (product_id) REFERENCES products(id)
    );");

    return $pdo;
} catch (PDOException $e) {
    die("Errore di connessione: " . $e->getMessage());
}