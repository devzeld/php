<?php
$host = 'localhost';
$dbname = 'supermercato';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Errore di connessione al database: " . $e->getMessage());
}

$statements = [
    'CREATE DATABASE IF NOT EXISTS supermercato;,
    );',
    'CREATE TABLE IF NOT EXISTS purchases (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        product_name VARCHAR(255) NOT NULL,
        quantity INT NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        purchase_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );'
    ];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $productName = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    $sql = "INSERT INTO purchases (user_id, product_name, quantity, price) VALUES (:user_id, :product_name, :quantity, :price)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':user_id' => $userId,
        ':product_name' => $productName,
        ':quantity' => $quantity,
        ':price' => $price
    ]);

    echo "Acquisto registrato con successo!";
}
?>



