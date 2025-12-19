<?php
$pdo = require_once "assets/php/connect.php";

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $product_name = $_POST['product_name'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];

    $sql = "INSERT INTO products (product_name, stock, price, create_time) VALUES (:product_name, :stock, :price, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':product_name' => $product_name,
        ':quantity' => $stock,
        ':price' => $price
    ]);
}

echo "product registered successfully!";
