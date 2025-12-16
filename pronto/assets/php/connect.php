<?php
$host = 'localhost';
$dbname = 'market';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn = $pdo->query("CREATE TABLE IF NOT EXISTS users(id int NOT NULL PRIMARY KEY AUTO_INCREMENT , username VARCHAR(255) NOT NULL UNIQUE, name VARCHAR(255), surname VARCHAR(255), password VARCHAR(255), create_time DATETIME);");
    $conn = $pdo->query("CREATE TABLE IF NOT EXISTS products(id int NOT NULL PRIMARY KEY AUTO_INCREMENT, product_name VARCHAR(255), stock INT, price INT, create_time DATETIME);");
    $conn = $pdo->query("CREATE TABLE IF NOT EXISTS puchases(id int NOT NULL PRIMARY KEY AUTO_INCREMENT, user_id INT NOT NULL, product_id INT NOT NULL, quantity INT, create_time DATETIME, FOREIGN KEY (user_id) REFERENCES users(id), FOREIGN KEY (product_id) REFERENCES products(id));");

    return $pdo;
} catch (PDOException $e) {
    die("Database connection error: " . $e -> getMessage());
}
