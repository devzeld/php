<?php
$pdo = require_once "./connect.php";
session_start();

$error = '';

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $mail     = trim($_POST['mail']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE mail = :mail");
    $stmt->execute([':mail' => $mail]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id']  = $user['id'];
        header("Location: index.php");
        exit();
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
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Login</title>
</head>
<body>
    <main>
        <form class="form-container" action="login.php" method="POST">
            <h2>Accedi</h2>
            <?php if ($error): ?><p style="color:red;text-align:center"><?= $error ?></p><?php endif; ?>

            <label>Email</label>
            <input type="email" name="mail" required />

            <label>Password</label>
            <input type="password" name="password" required />

            <button type="submit">Accedi</button>
            <button type="button" onclick="location.href='register.php'">Non ho un account</button>
        </form>
    </main>
</body>
</html>