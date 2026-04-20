<?php
$pdo = require_once "./connect.php";
session_start();

$error = '';

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $mail     = trim($_POST['mail']);
    $username = trim($_POST['username']);
    $name     = trim($_POST['name']);
    $surname  = trim($_POST['surname']);
    $password = $_POST['password'];

    try {
        $sql  = "INSERT INTO users (mail, username, name, surname, password, create_time)
                 VALUES (:mail, :username, :name, :surname, :password, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':mail'     => $mail,
            ':username' => $username,
            ':name'     => $name,
            ':surname'  => $surname,
            ':password' => password_hash($password, PASSWORD_BCRYPT),
        ]);
        $_SESSION['username'] = $username;
        $_SESSION['user_id']  = $pdo->lastInsertId();
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        $error = "Errore: email o username già in uso.";
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Registrazione</title>
</head>
<body>
    <main>
        <form class="form-container" action="register.php" method="POST">
            <h2>Registrati</h2>
            <?php if ($error): ?><p style="color:red;text-align:center"><?= $error ?></p><?php endif; ?>

            <label>Email</label>
            <input type="email" name="mail" required />

            <label>Username</label>
            <input type="text" name="username" required />

            <label>Nome</label>
            <input type="text" name="name" />

            <label>Cognome</label>
            <input type="text" name="surname" />

            <label>Password</label>
            <input type="password" name="password" required />

            <button type="submit">Registrati</button>
            <button type="button" onclick="location.href='login.php'">Ho già un account</button>
        </form>
    </main>
</body>
</html>