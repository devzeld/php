<?php
$pdo = require_once "assets/php/connect.php";

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $userId = $_POST['user_id'];
    $productName = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    $sql = "INSERT INTO purchases (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
    $stmt = $pdo -> prepare($sql);
    $stmt->execute([
        ':product_name' => $user_id,
        ':quantity' => $product_id,
        ':price' => $quantity
    ]);

    echo "purchase registered successfully!";
}
