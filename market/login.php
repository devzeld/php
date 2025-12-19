<?php
$pdo = require_once "./connect.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT mail, password FROM users WHERE mail = :mail AND password = :password";
    $stmt = $pdo -> prepare($sql);
    $stmt->execute([
        ':username' => $username,
        ':password' => $password
    ]);

    $_SESSION["username"] = $username;
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <title>Registrazione</title>
</head>
<body>

    <form action="login.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="mail" name="mail" required />

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required />

        <button type="submit">Login User</button>
        <button onclick="document.location.href = '<?php echo "login.php"; ?>';">Non ho un account.</button>
    </form>
</body>
</html>

