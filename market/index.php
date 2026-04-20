<?php session_start(); ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Market</title>
</head>
<body>
    <main>
        <div class="form-container" style="text-align:center;">
            <h2>🛒 Market</h2>
            <?php if (isset($_SESSION['username'])): ?>
                <p>Benvenuto, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></p>
                <button onclick="location.href='purchase.php'">Acquista prodotti</button>
                <button onclick="location.href='logout.php'">Esci</button>
            <?php else: ?>
                <button onclick="location.href='register.php'">Registrati</button>
                <button onclick="location.href='login.php'">Accedi</button>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>