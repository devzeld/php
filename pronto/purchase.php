<?php
$pdo = require "assets/php/connect.php";

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_name'];
    $quantity = $_POST['quantity'];

    $sql = "INSERT INTO purchases (user_id, product_id, quantity, create_time) VALUES (:user_id, :product_id, :quantity, NOW())";
    $stmt = $pdo -> prepare($sql);
    $stmt->execute([
        ':product_name' => $user_id,
        ':quantity' => $product_id,
        ':price' => $quantity
    ]);
}
?>
<form>
    <?php
        $products = $pdo -> query("SELECT id, product_name FROM products") -> fetchAll(PDO::FETCH_ASSOC);
        foreach ($products as $product) {
            echo '<option value="' . htmlspecialchars($product['id']) . '">' . htmlspecialchars($product['product_name']) . '</option>';
        }
     ?>
</form>
