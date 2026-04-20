<?php
$pdo = require_once "./connect.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = '';
$total_cost = null;

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $product_id = (int)$_POST['product_id'];
    $quantity   = (int)$_POST['quantity'];
    $user_id    = $_SESSION['user_id'];

    $stmt = $pdo->prepare("SELECT product_name, price, stock FROM products WHERE id = :id");
    $stmt->execute([':id' => $product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product && $quantity > 0 && $quantity <= $product['stock']) {
        $total_cost = $product['price'] * $quantity;

        $stmt = $pdo->prepare(
            "INSERT INTO purchases (user_id, product_id, quantity, total_cost, create_time)
             VALUES (:user_id, :product_id, :quantity, :total_cost, NOW())"
        );
        $stmt->execute([
            ':user_id'    => $user_id,
            ':product_id' => $product_id,
            ':quantity'   => $quantity,
            ':total_cost' => $total_cost,
        ]);

        $pdo->prepare("UPDATE products SET stock = stock - :q WHERE id = :id")
            ->execute([':q' => $quantity, ':id' => $product_id]);

        $message = "Acquisto completato! Prodotto: <strong>" . htmlspecialchars($product['product_name']) .
                   "</strong> × {$quantity} = <strong>€" . number_format($total_cost, 2) . "</strong>";
    } else {
        $message = "Quantità non disponibile o prodotto non valido.";
    }
}

$products = $pdo->query("SELECT id, product_name, price, stock FROM products WHERE stock > 0")
                ->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Acquisto prodotti</title>
</head>
<body>
    <main>
        <form class="form-container" action="purchase.php" method="POST">
            <h2>Acquista</h2>
            <p style="text-align:center;margin-bottom:16px">
                Cliente: <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>
            </p>

            <?php if ($message): ?>
                <p style="background:#f0fdf4;border:1px solid #86efac;padding:10px;border-radius:8px;text-align:center;margin-bottom:16px">
                    <?= $message ?>
                </p>
            <?php endif; ?>

            <label>Prodotto</label>
            <select name="product_id" required style="width:100%;padding:12px;margin-bottom:14px;border-radius:10px;border:1px solid #ddd;font-size:14px">
                <?php foreach ($products as $p): ?>
                    <option value="<?= $p['id'] ?>">
                        <?= htmlspecialchars($p['product_name']) ?> — €<?= number_format($p['price'], 2) ?> (stock: <?= $p['stock'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Quantità</label>
            <input type="number" name="quantity" min="1" value="1" required />

            <button type="submit">Acquista</button>
            <button type="button" onclick="location.href='index.php'">← Home</button>
        </form>
    </main>
</body>
</html>