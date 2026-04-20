<?php
session_start();
require_once __DIR__ . '/../../config/connect.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("SELECT tessera_id, email, password FROM soci WHERE email = ?");
    $stmt->execute([$_POST['email']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['tessera_id'] = $user['tessera_id'];
        header('Location: ../dashboard.php');
        exit;
    } else {
        $error = "Credenziali non valide.";
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/global.css">
    <title>Login</title>
</head>
<body>
    <form action="login.php" method="POST">
        <h2>Accedi</h2>
        <?php if ($error): ?><p style="color:red;text-align:center;font-size:14px"><?= $error ?></p><?php endif; ?>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Accedi</button>
        <div style="text-align:center;margin-top:12px;font-size:14px">
            <a href="register.php">Non hai un account? Registrati</a>
        </div>
    </form>
</body>
</html>