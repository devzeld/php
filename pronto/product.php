<?php
$pdo = require_once "assets/php/connect.php";

function input_product_data($pdo) {
    if ($_SERVER["REQUEST_METHOD"] === 'POST') {
        $product_name = $_POST['product_name'];
        $stock = $_POST['stock'];
        $price = $_POST['price'];

        $sql = "INSERT INTO product (product_name, stock, price) VALUES (:product_name, :stock, :price)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':product_name' => $product_name,
            ':quantity' => $stock,
            ':price' => $price
        ]);
    }
}
echo input_product_data($pdo);
